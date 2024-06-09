<?php 
    include('admin/inc/db_config.php');
    include('admin/inc/essentials.php');

    if(isset($_GET['confirm_verification'])){
        $data = filteration($_GET);
        
        $users = select("SELECT * FROM `user_cre` WHERE `email`=? AND `token`=? LIMIT 1", [$data['email'], $data['token']], 'ss');

        if(mysqli_num_rows($users) == 1){
            $fetch = mysqli_fetch_assoc($users);
            if($fetch['is_verified'] == 1){
                echo "<script>alert('Account has been already verified!')</script>";
                redirect('index.php');
            }
            else{
                $result = update("UPDATE `user_cre` SET `is_verified`=1 WHERE `email`=? AND `token`=?", [$data['email'], $data['token']], 'ss');
                if ($result == 1)echo 'Account was verified. Sign in now';
                else echo 'Something wrong, try again';
            }
        }
        else{
            echo "<script>alert('Invalid link!')</script>";
            redirect('index.php');
        }
    }
?>