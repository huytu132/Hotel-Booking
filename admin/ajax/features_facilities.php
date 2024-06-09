<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    adminLogin();

    if(isset($_POST['add_feature'])){
        $filtered_data = filteration($_POST);

        $sql = "INSERT INTO `features`(`name`) VALUES (?)";
        $values = [$filtered_data['name']]; 
        $res = insert($sql, $values, 's');
        echo $res;
    }

    if(isset($_POST['get_feature'])){
        $data = selectAll('features');

        $i = 1;
        while($row = mysqli_fetch_assoc($data)){
            echo <<<data
                <tr>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>
                        <button type="button" onclick="rem_feature($row[id])" class="btn btn-danger btn-sm shadow-none"">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if(isset($_POST['rem_feature'])){
        $sql = 'DELETE FROM `features` WHERE `id`=?';

        $filtered_data = filteration($_POST);

        $values = [$filtered_data['rem_feature']];

        $res = delete($sql, $values, 'i');
        echo $res;
    }


    // facility

    if(isset($_POST['add_facility'])){
        $filtered_data = filteration($_POST);

        $img_r = uploadImage($_FILES['icon'], FACILITY_FOLDER);
        if($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'upd_fail')echo $img_r;
        else{
            $values = [$filtered_data['name'], $img_r, $filtered_data['desc']];
            $sql = "INSERT INTO `facilities`(`name`, `icon`, `description`) VALUES (?,?,?)";
            $res = insert($sql, $values, "sss");
            echo $res;
        }
    }

    if(isset($_POST['get_facility'])){
        $data = selectAll('facilities');
        $i = 1;
        while($row = mysqli_fetch_assoc($data)){
            echo <<<data
                <tr class="align-middle">
                    <td>$i</td>
                    <td><img src="../images/facilities/$row[icon]" width="30px"></td>
                    <td>$row[name]</td>
                    <td>$row[description]</td>
                    <td>
                        <button type="button" onclick="rem_facility($row[id])" class="btn btn-danger btn-sm shadow-none"">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
            data;
            $i++;
        }
    }

    if(isset($_POST['rem_facility'])){
        $sql = 'DELETE FROM `facilities` WHERE `id`=?';

        $filtered_data = filteration($_POST);

        $values = [$filtered_data['rem_facility']];

        $res = delete($sql, $values, 'i');
        echo $res;
    }
?>