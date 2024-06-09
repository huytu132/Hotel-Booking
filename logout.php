<?php 
    include('admin/inc/essentials.php');
    include('admin/inc/db_config.php');

    update("UPDATE `user_cre` SET `active` = 0 WHERE `id`=?", [$_GET['id']], 'i');    
    session_start();
    session_destroy();
    redirect('index.php');
?>