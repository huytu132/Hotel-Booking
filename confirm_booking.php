<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
        if (!isset($_GET['id']) || !isset($_SESSION['uID'])) {
            redirect('rooms.php');
        }

        $data = filteration($_GET);

        $room_res = select("SELECT * FROM `rooms` WHERE`id`=? AND `status` = ?", [$data['id'], 1], 'ii');
        if (mysqli_num_rows($room_res) == 0) {
            redirect('rooms.php');
        }
        $room_data = mysqli_fetch_assoc($room_res);

        $user_res = select("SELECT * FROM `user_cre` WHERE `id`=?", [$_SESSION['uID']],'i');
        $user_data = mysqli_fetch_assoc($user_res);

        $_SESSION['room'] = [
            "id" => $room_data['id'],
            "name" => $room_data['name'],
            "price" => $room_data['price'],
            "payment" => null,
            "available" => false,
        ];
    ?>


    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <div class="d-flex justify-content-between">
                    <div class="heading">
                        <h2>XÁC NHẬN ĐẶT PHÒNG</h2>
                    </div>
                </div>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Phòng</a>
                    <span class="text-secondary"> > </span>
                    <a href="room_details.php?id=<?php echo $room_data['id'] ?>" class="text-secondary text-decoration-none"><?php echo $room_data['name'] ?></a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4 border shadow">
                <div id="roomCarousel" class="carousel slide bg-dark p-1">
                    <div class="carousel-inner">
                        <?php
                            $thumb_img = "./images/rooms/thumbnail.jpg";
                            $images = mysqli_query($conn, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
                            if (mysqli_num_rows($images) > 0) {
                                $active_class = 'active';
                                while ($images_row = mysqli_fetch_assoc($images)) {
                                    echo <<<data
                                            <div class="carousel-item $active_class">
                                                <img src="./images/rooms/$images_row[image]" class="d-block w-100 rounded">
                                            </div>
                                            data;
                                    $active_class = '';
                                }
                            } else {
                                echo "<div class='carousel-item active'>
                                        <img src='$thumb_img' class='d-block w-100'>
                                    </div>";
                            }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <div class="col-12 mt-4 px-4 bg-light">
                    <div class="mb-4">
                            <?php
                                $price = formatCurrency($room_data['price']);
                                echo "<h5>$room_data[name]</h5>";
                                echo "<h6>$price/đêm</h6>";
                            ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form id="booking-form">
                            <h6>Thông tin khách hàng</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Họ và tên</label>
                                    <input name="name" type="text" class="form-control shadow-none" value="<?php echo $user_data['name'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ngày sinh</label>
                                    <input name="dob" type="date" class="form-control shadow-none" value="<?php echo $user_data['dob'] ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại</label>
                                    <input name="phone" type="text" class="form-control shadow-none" value="<?php echo $user_data['phoneNumber'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control shadow-none" value="<?php echo $user_data['email'] ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="form-label">Địa chỉ</label>
                                    <textarea name="address" class="form-control shadow-none" rows="2" required><?php echo $user_data['address'] ?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Check-in</label>
                                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Check-out</label>
                                    <input name="checkout" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="spinner-border text-info mb-3 d-none" role="status" id="info_loader">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <h6 id='pay-info' class="mb-3 text-danger">Note: Hãy chọn ngày check-in và ngày check-out</h6>
                            <button type="submit" name="pay_now" class="btn w-100 custom-bg text-white shadow-none">Xác nhận</button>
                        </form>
                        
                    </div>
                </div>
            </div>

            

        </div>
    </div>


    <?php include('inc/footer.php'); ?>

    <script>
        let booking_form = document.getElementById('booking-form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay-info');

        booking_form.addEventListener('submit', function(e){
            e.preventDefault();
            confirmBooking();
        }); 

        function confirmBooking(){
            let data = new FormData();
            data.append('user_name', booking_form.elements['name'].value)
            data.append('user_dob', booking_form.elements['dob'].value)
            data.append('user_phone', booking_form.elements['phone'].value)
            data.append('user_email', booking_form.elements['email'].value)
            data.append('user_address', booking_form.elements['address'].value)
            data.append('checkin', booking_form.elements['checkin'].value);
            data.append('checkout', booking_form.elements['checkout'].value);
            data.append('confirmBooking','');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/confirm_booking_crud.php", true);

            xhr.onload = function(){
                if(this.responseText == 1)showToast('success', 'Đặt phòng thành công!')
            }

            xhr.send(data);
        }

        function check_availability(){
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value; 
            booking_form.elements['pay_now'].setAttribute('disabled', true);
            
            if(checkin_val != '' && checkout_val != ''){
                pay_info.classList.add('d-none');
                info_loader.classList.remove('d-none');
                
                let data = new FormData();
                data.append('checkin', checkin_val);
                data.append('checkout', checkout_val);
                data.append('check_availability','');
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking_crud.php", true);

                xhr.onload = function(){
                    pay_info.classList.replace('text-dark', 'text-danger');
                    let data = JSON.parse(this.responseText);
                    if(data.status == 'check_in_out_equal')pay_info.innerText = "Bạn không để check-in và check-out trong cùng 1 ngày!";
                    else if(data.status == 'check_out_earlier')pay_info.innerText = "Ngày check-out sớm hơn ngày check-in!"
                    else if(data.status == 'check_in_earlier')pay_info.innerText = "Ngày check-in không hợp lệ!"
                    else if(data.status == 'unavailable')pay_info.innerText = 'Không còn phòng trống trong khoảng thời gian này!';
                    else{
                        pay_info.classList.replace('text-danger', 'text-dark');
                        pay_info.innerHTML = "Số ngày: "+ data.days+"<br>Tổng tiền: " + data.payment;
                        booking_form.elements['pay_now'].removeAttribute('disabled');
                    }
                }

                info_loader.classList.add('d-none');
                pay_info.classList.remove('d-none');
                xhr.send(data);
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
