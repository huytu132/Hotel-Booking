<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    adminLogin();

    if(isset($_POST['bookingAna'])){
        $condition = "";

        if($_POST['period'] == 1){
            $condition = "WHERE datentime between (NOW() - INTERVAL 30 DAY) AND NOW()";
        }else if($_POST['period'] == 2){
            $condition = "WHERE datentime between (NOW() - INTERVAL 90 DAY) AND NOW()";
        }else if($_POST['period'] == 3){
            $condition = "WHERE datentime between (NOW() - INTERVAL 1 YEAR) AND NOW()";
        }

        $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT
            COUNT(*) AS `total_bookings`,
            SUM(`total_pay`) as `total_payment`,

            COUNT(CASE WHEN `status` != -1 THEN 1 END) as `success_bookings`,
            sum(case when `status` != -1 THEN `total_pay` END) as `success_payment`,

            COUNT(CASE WHEN `status` = -1 THEN 1 END) as `cancel_bookings`,
            sum(case when `status` = -1 THEN `total_pay` END) as `cancel_payment`

            FROM `booking_order` $condition;"
        ));

        echo json_encode(['total_bookings'=>$result['total_bookings'], 'total_payment' => formatCurrency($result['total_payment']), 
        'success_bookings'=>$result['success_bookings'], 'success_payment' => formatCurrency($result['success_payment']),
        'cancel_bookings'=>$result['cancel_bookings'], 'cancel_payment' => formatCurrency($result['cancel_payment'])]);
    }

    if(isset($_POST['userAna'])){
        $condition = "";

        if($_POST['period'] == 1){
            $condition = "WHERE datentime between (NOW() - INTERVAL 30 DAY) AND NOW()";
        }else if($_POST['period'] == 2){
            $condition = "WHERE datentime between (NOW() - INTERVAL 90 DAY) AND NOW()";
        }else if($_POST['period'] == 3){
            $condition = "WHERE datentime between (NOW() - INTERVAL 1 YEAR) AND NOW()";
        }

        $newUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as `user` from `user_cre` $condition"));
        $userQuery = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as `query` from `user_queries` $condition"));
        $userReview = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) as `review` from `reviews` $condition"));

        echo json_encode(['new_user' => $newUser['user'], 'user_query' => $userQuery['query'], 'user_review' => $userReview['review']]);
    }
?>