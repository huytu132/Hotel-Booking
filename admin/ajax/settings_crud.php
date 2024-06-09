<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');

    adminLogin();

    if(isset($_POST['get_general'])){
        $sql = "SELECT * FROM `settings` WHERE `id`=?";
        $values = [1];
        $res = select($sql, $values, 'i');

        $data = mysqli_fetch_assoc($res);
        $jason_data = json_encode($data);
        echo $jason_data;
    }

    if(isset($_POST['upd_general'])){
        $filtered_data = filteration($_POST);
        $sql = "UPDATE `settings` SET `site_title`=?,`site_about`=? WHERE `id`=1";
        $values =[$filtered_data['site_title'], $filtered_data['site_about']];
        $res = update($sql, $values,'ss');
        echo $res;
    }

    if(isset($_POST['upd_shutdown'])){
        $filtered_data = filteration($_POST);

        $sql = "UPDATE `settings` SET `shutdown`=? WHERE `id`=1";
        if($filtered_data['shutdown_value'] == 0)$values = [1];
        else $values = [0];
        $res = update($sql, $values, 'i');
        if($filtered_data['shutdown_value'] == 0)echo 1;
        else echo 0;
    }

    if(isset($_POST['get_contacts'])){
        $filtered_data = filteration($_POST);
        $sql = "SELECT * FROM `contact_details` WHERE `id`=?";
        $values=[1];
        $res = select($sql, $values, 'i');

        $data = mysqli_fetch_assoc($res);
        $jason_data = json_encode($data);
        echo $jason_data;
    }

    if(isset($_POST['upd_contacts'])){
        $filtered_data = filteration($_POST);
        $sql = "UPDATE `contact_details` SET `address`=?,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`x`=?,`ins`=?,`fb`=?,`iframe`=? WHERE `id`=1";
        $values=[$filtered_data['address'], $filtered_data['gmap'], $filtered_data['pn1'], $filtered_data['pn2'], $filtered_data['email'], $filtered_data['x'], $filtered_data['ins'], $filtered_data['fb'], $filtered_data['iframe']];
        $res = update($sql, $values, 'sssssssss');
        echo $res;
    }

    if(isset($_POST['add_member'])){
        $filtered_data = filteration($_POST);

        $img_r = uploadImage($_FILES['picture'], ABOUT_FOLDER);
        if($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'upd_fail')echo $img_r;
        else{
            $sql = "INSERT INTO `team_details` (`name`, `picture`) VALUES (?,?)";
            $values = [$filtered_data['name'], $img_r];
            $res = insert($sql, $values, 'ss');
            echo 1;
        }
    }

    if(isset($_POST['get_members'])){
        $data = selectAll('team_details');
        while($row = mysqli_fetch_assoc($data)){
            echo <<<data
                <div class="col-md-2 mb-2">
                    <div class="card bg-dark text-white">
                        <img src="../images/about/$row[picture]" class="card-img">
                        <div class="card-img-overlay text-end">
                            <button type="button" class="btn btn-danger btn-sm shadow-none">
                                Delete
                            </button>
                        </div>
                        <p class="card-text text-center px-3 py-2"><small>$row[name]</small></p>
                    </div>
                </div>
            data;
        }
    }
?>