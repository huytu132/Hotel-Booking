<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    adminLogin();

    // if(isset($_POST['changeStatus'])){
    //     $filtered_data = filteration($_POST);
    //     $sql = "UPDATE `user_cre` SET `status`=? WHERE id = ?";

    //     $values = [$filtered_data['value'], $filtered_data['changeStatus']];
    //     $res = update($sql, $values, 'ii');
    //     echo $res;
    // }

    if(isset($_POST['get_all_new_bookings'])){
        $sql = "SELECT bo.*, bd.* FROM `booking_order` bo
        JOIN `booking_details` bd ON bo.id = bd.booking_id
        WHERE bo.status = 0";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) == 0){
            echo '<b>Hiện tại không có lịch đặt phòng!</b>';
            exit;
        }
        $i = 1;

        $data = "";

        while($row = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y", strtotime($row['datentime']));
            $checkin = date("d-m-Y", strtotime($row['check_in']));
            $checkout = date("d-m-Y", strtotime($row['check_out']));
            $dob = date("d-m-Y", strtotime($row['user_dob']));
            $price = formatCurrency($row['price']);
            $total_pay = formatCurrency($row['total_pay']);
            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>
                        <b>Họ và tên: </b> $row[user_name]
                        <br>
                        <b>Ngày sinh: </b> $dob
                        <br>
                        <b>Số điện thoại: </b> $row[user_phone]
                        <br>
                        <b>Email: </b> $row[user_email]
                        <br>
                        <b>Địa chỉ: </b> $row[user_address]
                    </td>
                    <td>
                        <b>Tên phòng: </b> $row[room_name]
                        <br>
                        <b>Giá: </b>$price <b>/đêm</>
                        <br>
                    </td>
                    <td>
                        <b>Check-in: </b> $checkin
                        <br>
                        <b>Check-out: </b> $checkout
                        <br>
                        <b>Tổng tiền: </b> $total_pay<b></b>
                        <br>
                        <b>Ngày đặt phòng: </b> $date
                        <br>
                    </td>
                    <td>
                        <button onclick='getID($row[booking_id])' class='btn btn-sm text-white custom-bg shadow-none fw-bold' data-bs-toggle='modal' data-bs-target='#assign-room'>
                            <i class='bi bi-check2-square'></i> Giao phòng
                        </button>
                        <br>
                        <button onclick='remBooking($row[booking_id])' class='mt-2 btn btn-sm btn-outline-danger shadow-none fw-bold'>
                            <i class='bi bi-trash'></i> Hủy
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if(isset($_POST['rem_booking'])){
        $res1 = update("UPDATE `booking_order` SET `status` = -1 WHERE `id`=?", [$_POST['rem_booking']], 'i');
        if($res1)echo 1;
        else echo 0;
    }

    if(isset($_POST['assign_room'])){
        if(!update("UPDATE `booking_order` SET `status` = 1 WHERE `id`=?", [$_POST['booking_id']], 'i')){
            echo 0;
        }else{
            if(!update("UPDATE `booking_details` SET `room_no` = ? WHERE `booking_id`=?", [$_POST['room_no'], $_POST['booking_id']], 'si'))echo 0;
            echo 1;
        }
    }

    if(isset($_POST['getBooking'])){
        $sql = "SELECT bo.*, bd.* FROM `booking_order` bo
        JOIN `booking_details` bd ON bo.id = bd.booking_id
        WHERE bo.status = 0 AND (bd.user_name like ? OR bd.user_phone like ? OR bd.user_email like ?) ORDER BY bo.id DESC";
        $values = ["%$_POST[input]%", "%$_POST[input]%", "%$_POST[input]%"];
        $res = select($sql, $values, 'sss');
        if(mysqli_num_rows($res) == 0){
            echo '<b>Hiện tại không có lịch đặt phòng!</b>';
            exit;
        }
        $i = 1;

        $data = "";

        while($row = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y", strtotime($row['datentime']));
            $checkin = date("d-m-Y", strtotime($row['check_in']));
            $checkout = date("d-m-Y", strtotime($row['check_out']));
            $dob = date("d-m-Y", strtotime($row['user_dob']));
            $price = formatCurrency($row['price']);
            $total_pay = formatCurrency($row['total_pay']);
            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>
                        <b>Họ và tên: </b> $row[user_name]
                        <br>
                        <b>Ngày sinh: </b> $dob
                        <br>
                        <b>Số điện thoại: </b> $row[user_phone]
                        <br>
                        <b>Email: </b> $row[user_email]
                        <br>
                        <b>Địa chỉ: </b> $row[user_address]
                    </td>
                    <td>
                        <b>Tên phòng: </b> $row[room_name]
                        <br>
                        <b>Giá: </b>$price <b>/đêm</>
                        <br>
                    </td>
                    <td>
                        <b>Check-in: </b> $checkin
                        <br>
                        <b>Check-out: </b> $checkout
                        <br>
                        <b>Tổng tiền: </b> $total_pay<b></b>
                        <br>
                        <b>Ngày đặt phòng: </b> $date
                        <br>
                    </td>
                    <td>
                        <button onclick='getID($row[booking_id])' class='btn btn-sm text-white custom-bg shadow-none fw-bold' data-bs-toggle='modal' data-bs-target='#assign-room'>
                            <i class='bi bi-check2-square'></i> Giao phòng
                        </button>
                        <br>
                        <button onclick='remBooking($row[booking_id])' class='mt-2 btn btn-sm btn-outline-danger shadow-none fw-bold'>
                            <i class='bi bi-trash'></i> Hủy
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }
?>