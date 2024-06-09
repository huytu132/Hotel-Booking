<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    adminLogin();

    if(isset($_POST['get_all_booking_records'])){
        $sql = "SELECT bo.*, bd.* FROM `booking_order` bo
        JOIN `booking_details` bd ON bo.id = bd.booking_id
        WHERE bo.status != 0 ORDER BY bo.id DESC";
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
            if($row['status'] == 1)$status = "<span class='badge bg-success'>Đã giao phòng</span>";
            else if($row['status'] == -1)$status = "<span class='badge bg-danger'>Đã hủy</span>";
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
                        <b>Tổng tiền: </b> $total_pay
                        <br>
                        <b>Date: </b> $date
                        <br>
                    </td>
                    <td>
                        $status
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }
?>