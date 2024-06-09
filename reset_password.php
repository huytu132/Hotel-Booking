<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require('inc/links.php'); ?>
    <style>
        .pop:hover{
            border-top-color: #279e8c !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php include('./inc/header.php'); ?>

    <?php
        if(isset($_SESSION['login']) && $_SESSION['login'] == 'true'){
            echo <<<data
                <div class="container mt-5 pt-4 mb-4 d-flex justify-content-between">
                    <div class="heading">
                        <h2>ĐỔI MẬT KHẨU</h2>
                    </div>
                </div>
                
                <div class="container shadow mb-3" >
                    <div class="row">
                        <form id="reset-form-session">
                            <div class="mb-3">
                                <label for="pass">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="pass">
                            </div>
            
                            <div class="mb-3">
                                <label for="cpass">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" name="cpass">
                            </div>
            
                            <input type="hidden" name="user_id" value=$_SESSION[uID]>
            
                            <div class="mb-3">
                                <button type="submit" class="btn custom-bg">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            data;

            echo "<script>
                let reset_form_session = document.getElementById('reset-form-session');
                reset_form_session.addEventListener('submit', function(e){
                    e.preventDefault();
        
                    let data = new FormData();
                    data.append('pass', reset_form_session.elements['pass'].value);
                    data.append('cpass', reset_form_session.elements['cpass'].value);
                    data.append('uID', reset_form_session.elements['user_id'].value);
                    data.append('resetLoggedUser','');
        
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', './ajax/login_register_crud.php', true);
        
                    xhr.onload = function(){
                        if(this.responseText == 'pass_missmatch')alert('Password missmatch');
                        else if(this.responseText == 'upd_failed')alert('Upload failed!');
                        else{
                            alert('success');
                        }
                    }
                    xhr.send(data);
                });
            </script>";
        }else if(isset($_GET['reset_password']) && isset($_GET['token'])){
            $data = filteration($_GET);
            echo <<<data
                <div class="container mt-5 pt-4 mb-4 d-flex justify-content-between">
                    <div class="heading">
                        <h2>ĐỔI MẬT KHẨU</h2>
                    </div>
                </div>
                
                <div class="container shadow mb-3" >
                    <div class="row">
                        <form id="reset-form">
                            <div class="mb-3">
                                <label for="pass">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="pass" name="pass">
                            </div>
            
                            <div class="mb-3">
                                <label for="cpass">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="cpass" name="cpass">
                            </div>
            
                            <input type="hidden" name="email" value=$data[email]>
                            <input type="hidden" name="token" value=$data[token]>
            
                            <div class="mb-3">
                                <button type="submit" class="btn custom-bg">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            data;

            echo "<script>
                let reset_form = document.getElementById('reset-form');

                reset_form.addEventListener('submit', function(e){
                    e.preventDefault();
                    changePass();
                });
        
                function changePass(){
                    let data = new FormData();
                    data.append('email', reset_form.elements['email'].value);
                    data.append('token', reset_form.elements['token'].value);
                    data.append('pass', reset_form.elements['pass'].value);
                    data.append('cpass', reset_form.elements['cpass'].value);
                    data.append('resetPass','');
        
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', './ajax/login_register_crud.php', true);
        
                    xhr.onload = function(){
                        if(this.responseText == 'pass_missmatch')alert('Password missmatch');
                        else if(this.responseText == 'inv_link')alert('Invalid or expired link!');
                        else if(this.responseText == 'upd_failed')alert('Fail to upload');
                        else if(this.responseText == 1){
                            alert('success');
                        }
                    }
                    xhr.send(data);
                }
            </script>";
        }else redirect("index.php");
    ?>

    

    <?php include('inc/footer.php'); ?>
    
    <script>
        

        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>