<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen'])){
        $filtered_data = filteration($_GET);
        $sql = "UPDATE `user_queries` SET `seen`=?";

        if($filtered_data['seen'] == 'all'){
            $sql = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            $res = update($sql, $values, 'i');
            if($res)alert('success', 'Mark all as read');
            else alert('', 'Fail to mark all!');
        }
        else{
            $sql = "UPDATE `user_queries` SET `seen`=? WHERE `id`=?";
            $values = [1, $filtered_data['seen']];
            $res = update($sql, $values, 'ii');
            if($res)alert('success', 'Mark as read');
            else alert('', 'Fail to mark!');
        }
    }

    if(isset($_GET['del'])){
        $filtered_data = filteration($_GET);

        if($filtered_data['del'] == 'all'){
            $sql = "DELETE FROM `user_queries`";
            if(mysqli_query($conn, $sql))alert('success', 'Delete all');
            else alert('', 'Fail to delete all!');
        }
        else{
            $sql = "DELETE FROM `user_queries` WHERE `id`=?";
            $values = [$filtered_data['del']];
            $res = delete($sql, $values, 'i');
            if($res)alert('success', 'Deleted');
            else alert('', 'Fail to delete!');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Admin Dashboard</title>
    <?php include('inc/links.php'); ?>
</head>
<body class="bg-light">
    
    <?php include('inc/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 ms-auto overflow-hidden p-2">
                <h3 class="mb-4 text-dark fw-bold align-items-center">Câu hỏi</h3>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">Đánh dấu tất cả</a>
                            <a href="?del=all" class="btn btn-dark rounded-pill shadow-none btn-sm">Xóa tất cả</a>
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y:scroll">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="text-light bg-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Họ tên</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Lời nhắn</th>
                                        <th scope="col">Ngày gửi</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    
                                        $sql = "SELECT * FROM `user_queries` ORDER BY `id` DESC";
                                        $data = mysqli_query($conn, $sql);
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($data)){
                                            $seen = '';
                                            if($row['seen'] != 1){
                                                $seen = "<a href='?seen=$row[id]' class='btn btn-sm rounded-pill btn-primary'>Đánh dấu đã đọc</a>";
                                            }
                                            $seen .= "<a href='?del=$row[id]' class='btn btn-sm rounded-pill btn-danger'>Xóa</a>";
                                            echo "<tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td>$row[datentime]</td>
                                                    <td>$seen</td>
                                                 </tr>";
                                            $i++;
                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('inc/scripts.php') ?>
</body>
</html>