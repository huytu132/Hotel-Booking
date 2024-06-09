<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    adminLogin();

    if(isset($_POST['changeStatus'])){
        $filtered_data = filteration($_POST);
        $sql = "UPDATE `user_cre` SET `status`=? WHERE id = ?";

        $values = [$filtered_data['value'], $filtered_data['changeStatus']];
        $res = update($sql, $values, 'ii');
        echo $res;
    }

    if(isset($_POST['get_all_users'])){
        $res = selectAll('user_cre');
        $i = 1;

        $data = "";

        while($row = mysqli_fetch_assoc($res)){
            $verified = "<span class='bagde bg-warning'><i class='bi bi-x-lg'></i></span>";
            if($row['is_verified'] == 1){
                $verified = "<span class='bagde bg-success'><i class='bi bi-check-lg'></i></span>";
            }
            $status = "<button onclick='changeStatus($row[id], 1)' class='btn btn-sm btn-warning shadow-none'>inactive</button>";
            if($row['status'] == 1){
                $status = "<button onclick='changeStatus($row[id], 0)' class='btn btn-sm btn-dark shadow-none'>active</button>";
            }
            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[email]</td>
                    <td>$row[phoneNumber]</td>
                    <td>$row[address]</td>
                    <td>$row[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$row[datentime]</td>
                    <td>
                        <button onclick='rem_user($row[id])' type='button' class='btn btn-warning shadow-none btn-sm'>
                            <i class='bi bi-trash'></i> 
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $data;
    }

    if(isset($_POST['rem_user'])){
        $res1 = delete("DELETE FROM `user_cre` WHERE `room_id`=?", [$_POST['rem_user']], 'i');
        if($res1)echo 1;
        else echo 0;
    }
?>