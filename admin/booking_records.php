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
                <h3 class="mb-4 text-dark fw-bold align-items-center">Lịch sử đặt phòng</h3>
                
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
                                        <th scope="col">Trạng thái</th>
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

    <script>
        function get_all_booking_records(){
            let data = new FormData();

            data.append('get_all_booking_records','');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/booking_records_crud.php", true);

            xhr.onload = function(){              
                document.getElementById('table-data').innerHTML = this.responseText;
            };

            xhr.send(data);
        }

        function getBooking(input=''){
            let data = new FormData();
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/booking_records_crud.php", true);
            data.append('input', input);
            data.append('getBooking','');

            xhr.onload = function(){              
                document.getElementById('table-data').innerHTML = this.responseText;
            };

            xhr.send(data);
        }

        window.onload = function(){
            get_all_booking_records();
        }
    </script>

    <?php include('inc/scripts.php') ?>
</body>
</html>