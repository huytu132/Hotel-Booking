<?php
    include('inc/essentials.php');
    include('inc/db_config.php');

    session_start();
    if(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true){
        echo "<script>
            window.location.href='dashboard.php';
        </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('inc/links.php') ?>
    <title>Admin Login Panel</title>
    <style>
        .login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="login-form bg-white shadow p-5 rounded">
        <form method="POST" >
            <h4 class="text-center">Admin Login Page</h4>
            <div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="admin_name" type="text" class="form-control shadow-none" required>
                </div>
                <div class="mb-3"> 
                    <label class="form-label">Password</label>
                    <input name="admin_password" type="password" class="form-control shadow-none" required>
                </div>
            </div>
            <button name="login" type="submit" class="btn text-white custom-bg shadow-none">Login</button>
        </form>
    </div>

    <?php 

        if(isset($_POST['login'])){
            $filter_data = filteration($_POST);
            
            $query = "SELECT * FROM `admin_cre` WHERE `admin_name`=? AND `admin_pass`=?;";
            $values = [$filter_data['admin_name'], $filter_data['admin_password']];
            
            $res = select($query, $values, "ss");
            
            if($res->num_rows == 1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminId'] = $row['admin_id']; 
                alert('success', 'Login successfully');
                redirect('dashboard.php');
            }
            else{
                alert('error', 'Login failed - Invalid credentials');
            }
        }

    ?>

    <?php include('inc/scripts.php') ?>
</body>
</html>