<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');

    if(isset($_POST['submitReview'])){
        update("UPDATE `booking_order` SET `reviewed`=1 WHERE `id`=?", [$_POST['booking_id']], 'i');
        $sql = "INSERT INTO `reviews`(`booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?,?,?,?,?)";
        $values = [$_POST['booking_id'], $_POST['room_id'], $_POST['user_id'], $_POST['rating'], $_POST['review']];
        if(insert($sql, $values, 'iiiss'))echo 1;
        else echo 0;
    }

    if(isset($_POST['cancelBooking'])){
        if(update("UPDATE `booking_order` SET `status`=-1 WHERE `id`=?", [$_POST['booking_id']], 'i'))echo 1;
        else echo 0;
    }
?>