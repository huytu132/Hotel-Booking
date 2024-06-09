<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    session_start();

    if(isset($_GET['fet_rooms'])){
        $time_input = json_decode($_GET['time_input'], true);
        $people_input = json_decode($_GET['people'], true);
        $features_list = json_decode($_GET['features_list'], true);
        $page = $_GET['page'];

        $limit = 3;
        $start = ($page-1)*$limit;

        if($time_input['checkin'] != '' && $time_input['checkout'] != ''){
            $today_date = new DateTime(date("Y-m-d"));
            $checkin_date = new DateTime($time_input['checkin']);
            $checkout_date = new DateTime($time_input['checkout']);

            if($checkin_date == $checkout_date){
                echo "<h3 class='text-center text-danger'>Không thể checkin và checkout trong cùng 1 ngày</h3>";
                exit;
                
            }else if($checkout_date < $checkin_date){
                echo "<h3 class='text-center text-danger'>Ngày không hợp lệ</h3>";
                exit;
            }
            else if($checkin_date < $today_date){
                echo "<h3 class='text-center text-danger'>Ngày không hợp lệ</h3>";
                exit;
            }
        }

        $login = 0;
        if(isset($_SESSION['login']) && $_SESSION['login'] == true){
            $login = 1;
        }

        $adult = ($people_input['adults'] != '')? $people_input['adults'] : 0;
        $children = ($people_input['children'] != '')?$people_input['children'] : 0;

        $room_res = select("SELECT * FROM `rooms` WHERE `status` = ? AND `adult`>=? && `children`>=?",[1, $adult, $children],'iii'); 
        $data = "";

        $roomIdArray = [];

        while($row = mysqli_fetch_assoc($room_res)){    
            if($time_input['checkin'] != '' && $time_input['checkout'] != ''){
                $sql = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
                WHERE `status` != -1 AND room_id=? AND check_out > ? AND check_in < ?";
                
                $values = [$row['id'], $time_input['checkin'], $time_input['checkout']];

                $u_fetch = mysqli_fetch_assoc(select($sql, $values, 'iss'));

                $room_quan = select("SELECT `quantity` from `rooms` WHERE `id` = ?", [$row['id']], 'i');
                $room_quan_fetch = mysqli_fetch_assoc($room_quan);

                if($room_quan_fetch['quantity'] - $u_fetch['total_bookings'] != 0){
                    $fea_res = mysqli_query($conn, "SELECT f.name, f.id FROM `features` f
                    JOIN `rooms_features` rfea on f.id = rfea.features_id
                    where rfea.rooms_id ='$row[id]'");
                    $fea_count = 0;
                    while ($feature_row = mysqli_fetch_assoc($fea_res)){
                        if(in_array($feature_row['id'], $features_list['features'])){
                            $fea_count++;
                        }
                    }
                    if(count($features_list['features']) == $fea_count)array_push($roomIdArray, $row['id']);
                }
            }
            else{
                $fea_res = mysqli_query($conn, "SELECT f.name, f.id FROM `features` f
                JOIN `rooms_features` rfea on f.id = rfea.features_id
                where rfea.rooms_id ='$row[id]'");
                $fea_count = 0;
                while ($feature_row = mysqli_fetch_assoc($fea_res)){
                    if(in_array($feature_row['id'], $features_list['features'])){
                        $fea_count++;
                    }
                }
                if(count($features_list['features']) == $fea_count)array_push($roomIdArray, $row['id']);
            }

        }
        if(count($roomIdArray) == 0)echo "<h3 class='text-center text-danger'>Không có phòng nào phù hợp!</h3>";  
        for($j=$start;$j<count($roomIdArray) && $j<$start+$limit; $j++){
            $row = mysqli_fetch_assoc(select("SELECT * FROM `rooms` WHERE `id`=?", [$roomIdArray[$j]], 'i'));

            $currency = formatCurrency($row['price']);
            $fea_res = mysqli_query($conn, "SELECT f.name, f.id FROM `features` f
            JOIN `rooms_features` rfea on f.id = rfea.features_id
            where rfea.rooms_id ='$row[id]'");

            $cnt = 0;
            $flag = 1;
            $features_data = '';
            while ($feature_row = mysqli_fetch_assoc($fea_res)){
                if($cnt < 8){
                    $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>$feature_row[name]</span>";
                }else{
                    if($flag)$features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>...</span>";
                    $flag = 0;
                }
                $cnt++;
            }
            $images = mysqli_query($conn, "SELECT * FROM `room_images` WHERE `room_id`='$row[id]' AND `thumb`=1");
            $images_row = mysqli_fetch_assoc($images);  

            $data .= "
                <div class='card mb-5 border-0 shadow'>
                    <div class='row g-0 align-items-center'>
                        <div class='col-md-5 p-0 mb-2'>
                            <img src='./images/rooms/$images_row[image]' class='img-fluid rounded-start'>
                        </div>

                        <div class='col-md-5 mb-md-0 mb-2 p-2'>
                            <div class='ms-3'>
                                <h5>$row[name]</h5>
                                <div class='features mb-2'>
                                    <h6 class='mb-1'>Tiện ích</h6>
                                    $features_data 
                                </div>  

                                <div class='guest'>
                                    <h6 class='mb-1'>Phù hợp</h6>
                                    <span class='badge rounded-pill bg-light text-dark text-wrap'>
                                        $row[adult] Người lớn
                                    </span>
                                    <span class='badge rounded-pill bg-light text-dark text-wrap'>
                                        $row[children] Trẻ em
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='col-md-2 text-center p-2'>
                            <h5 class='mb-4'>$currency/đêm</h5>
                            <button onclick='checkLoginToBook($login, $row[id])' class='btn text-white w-100 custom-bg shadow-none mb-2'>Đặt phòng</button>
                            <a href='room_details.php?id=$row[id]' class='btn btn-sm w-100 btn-outline-dark shadow-none'>Chi tiết </a>
                        </div>
                    </div>
                </div>";
        }

        echo $data;
    }
?>