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
</head>
<body class="bg-light">
    
    <?php 
        include('inc/header.php'); 

        $new_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as 'total' FROM `booking_order` WHERE `status`=0"));
        $user_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as 'total' FROM `reviews` WHERE `seen`=0"));
        $user_queries = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as 'total' FROM `user_queries` WHERE `seen`=0"));

        $users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as 'total' FROM `user_cre`"));
        $active_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as 'total' FROM `user_cre` WHERE `active`=1"));
        $inactive_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as 'total' FROM `user_cre` WHERE `is_verified`=1 AND `active`=0"));
        $unverified_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as 'total' FROM `user_cre` WHERE `is_verified`=0"));
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto overflow-hidden p-2">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>DASHBOARD</h3>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>Lịch đặt phòng mới</h6>
                                <h1 class="mt-2 mb-0"><?php echo $new_bookings['total'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>Câu hỏi khách hàng</h6>
                                <h1 class="mt-2 mb-0"><?php echo $user_queries['total'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="rating_reviews.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>Đánh giá của khách hàng</h6>
                                <h1 class="mt-2 mb-0"><?php echo $user_reviews['total'] ?></h1>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>THỐNG KÊ ĐẶT PHÒNG VÀ DOANH THU</h3>
                    <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                        <option value="1">30 ngày</option>
                        <option value="2">90 ngày</option>
                        <option value="3">1 năm</option>
                        <option value="4">Toàn thời gian</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>Tổng số lượt đặt phòng</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings"></h1>
                            <h3 class="mt-2 mb-0" id="total_payment"></h3>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Số lượt thành công</h6>
                            <h1 class="mt-2 mb-0" id='success_bookings'></h1>
                            <h3 class="mt-2 mb-0" id='success_payment'></h3>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Số lượt hủy</h6>
                            <h1 class="mt-2 mb-0" id='cancel_bookings'></h1>
                            <h3 class="mt-2 mb-0" id='cancel_payment'></h3>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>THỐNG KÊ NGƯỜI MỚI, CÂU HỎI, ĐÁNH GIÁ</h3>
                    <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                        <option value="1">30 ngày</option>
                        <option value="2">90 ngày</option>
                        <option value="3">1 năm</option>
                        <option value="4">Toàn thời gian</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Người đăng ký mới</h6>
                            <h1 class="mt-2 mb-0" id="new-user"></h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Lượt đặt câu hỏi</h6>
                            <h1 class="mt-2 mb-0" id="user-query"></h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Lượt đánh giá</h6>
                            <h1 class="mt-2 mb-0" id="user-review"></h1>
                        </div>
                    </div>
                </div>

                <h5>Người dùng</h5>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Tổng số người dùng</h6>
                            <h1 class="mt-2 mb-0"><?php echo $users['total'] ?></h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active</h6>
                            <h1 class="mt-2 mb-0"><?php echo $active_users['total'] ?></h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Inactive</h6>
                            <h1 class="mt-2 mb-0"><?php echo $inactive_users['total'] ?></h1>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Chưa xác thực email</h6>
                            <h1 class="mt-2 mb-0"><?php echo $unverified_users['total'] ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function booking_analytics(period=1){
            let xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/dashboard_crud.php', true);

            let data = new FormData();
            data.append('bookingAna', '');
            data.append('period', period);

            xhr.onload = function(){
                let data = JSON.parse(this.responseText);
                document.getElementById('total_bookings').innerHTML = data.total_bookings;
                document.getElementById('total_payment').innerHTML = data.total_payment;
                document.getElementById('success_bookings').innerHTML = data.success_bookings;
                document.getElementById('success_payment').innerHTML = data.success_payment;
                document.getElementById('cancel_bookings').innerHTML = data.cancel_bookings;
                document.getElementById('cancel_payment').innerHTML = data.cancel_payment;
            }
            xhr.send(data);
        }

        function user_analytics(period=1){
            let xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/dashboard_crud.php', true);

            let data = new FormData();
            data.append('userAna', '');
            data.append('period', period);

            xhr.onload = function(){
                let data = JSON.parse(this.responseText);
                console.log(data);
                document.getElementById('new-user').innerHTML = data.new_user;
                document.getElementById('user-query').innerHTML = data.user_query;
                document.getElementById('user-review').innerHTML = data.user_review;
            }
            xhr.send(data);
        }

        window.onload = function(){
            booking_analytics();
            user_analytics();
        }
    </script>

    <?php include('inc/scripts.php') ?>
</body>
</html>