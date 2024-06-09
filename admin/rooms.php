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
                <h3 class="mb-4 text-dark fw-bold align-items-center">Phòng</h3>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        
                        <div class="text-end mb-3">
                            <h5 class="card-title m-0">  </h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#room-s">
                                <i class="bi bi-plus-square"></i> Thêm
                            </button>
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y:scroll">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="text-light bg-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Tên phòng</th>
                                        <th scope="col">Diện tích</th>
                                        <th scope="col">Phù hợp</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng phòng</th>
                                        <th scope="col">Trạng thái (hiển thị trên web)</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->

    <div class="modal fade" id="room-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="room-s-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm phòng</h5>                       
                    </div>
                    <div class="modal-body">    
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tên phòng</label>
                                <input type="text" name="room-name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Diện tích</label>
                                <input type="number" name="room-area" class="form-control shadow-none" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Giá</label>
                                <input type="number" name="room-price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số lượng phòng</label>
                                <input type="number" name="room-quantity" class="form-control shadow-none" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Người lớn (Max)</label>
                                <input type="number" name="room-adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Trẻ em (Max)</label>
                                <input type="number" name="room-child" class="form-control shadow-none" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="form-label fw-bold">Tiện ích</label>
                            <?php    
                                $rows = selectAll('features');
                                while($opt = mysqli_fetch_assoc($rows)){
                                    echo "
                                        <div class='col-md-3'>
                                            <label>
                                                <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                $opt[name]
                                            </label>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="room-desc" rows="3" class="form-control shadow-none" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit room -->
    <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit-room-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa phòng</h5>                       
                    </div>
                    <div class="modal-body">    
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tên phòng</label>
                                <input type="text" name="room-name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Diện tích</label>
                                <input type="number" name="room-area" class="form-control shadow-none" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Giá</label>
                                <input type="number" name="room-price" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số lượng</label>
                                <input type="number" name="room-quantity" class="form-control shadow-none" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Người lớn (Max)</label>
                                <input type="number" name="room-adult" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Trẻ em (Max)</label>
                                <input type="number" name="room-child" class="form-control shadow-none" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="form-label fw-bold">Tiện ích</label>
                            <?php    
                                $rows = selectAll('features');
                                while($opt = mysqli_fetch_assoc($rows)){
                                    echo "
                                        <div class='col-md-3'>
                                            <label>
                                                <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                $opt[name]
                                            </label>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="room-desc" rows="3" class="form-control shadow-none" style="resize: none;"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="room-id">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Room</h5>       
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>                
                </div>
                <div class="modal-body">    
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add-image-form">
                            <label class="form-label">Thêm ảnh</label>
                            <input type="file" name="room-image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3">
                            <button type="submit" class="btn custom-bg text-white shadow-none">Thêm</button>
                            <input type="hidden" name="room-id" class = "room-id">
                        </form>
                    </div>

                    <div class="table-responsive-md" style="height: 300px; overflow-y:scroll">
                        <table class="table table-hover border">
                            <thead class="sticky-top">
                                <tr class="text-light bg-dark text-center">
                                    <th scope="col" width="60%">Ảnh</th>
                                    <th scope="col">Ảnh nền</th>
                                    <th scope="col">Xóa</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let room_s_form = document.getElementById('room-s-form');
        let edit_room_form = document.getElementById('edit-room-form');

        room_s_form.addEventListener('submit', function(e){
            e.preventDefault();
            add_rooms();
        });

        function add_rooms(){
            let data = new FormData();
            data.append('add_rooms', '');
            data.append('name', room_s_form.elements['room-name'].value);
            data.append('area', room_s_form.elements['room-area'].value);
            data.append('price', room_s_form.elements['room-price'].value);
            data.append('quantity', room_s_form.elements['room-quantity'].value);
            data.append('adult', room_s_form.elements['room-adult'].value);
            data.append('child', room_s_form.elements['room-child'].value);
            data.append('description', room_s_form.elements['room-desc'].value);

            let features = [];

            room_s_form.elements['features'].forEach(element => {
                if(element.checked){
                    features.push(element.value);
                }
            });

            data.append('features', JSON.stringify(features));

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);

            xhr.onload = function(){
                let myModal = document.getElementById('room-s');
                let modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
              
                if(this.responseText == 1){
                    alert('success', 'New room added!');
                    get_all_rooms();
                    room_s_form.reset();
                }
                else{
                    alert('error', 'Fail to add room!');
                }
            };

            xhr.send(data);
        }

        function changeStatus(id, val){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success', 'Change status successfully!');
                    get_all_rooms();
                }
                else alert('error', 'Fail to change status!');
            }

            xhr.send('changeStatus='+id+'&value='+val);
        }

        function get_all_rooms(){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){              
                document.getElementById('room-data').innerHTML = this.responseText;
            };

            xhr.send('get_all_rooms');
        }

        function edit_details(id){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){              
                let data = JSON.parse(this.responseText);
                edit_room_form.elements['room-name'].value = data.roomdata.name;
                edit_room_form.elements['room-area'].value = data.roomdata.area;
                edit_room_form.elements['room-price'].value = data.roomdata.price;
                edit_room_form.elements['room-quantity'].value = data.roomdata.quantity;
                edit_room_form.elements['room-adult'].value = data.roomdata.adult;
                edit_room_form.elements['room-child'].value = data.roomdata.children;
                edit_room_form.elements['room-desc'].value = data.roomdata.description;
                edit_room_form.elements['room-id'].value = data.roomdata.id;

                edit_room_form.elements['features'].forEach(el => {
                    if(data.features.includes(Number(el.value))){
                        el.checked = true;
                    }
                });


            };

            xhr.send('get_room='+id);
        }

        edit_room_form.addEventListener('submit', function(e){
            e.preventDefault();
            submit_edit_room();
        });

        function submit_edit_room(){
            let data = new FormData();
            data.append('edit_rooms', '');
            data.append('name', edit_room_form.elements['room-name'].value);
            data.append('area', edit_room_form.elements['room-area'].value);
            data.append('price', edit_room_form.elements['room-price'].value);
            data.append('quantity', edit_room_form.elements['room-quantity'].value);
            data.append('adult', edit_room_form.elements['room-adult'].value);
            data.append('child', edit_room_form.elements['room-child'].value);
            data.append('description', edit_room_form.elements['room-desc'].value);
            data.append('room_id', edit_room_form.elements['room-id'].value);

            let features = [];

            edit_room_form.elements['features'].forEach(element => {
                if(element.checked){
                    features.push(element.value);
                }
            });

            data.append('features', JSON.stringify(features));

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);

            xhr.onload = function(){
                let myModal = document.getElementById('edit-room');
                let modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
              
                if(this.responseText == 1){
                    alert('success', 'Room was edited!');
                    get_all_rooms();
                    edit_room_form.reset();
                }
                else{
                    alert('error', 'Fail to add room!');
                }
            };

            xhr.send(data);
        }

        function get_images(id, name){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function(){             
                document.querySelector("#add-image-form .room-id").value = id;
                document.querySelector("#room-images .modal-title").innerHTML = name;
                document.getElementById('room-image-data').innerHTML = this.responseText;
            };

            xhr.send('get_images='+id);
        }

        let add_image_form = document.getElementById('add-image-form');

        add_image_form.addEventListener('submit', function(e){
            e.preventDefault();
            add_images();
        });

        function add_images(){
            let data = new FormData();           
            data.append('image',add_image_form.elements['room-image'].files[0]);
            data.append('room_id',add_image_form.elements['room-id'].value);
            data.append('add_images','');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/rooms_crud.php', true);

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success', 'New image added!!');
                    get_images(add_image_form.elements['room-id'].value, document.querySelector('#room-images .modal-title').innerText);
                }
                else if(this.responseText == 'inv_img')alert('', 'Only JPG, WEBP and PNG images are allowed!');
                else if(this.responseText == 'inv_size')alert('', 'Image should be less than 2MB');
                else alert('Image upload failed!');

                add_image_form.reset();
            }

            xhr.send(data);
        }

        function delete_room_images(id){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/rooms_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){             
                if(this.responseText == 1){
                    alert('success', 'Image removed!!');
                    get_images(add_image_form.elements['room-id'].value, document.querySelector('#room-images .modal-title').innerText);
                }
                else alert('error', 'Fail to remove images!!');
            };

            xhr.send('delete_room_images='+id);
        }

        function rem_room(id){
            if (confirm('Are you sure you want to remove this room?')) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/rooms_crud.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function(){             
                    if(this.responseText == 1){
                        alert('success', 'Room removed!!');
                        get_all_rooms();
                    }
                    else alert('error', 'Fail to remove room!!');
                };

                xhr.send('rem_room='+id);
            } 
        }

        function change_thumb(image_id, room_id){
            let data = new FormData();
            data.append('image_id', image_id);
            data.append('room_id', room_id);
            data.append('change_thumb','');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/rooms_crud.php', true);

            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success', 'Thumb changed!');
                    get_images(add_image_form.elements['room-id'].value, document.querySelector('#room-images .modal-title').innerText);
                }
                else alert('error', 'Fail to change thumb!');
            }

            xhr.send(data);
        }

        window.onload = function(){
            get_all_rooms();
        }
    </script>

    <?php include('inc/scripts.php') ?>
</body>
</html>