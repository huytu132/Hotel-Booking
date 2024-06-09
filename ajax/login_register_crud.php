<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require_once '../vendor/autoload.php';

    function send_mail($email, $name, $token, $type){
        if($type == 'confirm_verification'){
            $page = 'register_verify.php';
            $subject = 'Account Verification!';
            $content = 'You have registered from Hotel website, confirm now!';
        }
        else if($type = 'reset_password'){
            $page = 'reset_password.php';
            $subject = 'Reset Password!';
            $content = 'Reset password email was sent to you!';
        }

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                  //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'huytugod@gmail.com';                     //SMTP username
        $mail->Password   = 'eute qeev zvhk juqz';                               //SMTP password
        $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        //Recipients
        $mail->setFrom('duca.105bn@gmail.com', 'Hotel');
        $mail->addAddress($email, $name);          

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;

        $email_template = "
            <h2>$content</h2>
            <a href='http://localhost/tuts/Hotel/$page?$type&email=$email&token=$token'>Click here</a>
        ";

        $mail->Body = $email_template;

        if($mail->send())return 1;
        else return 0;
    }

    if(isset($_POST['register'])){
        $token = md5(rand());
        $data = filteration($_POST);
        if ($data['pass'] != $data['cpass']){
            echo 'pass_missmatch';
            exit;
        }

        $u_exist = select("SELECT * FROM `user_cre` where `phoneNumber`=? AND `email`=? LIMIT 1", [$data['phone'], $data['email']], 'ss');

        if(mysqli_num_rows($u_exist) != 0){
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo ($data['email'] == $u_exist_fetch['email']) ? 'email_already' : 'phone_already';
            exit;
        }

        $image = uploadUserImage($_FILES['profile']);

        if($image == 'inv_img'){
            echo 'inv_img';
            exit;
        }
        else if($image == 'upd_fail'){
            echo 'upd_fail';
            exit;
        }

        if(!send_mail($data['email'], $data['name'], $token, 'confirm_verification')){
            echo 'mail_failed';
            exit;
        }

        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO `user_cre`(`name`, `address`, `phoneNumber`, `email`, `pincode`, `dob`, `profile`, `password`, `token`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $values = [$data['name'], $data['address'], $data['phone'], $data['email'], $data['pincode'], $data['dob'], $image, $enc_pass, $token];
        if(insert($sql, $values, 'sssssssss')){
            echo 1;
        }
        else echo 'ins_failed';
    }

    if(isset($_POST['login'])){
        $data = filteration($_POST);
        $user = select("SELECT * FROM `user_cre` WHERE `email`=? OR `phoneNumber`=? LIMIT 1", [$data['email_phone'], $data['email_phone']], 'ss');

        if(mysqli_num_rows($user) == 1){
            $u_fetch = mysqli_fetch_assoc($user);
            if($u_fetch['is_verified'] == 0){
                echo 'not_verified';
            }
            else if($u_fetch['status'] == 0){
                echo 'inactive';
            }
            else{
                if(!password_verify($data['pass'], $u_fetch['password'])){
                    echo 'inv_user';
                }
                else{
                    session_start();
                    update("UPDATE `user_cre` SET `active` = 1 WHERE `id`=?", [$u_fetch['id']], 'i');
                    $_SESSION['login'] = true;
                    $_SESSION['uID'] = $u_fetch['id'];
                    $_SESSION['uName'] = $u_fetch['name'];
                    $_SESSION['uProfile'] = $u_fetch['profile'];
                    echo 1;
                }
            }
        }
        else{
            echo 'inv_user';
        }
    }

    if(isset($_POST['forgotPass'])){
        $data = filteration($_POST);

        $user = select("SELECT * FROM `user_cre` WHERE `email`=? LIMIT 1", [$data['email']], 's');

        if(mysqli_num_rows($user) == 0){
            echo 'inv_user';
        }
        else{
            $u_fetch = mysqli_fetch_assoc($user);
            if($u_fetch['is_verified'] == 0){
                echo 'not_verified';
            }
            else if($u_fetch['status'] == 0){
                echo 'inactive';
            }
            else{
                $token = md5(rand());
                if(!send_mail($data['email'], $u_fetch['name'], $token, 'reset_password')){
                    echo 'mail_failed';
                }
                else{
                    $t_expire = date('Y-m-d');
                    $query = mysqli_query($conn, "UPDATE `user_cre` SET `token`='$token',`t_expire`='$t_expire' WHERE `id`='$u_fetch[id]'");
                    if($query)echo 1;
                    else echo 'upd_failed';
                }
            }
        }
    }

    if(isset($_POST['resetPass'])){
        $data = filteration($_POST);
        if ($data['pass'] != $data['cpass']){
            echo 'pass_missmatch';
            exit;
        }

        $user = select("SELECT * FROM `user_cre` WHERE `email`=? LIMIT 1", [$data['email']], 's');
        $u_fetch = mysqli_fetch_assoc($user);

        $date = date('Y-m-d');

        if($date != $u_fetch['t_expire']){
            echo 'inv_link';
            exit;
        }

        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $query = mysqli_query($conn, "UPDATE `user_cre` SET `password`='$enc_pass' WHERE `email`='$data[email]' AND `token`='$data[token]'");
        if($query){
            echo 1;
        }
        else echo 'upd_failed';
    }

    if(isset($_POST['resetLoggedUser'])){
        $data = filteration($_POST);
        if ($data['pass'] != $data['cpass']){
            echo 'pass_missmatch';
            exit;
        }
        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $query = mysqli_query($conn, "UPDATE `user_cre` SET `password`='$enc_pass' WHERE `id` = '$_POST[uID]'");
        if($query){
            echo 1;
        }
        else echo 'upd_failed';
    }

    
?>