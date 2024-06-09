<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* hide arrows from input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body class="bg-light">

    <?php include('./inc/header.php'); ?>

    <?php
    if (!isset($_GET['id'])) {
        redirect('rooms.php');
    }

    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE`id`=? AND `status` = ?", [$data['id'], 1], 'ii');
    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);
    ?>

    <div class="container">
        <div class="col-12 my-5 px-4">
            <div class="d-flex justify-content-between">
                <div class="heading">
                    <h2><?php echo $room_data['name'] ?></h2>
                </div>
            </div>
            <div style="font-size: 14px;">
                <a href="index.php" class="text-secondary text-decoration-none">Trang chủ</a>
                <span class="text-secondary"> > </span>
                <a href="rooms.php" class="text-secondary text-decoration-none">Phòng</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">           
            <div class="col-lg-7 col-md-12 bg-dark">
                <div id="roomCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <?php
                            $thumb_img = "./images/rooms/thumbnail.jpg";
                            $images = mysqli_query($conn, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
                            if (mysqli_num_rows($images) > 0) {
                                $active_class = 'active';
                                while ($images_row = mysqli_fetch_assoc($images)) {
                                    echo <<<data
                                            <div class="carousel-item $active_class w">
                                                <img src="./images/rooms/$images_row[image]" class="d-block w-100 rounded">
                                            </div>
                                            data;
                                    $active_class = '';
                                }
                            } else {
                                echo "<div class='carousel-item active'>
                                        <img src='$thumb_img' class='d-block w-100'>
                                    </div>";
                            }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <?php
                        $currency = formatCurrency($room_data['price']);
                        echo <<<price
                                <h5 class="mb-3">Giá: $currency/đêm</h5>
                            price;

                        $fea_res = mysqli_query($conn, "SELECT f.name FROM `features` f
                            JOIN `rooms_features` rfea on f.id = rfea.features_id
                            where rfea.rooms_id ='$room_data[id]'");

                        $features_data = '';
                        while ($feature_row = mysqli_fetch_assoc($fea_res)) {
                            $features_data .= "<li class = 'col-lg-6'><span class='badge rounded-pill bg-light text-dark text-wrap'>$feature_row[name]</span></li>";
                        }

                        echo <<< features
                                <div class="features mb-3">
                                    <h6 class="mb-2">Tiện ích</h6>
                                    <ul class = 'row'>
                                        $features_data
                                    </ul>
                                </div>
                            features;

                        echo <<<guests
                                <div class="guest mb-3">
                                    <h6 class="mb-2">Phù hợp</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                        $room_data[adult] Người lớn
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                        $room_data[children] Trẻ em
                                    </span>
                                </div>
                            guests;

                        echo <<<Area
                                <div class="facilities mb-3">
                                    <h6 class="mb-2">Diện tích</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                        $room_data[area] m2
                                    </span>
                                </div>
                            Area;

                        $login = 0;
                        if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                            $login = 1;
                        }

                        echo <<<book
                                <button onclick='checkLoginToBook($login, $room_data[id])' class="btn text-white w-100 custom-bg shadow-none mb-2">Đặt phòng</button>
                            book;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 shadow-sm"> 
        <div class="col-12 p-4">
            <div class="mb-4">
                <h5 class="fw-bold">Mô tả</h5>
                <p>
                    <?php
                        echo $room_data['description'];
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div class="container mt-4 shadow-sm py-5">
        <div class="mb-5 text-center">
            <h5 class="fw-bold">Xem thêm</h5>
        </div>

        <div class="swiper mySwiper swiper-initialized swiper-horizontal swiper-backface-hidden">
            <div class="swiper-wrapper mb-3">
                <?php 
                    $room_res = select("SELECT * FROM `rooms` WHERE `status` = ? AND `id`!= ? LIMIT 9",[1, $room_data['id']],'ii'); 
                    while($row = mysqli_fetch_assoc($room_res)){
                        $fea_res = mysqli_query($conn, "SELECT f.name FROM `features` f
                        JOIN `rooms_features` rfea on f.id = rfea.features_id
                        where rfea.rooms_id ='$row[id]'");

                        $features_data = '';
                        while ($feature_row = mysqli_fetch_assoc($fea_res)){
                            $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>$feature_row[name]</span>";
                        }

                        $images = mysqli_query($conn, "SELECT * FROM `room_images` WHERE `room_id`='$row[id]' AND `thumb`=1");
                        $images_row = mysqli_fetch_assoc($images);

                        echo <<<data
                            <div class="swiper-slide swiper-slide-active text-center">
                                <div class="card border-none shadow" style="max-width: 300px; min-height: 350px">
                                    <img src="./images/rooms/$images_row[image]" class="card-img-top">
                                    <div class="card-body p-3">
                                        <h5 class="text-center">$row[name]</h5>
                                    </div>
                                    <div class="d-flex justify-content-evenly mb-2 align-items-center">
                                        <a href="room_details.php?id=$row[id]" class="btn btn-outline-dark shadow-none">Chi tiết </a>
                                    </div>
                                </div>
                            </div>
                        data;
                    }
                ?>
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>

    <div class="container mt-4 shadow-sm"> 
        <div class="col-12 p-4">
            <div class="mb-4">
                <h5 class="fw-bold">Đánh giá từ khách hàng</h5>
                <p>
                    <?php
                        $review = select("SELECT r.*, u.* FROM `reviews` as r
                        JOIN `user_Cre` as u
                        ON r.user_id = u.id
                        WHERE r.room_id = ?",[$_GET['id']],'i');

                        if(mysqli_num_rows($review) == 0){
                            echo <<<data
                                <p>Hiện chưa có đánh giá từ khách hàng!</p>
                            data;
                        }
                        else{
                            while($review_fetch = mysqli_fetch_assoc($review)){
                                $rating = "";
    
                                for($i =0; $i <$review_fetch['rating']; $i++){
                                    $rating .= "<i class='bi bi-star-fill text-warning'></i>";
                                }
    
                                echo <<<data
                                    <div class="container shadow-sm mb-3">
                                        <div class="row">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="./images/users/$review_fetch[profile]" class="rounded-circle me-2" width=25px> $review_fetch[name]
                                            </div>
    
                                            <div class="mb-2">
                                                $rating
                                            </div>
    
                                            <div class="mb-2">
                                                $review_fetch[review]
                                            </div>
                                        </div>
                                    </div>
                                data;
                            }
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>


    <?php include('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 5,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        }
        });
    </script>

    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
