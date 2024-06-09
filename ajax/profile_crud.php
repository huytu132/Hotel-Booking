<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');

    if(isset($_POST['getProfile'])){
        $res = select("SELECT * FROM `user_cre` WHERE `id`=?", [$_POST['uID']], 'i');
        $user = mysqli_fetch_assoc($res);

        $result = json_encode(["name"=>$user['name'], "phone"=>$user['phoneNumber'], "email"=>$user['email'], "address"=>$user['address'], "pincode"=>$user['pincode'], "dob"=>$user['dob'], "profile"=>$user['profile']]);
        echo $result;
    }
    
    if(isset($_POST['editProfile'])){
        $data = filteration($_POST);
        $sql = "UPDATE `user_cre` SET `name`=?, `address`=?, `phoneNumber`=?, `email`=?, `pincode`=?, `dob`=? WHERE `id`=?";
        $values = [$data['name'], $data['address'], $data['phone'], $data['email'], $data['pincode'], $data['dob'], $data['uID']];
        if(update($sql, $values, 'ssssssi'))echo 1;
        else echo 0;
    }
?>