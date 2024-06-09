<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    adminLogin();

    if(isset($_POST['add_rooms'])){
        $features = filteration(json_decode($_POST['features']));
        $filtered_data = filteration($_POST);
        $flag = 0;

        $sql1 = "INSERT INTO `rooms`(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = [$filtered_data['name'], $filtered_data['area'], $filtered_data['price'], $filtered_data['quantity'], $filtered_data['adult'], $filtered_data['child'], $filtered_data['description']];

        if(insert($sql1, $values, 'siiiiis')){
            $flag = 1;
        }

        $room_id = mysqli_insert_id($conn);

        $sql3 = "INSERT INTO `rooms_features`(`rooms_id`, `features_id`) VALUES (?,?)";
        if($stmt = mysqli_prepare($conn, $sql3)){
            foreach($features as $f){
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
        else{
            $flag = 0;
            die('query cannot be prepared - insert1!');
        }

        echo 1;
    }

    if(isset($_POST['changeStatus'])){
        $filtered_data = filteration($_POST);
        $sql = "UPDATE `rooms` SET `status`=? WHERE id = ?";

        $values = [$filtered_data['value'], $filtered_data['changeStatus']];
        $res = update($sql, $values, 'ii');
        echo $res;
    }

    if(isset($_POST['get_all_rooms'])){
        $res = selectAll('rooms');
        $i = 1;

        $data = "";

        while($row = mysqli_fetch_assoc($res)){
            if($row['status'] == 1){
                $status = "<button onclick='changeStatus($row[id], 0)' class='btn btn-sm btn-dark shadow-none'>active</button>";
            }else{
                $status = "<button onclick='changeStatus($row[id], 1)' class='btn btn-sm btn-warning shadow-none'>inactive</button>";
            }

            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[area]</td>
                    <td>
                        <span class = 'badge rounded-pill bg-light text-dark'>
                            Adult: $row[adult]
                        </span><br>
                        <span class = 'badge rounded-pill bg-light text-dark'>
                            Children: $row[children]
                        </span>
                    </td>
                    <td>$row[price]</td>
                    <td>$row[quantity]</td>
                    <td>$status</td>
                    <td>
                        <button onclick='edit_details($row[id])' type='button' class='btn btn-dark shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-room'>
                            <i class='bi bi-pencil-square'></i>
                        </button>
                        <button onclick='get_images($row[id], \"$row[name]\")' type='button' class='btn btn-dark shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#room-images'>
                            <i class='bi bi-images'></i>
                        </button>
                        <button onclick='rem_room($row[id])' type='button' class='btn btn-warning shadow-none btn-sm'>
                            <i class='bi bi-trash'></i> 
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if(isset($_POST['get_room'])){
        $filtered_data = filteration($_POST);

        $res1 = select("SELECT * FROM `rooms` WHERE `id`=?", [$filtered_data['get_room']], 'i');
        $res2 = select("SELECT * FROM `rooms_features` WHERE `rooms_id`=?", [$filtered_data['get_room']], 'i');

        $roomdata = mysqli_fetch_assoc($res1);
        $features = [];

        if(mysqli_num_rows($res2) > 0){ 
            while($row = mysqli_fetch_assoc($res2)){
                array_push($features, $row['features_id']);
            }
        }

        $data = ['roomdata' => $roomdata, 'features' => $features];

        $data = json_encode($data);
        echo $data;
    }

    if(isset($_POST['edit_rooms'])){
        $features = filteration(json_decode($_POST['features']));
        $filtered_data = filteration($_POST);
        $flag = 0;

        $sql1 = "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?";
        $values = [$filtered_data['name'], $filtered_data['area'], $filtered_data['price'], $filtered_data['quantity'], $filtered_data['adult'], $filtered_data['child'], $filtered_data['description'], $filtered_data['room_id']];

        if(insert($sql1, $values, 'siiiiisi')){
            $flag = 1;
        }

        delete("DELETE FROM `rooms_features` WHERE `rooms_id`=?", [$filtered_data['room_id']], 'i');

        $room_id = $filtered_data['room_id'];

        $sql3 = "INSERT INTO `rooms_features`(`rooms_id`, `features_id`) VALUES (?,?)";
        if($stmt = mysqli_prepare($conn, $sql3)){
            foreach($features as $f){
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
        else{
            $flag = 0;
            die('query cannot be prepared - insert1!');
        }

        if($flag == 0){
            echo 'error';
        }
        else{
            echo 1;
        }
    }

    if(isset($_POST['add_images'])){
        $filtered_data = filteration($_POST);

        $img_r = uploadImage($_FILES['image'], ROOMS_FOLDER);
        if($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'upd_fail')echo $img_r;
        else{
            $values = [$filtered_data['room_id'], $img_r];
            $sql = "INSERT INTO `room_images`(`room_id`, `image`) VALUES (?, ?)";
            $res = insert($sql, $values, "is");
            echo $res;
        }
    }

    if(isset($_POST['get_images'])){
        $res = select("SELECT `id`, `room_id`, `image`, `thumb` FROM `room_images` WHERE `room_id`=?", [$_POST['get_images']], 'i');
        $i = 1;

        $data = "";
        
        while($row = mysqli_fetch_assoc($res)){
            if($row['thumb'] == 1)$thumb = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
            else $thumb = "
                <button onclick='change_thumb($row[id], $row[room_id])' class='btn btn-secondary shadow-none'>
                    <i class='bi bi-check-lg'></i>
                </button>
            ";

            $data .= "
                <tr class='align-middle text-center'>
                    <td><img src='../images/rooms/$row[image]' width=\"30%\"></td>
                    <td>$thumb</td>
                    <td>
                        <button onclick='delete_room_images($row[id])' type='button' class='btn btn-warning shadow-none btn-sm'>
                            <i class='bi bi-trash'></i> Delete
                        </button>
                    </td
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if(isset($_POST['delete_room_images'])){
        $res = delete("DELETE FROM `room_images` WHERE `id`=?", [$_POST['delete_room_images']], 'i');
        echo $res;
    }

    if(isset($_POST['rem_room'])){
        $res1 = delete("DELETE FROM `room_images` WHERE `room_id`=?", [$_POST['rem_room']], 'i');
        $res2 = delete("DELETE FROM `rooms_facilities` WHERE `rooms_id`=?", [$_POST['rem_room']], 'i');
        $res3 = delete("DELETE FROM `rooms_features` WHERE `rooms_id`=?", [$_POST['rem_room']], 'i');
        $res4 = delete("DELETE FROM `rooms` WHERE `id`=?", [$_POST['rem_room']], 'i');  
        if($res1 || $res2 || $res3 || $res4)echo 1;
        else echo 0;
    }

    if(isset($_POST['change_thumb'])){
        $filtered_data = filteration($_POST);

        $res1 = update("UPDATE `room_images` SET `thumb`=? WHERE `room_id`=?", [0, $filtered_data['room_id']], 'ii');
        $res2 = update("UPDATE `room_images` SET `thumb`=? WHERE `id`=? AND `room_id`=?", [1, $filtered_data['image_id'], $filtered_data['room_id']], 'iii');

        if($res1 && $res2)echo 1;
        else echo 0;
    }
?>