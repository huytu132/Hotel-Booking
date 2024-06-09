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
                <h3 class="mb-4 text-dark fw-bold align-items-center">Lịch đặt phòng mới</h3>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <input type="text" oninput="getBooking(this.value)" class="form-control shadow-none w-50" placeholder="Search">
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y:scroll">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="text-light bg-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Thông tin khách hàng</th>
                                        <th scope="col">Thông tin phòng</th>
                                        <th scope="col">Thông tin đặt phòng</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- assign modal -->
    <div class="modal fade" tabindex="-1" id="assign-room">
        <div class="modal-dialog">
            <form id="assign-room-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Giao phòng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label"></label>
                        <input type="text" class="form-control shadow-none" name="room_no">
                        <input type="hidden" name="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let assign_room_form = document.getElementById('assign-room-form');

        function getID(id){
            assign_room_form.elements['booking_id'].value = id;
        }

        assign_room_form.addEventListener('submit', function(e){
            e.preventDefault();
            
            let data = new FormData();
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/new_bookings_crud.php", true);

            data.append('booking_id', assign_room_form.elements['booking_id'].value);
            data.append('room_no', assign_room_form.elements['room_no'].value);
            data.append('assign_room','');
            xhr.onload = function(){
                let myModal = document.getElementById('assign-room');
                let modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if(this.responseText == 1)alert('success', 'Lưu phòng thành công!');
                else alert('fail', 'Lưu thất bại!');
                get_all_new_bookings();
            }

            xhr.send(data);
        });


        function get_all_new_bookings(){
            let data = new FormData();

            data.append('get_all_new_bookings','');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/new_bookings_crud.php", true);

            xhr.onload = function(){              
                document.getElementById('table-data').innerHTML = this.responseText;
            };

            xhr.send(data);
        }

        function remBooking(id){
            if (confirm('Are you sure you want to remove this user?')) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/new_bookings_crud.php", true);
                let data = new FormData();
                data.append('rem_booking', id);

                xhr.onload = function(){             
                    if(this.responseText == 1){
                        alert('success', 'Booking cancelled!!');
                        get_all_new_bookings();
                    }
                    else alert('error', 'Fail to cancel this booking!!');
                };

                xhr.send(data);
            } 
        }

        function getBooking(input=''){
            let data = new FormData();
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/new_bookings_crud.php", true);
            data.append('input', input);
            data.append('getBooking','');

            xhr.onload = function(){              
                document.getElementById('table-data').innerHTML = this.responseText;
            };

            xhr.send(data);
        }

        window.onload = function(){
            get_all_new_bookings();
        }
    </script>

    <?php include('inc/scripts.php') ?>
</body>
</html>