<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Admin Dashboard</title>
    <?php include('inc/links.php'); ?>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php include('inc/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 ms-auto overflow-hidden p-2">
                <h3 class="mb-4 text-dark fw-bold align-items-center">Người dùng</h3>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive-md" style="height: 450px; overflow-y:scroll">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="text-light bg-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Họ và tên</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Số điện thoại</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col">Ngày sinh</th>
                                        <th scope="col">Xác thực</th>
                                        <th scope="col">Tình trạng (khóa tài khoản)</th>
                                        <th scope="col">Ngày đăng ký</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="user-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function changeStatus(id, val){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/users_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success', 'Change status successfully!');
                    get_all_users();
                }
                else alert('error', 'Fail to change status!');
            }

            xhr.send('changeStatus='+id+'&value='+val);
        }

        function get_all_users(){
            let data = new FormData();

            data.append('get_all_users','');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/users_crud.php", true);

            xhr.onload = function(){              
                document.getElementById('user-data').innerHTML = this.responseText;
            };

            xhr.send(data);
        }

        function rem_user(id){
            if (confirm('Are you sure you want to remove this user?')) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/users_crud.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function(){             
                    if(this.responseText == 1){
                        alert('success', 'User removed!!');
                        get_all_users();
                    }
                    else alert('error', 'Fail to remove user!!');
                };

                xhr.send('rem_user='+id);
            } 
        }

        window.onload = function(){
            get_all_users();
        }
    </script>

    <?php include('inc/scripts.php') ?>
</body>
</html>