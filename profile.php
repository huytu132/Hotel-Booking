<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <style>
        /* hide arrows from input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php include('./inc/header.php'); ?>

    <?php 
        if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            redirect("index.php"); 
        }
    ?>

    <div class="container mt-5 pt-4 mb-4 d-flex justify-content-between">
        <div class="heading">
            <h2>THÔNG TIN CÁ NHÂN</h2>
        </div>
    </div>

    <div class="container text-center mb-5">
        <?php 
            echo <<<data
                <img id="profile" class="rounded-circle border" width=180px>
            data;
        ?>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <form id="profile-form">
                    <p class="text-danger d-none" id="note">Vui lòng cung cấp thông tin phải đúng với giấy tờ khi check-in!</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên</label>
                            <input name="name" type="text" class="form-control shadow-none" disabled required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <input name="phone" type="text" class="form-control shadow-none" disabled required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control shadow-none" disabled required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="form-label">Địa chỉ</label>
                            <textarea name="address" class="form-control shadow-none" style="resize: none;" disabled rows="2" required>></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mã bưu điện</label>
                            <input name="pincode" type="text" class="form-control shadow-none" disabled required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày sinh</label>
                            <input name="dob" type="date" class="form-control shadow-none" disabled required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button id="edit" type="button" class="btn custom-bg">Sửa</button>
                        <button id="back" type="button" class="btn btn-secondary d-none">Hủy</button>
                        <button id="save" type="submit" class="btn custom-bg d-none">Lưu</button>
                    </div>
                    <input type="hidden" name="uID" value="<?php echo $_SESSION['uID']?>">
                </form>  
            </div>

            <div class="col-lg-2">
                <div class="heading pt-3">
                    <h6><a href="reset_password.php" class="text-decoration-none text-dark">Đổi mật khẩu</a></h6>
                </div>
            </div>
        </div>

        
    </div>

    <script>
        let profile_form = document.getElementById('profile-form');
        let back = document.getElementById('back');
        let save = document.getElementById('save');
        let edit = document.getElementById('edit');
        let note = document.getElementById('note');

        function getProfile(){
            let data = new FormData();
            data.append('uID', profile_form.elements['uID'].value);
            data.append('getProfile','');

            let xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/profile_crud.php', true);

            xhr.onload = function(){
                data = JSON.parse(this.responseText);
                document.getElementById('profile').src = "./images/users/" + data.profile
                profile_form.elements['name'].value = data.name
                profile_form.elements['phone'].value = data.phone
                profile_form.elements['email'].value = data.email
                profile_form.elements['pincode'].value = data.pincode
                profile_form.elements['address'].value = data.address
                profile_form.elements['dob'].value = data.dob
            }

            xhr.send(data);
        }

        // profile_form.elements['name'].setAttribute('disabled', true);
        edit.addEventListener('click', function(e){
            e.preventDefault();
            profile_form.elements['name'].removeAttribute('disabled');
            profile_form.elements['phone'].removeAttribute('disabled');
            profile_form.elements['email'].removeAttribute('disabled');
            profile_form.elements['address'].removeAttribute('disabled');
            profile_form.elements['dob'].removeAttribute('disabled');
            profile_form.elements['pincode'].removeAttribute('disabled');

            edit.classList.add('d-none');
            note.classList.remove('d-none');
            back.classList.remove('d-none');
            save.classList.remove('d-none');
        });

        back.addEventListener('click', function(e){
            e.preventDefault();
            profile_form.elements['name'].setAttribute('disabled', true);
            profile_form.elements['phone'].setAttribute('disabled', true);
            profile_form.elements['email'].setAttribute('disabled', true);
            profile_form.elements['address'].setAttribute('disabled', true);
            profile_form.elements['dob'].setAttribute('disabled', true);
            profile_form.elements['pincode'].setAttribute('disabled', true);

            back.classList.add('d-none');
            save.classList.add('d-none');
            note.classList.add('d-none');
            edit.classList.remove('d-none');
        });

        profile_form.addEventListener('submit', function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('uID', profile_form.elements['uID'].value);
            data.append('name', profile_form.elements['name'].value);
            data.append('email', profile_form.elements['email'].value);
            data.append('phone', profile_form.elements['phone'].value);
            data.append('address', profile_form.elements['address'].value);
            data.append('pincode', profile_form.elements['pincode'].value);
            data.append('dob', profile_form.elements['dob'].value);
            data.append('editProfile','');

            let xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/profile_crud.php', true);

            xhr.onload = function(){

                if(this.responseText == 1)alert('Success');
                else alert('Fail');
                
                getProfile();
                
                profile_form.elements['name'].setAttribute('disabled', true);
                profile_form.elements['phone'].setAttribute('disabled', true);
                profile_form.elements['email'].setAttribute('disabled', true);
                profile_form.elements['address'].setAttribute('disabled', true);
                profile_form.elements['dob'].setAttribute('disabled', true);
                profile_form.elements['pincode'].setAttribute('disabled', true);

                back.classList.add('d-none');
                save.classList.add('d-none');
                note.classList.add('d-none');
                edit.classList.remove('d-none');

            }
            xhr.send(data);

        });

        window.onload = function(){
            getProfile();
        }
    </script>

    <?php include('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>