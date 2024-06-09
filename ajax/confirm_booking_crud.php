<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    
    session_start();

    if(isset($_POST['confirmBooking'])){
        $data = filteration($_POST);
        insert("INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `total_pay`) VALUES (?, ?, ?, ?, ?)", [$_SESSION['uID'], $_SESSION['room']['id'], $data['checkin'], $data['checkout'], $_SESSION['room']['payment']], 'iissi');
        $lastID = mysqli_insert_id($conn);
        $sql = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `user_dob`, `user_phone`, `user_email`, `user_address`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$lastID, $_SESSION['room']['name'], $_SESSION['room']['price'], $_SESSION['room']['payment'], $data['user_name'], $data['user_dob'], $data['user_phone'], $data['user_email'], $data['user_address']];
        insert($sql, $values, 'isiisssss');
        echo 1;
    }

    if(isset($_POST['check_availability'])){
        $data = filteration($_POST);
        $status = "";
        $result = "";

        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($data['checkin']);
        $checkout_date = new DateTime($data['checkout']);

        if($checkin_date == $checkout_date){
            $status = 'check_in_out_equal';
            $result = json_encode(["status"=>$status]);
        }else if($checkout_date < $checkin_date){
            $status = 'check_out_earlier';
            $result = json_encode(["status"=>$status]);
        }
        else if($checkin_date < $today_date){
            $status = 'check_in_earlier';
            $result = json_encode(["status"=>$status]);
        }

        if($status != ''){
            echo $result;
        }
        else{
            
            $_SESSION['room'];
            
            $sql = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
            WHERE `status` != -1 AND room_id=? AND check_out > ? AND check_in < ?";
            
            $values = [$_SESSION['room']['id'], $data['checkin'], $data['checkout']];

            $u_fetch = mysqli_fetch_assoc(select($sql, $values, 'iss'));

            $room_quan = select("SELECT `quantity` from `rooms` WHERE `id` = ?", [$_SESSION['room']['id']], 'i');
            $room_quan_fetch = mysqli_fetch_assoc($room_quan);

            if($room_quan_fetch['quantity'] - $u_fetch['total_bookings'] == 0){
                $status = "unavailable";
                $result = json_encode(["status"=>$status]);
                echo $result;
                exit;
            }

            $count_days = date_diff($checkin_date, $checkout_date)->days;
            $payment = $_SESSION['room']['price'] * $count_days;

            $_SESSION['room']['payment'] = $payment;
            $_SESSION['room']['available'] = true;

            $result = json_encode(["status"=>'available', "days"=>$count_days, "payment" => formatCurrency($payment)]);
            echo $result;
        }
    }
?>