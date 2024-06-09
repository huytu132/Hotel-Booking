<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <?php include('./inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <style>
        .availability-form{
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px) {
            .availability-form{
                margin-top: 0px;
                padding: 0 50px;
            }            
        }

        .pop:hover{
            border-top-color: #279e8c !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php include('./inc/header.php'); ?>

    <!-- Slider -->
    <div class="container-fluid px-lg-3 mt-4">
        <div class="swiper firstSlider swiper-initialized swiper-horizontal swiper-backface-hidden">
            <div class="swiper-wrapper" id="swiper-wrapper-a79380a2b0e478ef" aria-live="polite">
            <div class="swiper-slide swiper-slide-active" style="width: 1536px;" role="group" aria-label="1 / 9">
                <img src="./images/carousel/IMG_40905.png" alt="">
            </div>
            <div class="swiper-slide swiper-slide-next" style="width: 1536px;" role="group" aria-label="2 / 9">
                <img src="./images/carousel/IMG_15372.png" alt="">
            </div>
            <div class="swiper-slide" style="width: 1536px;" role="group" aria-label="3 / 9">
                <img src="./images/carousel/IMG_55677.png" alt="">
            </div>
            <div class="swiper-slide" style="width: 1536px;" role="group" aria-label="4 / 9">
                <img src="./images/carousel/IMG_62045.png" alt="">
            </div>
            <div class="swiper-slide" style="width: 1536px;" role="group" aria-label="5 / 9">
                <img src="./images/carousel/IMG_93127.png" alt="">
            </div>
            <div class="swiper-slide" style="width: 1536px;" role="group" aria-label="6 / 9">
                <img src="./images/carousel/IMG_99736.png" alt="">
            </div>
        </div>
        <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-a79380a2b0e478ef" aria-disabled="false"></div>
        <div class="swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-a79380a2b0e478ef" aria-disabled="true"></div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>
    
    <!-- check booking available form -->
    <div class="container bg-white shadow p-4 rounded availability-form">
        <div class="row">
            <div class="col-lg-12">
                <h5 class="mb-4">Tìm kiếm phòng</h5>
            </div>
        </div>
        <form action="rooms.php">
            <div class="row align-items-end">
                <div class="col-lg-3 mb-3">
                    <label class="form-label" style="font-weight: 500;">Check-in</label>
                    <input type="date" name="checkin" class="form-control shadow-none" required>
                </div>
                <div class="col-lg-3 mb-3">
                    <label class="form-label" style="font-weight: 500;">Check-out</label>
                    <input type="date" name="checkout" class="form-control shadow-none" required>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" style="font-weight: 500;">Người lớn</label>
                    <select class="form-select shadow-none" name="adult">
                        <?php 
                            $rooms_que = mysqli_fetch_assoc(select("SELECT MAX(adult) as `adults`, MAX(children) as `children`
                            FROM `rooms` WHERE `status`=?", [1], 'i'));
                            for($i=1; $i<=$rooms_que['adults']; $i++){
                                echo "<option value=$i>$i</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" style="font-weight: 500;">Trẻ em</label>
                    <select class="form-select shadow-none" name="children">
                        <?php 
                            for($i=1; $i<=$rooms_que['children']; $i++){
                                echo "<option value=$i>$i</option>";
                            }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="check_availability">
                <div class="col-lg-2 mb-3">
                    <button type="submit" class="btn text-white shadow-none custom-bg">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>

        <div class="container memory-section">
            <div class="row align-items-center">
                <div class="col-lg-5 p-0" style="z-index: 1; position: relative; left: 20px">
                    <div class="memory-item shadow p-5">
                        <div class="memory-content p-3">
                            <h2 class="fw-bold intro-title mb-2">Hãy tạo nên kỷ niệm vàng của bạn với chúng tôi!</h2>
                            <div style="text-align:justify">
                                <p>Đến với chúng tôi, bạn sẽ được hòa mình vào với thiên nhiên trong lành, được tham gia các hoạt động vui chơi giải trí, thư giãn nghỉ ngơi để trút bỏ hết những ưu phiền và bộn bề của cuộc sống</p>
                            </div>
                        </div>

                        <div class="memory-btn p-3">
                            <a href="./about.php" class="memory-btn-one text-decoration-none">Đọc thêm <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div style="position: relative;" class="">
                        <img class="dot-image" src="./images/about/dot-image.png" alt="image">
                    </div>
                </div>

                <div class="col-lg-7 p-0" style="z-index: 0;">
                    <img src="./images/about/losuoi.jpg" style="position: relative; width: 100%;" alt="image">
                </div>
            </div>
        </div>


    <!-- Our rooms -->

    <div class="container" style="margin-bottom: 80px;">
        <div class="mt-5 pt-4 mb-4 d-flex justify-content-between">
            <div class="heading">
                <h2>Phòng</h2>
            </div>
            <div>
                <a href="rooms.php" class="btn text-white rounded shadow-none custom-bg">Xem tất cả</a>
            </div>
        </div>

        <div class="row">
            
                <?php 
                    $room_res = select("SELECT * FROM `rooms` WHERE `status` = ? LIMIT 3",[1],'i'); 
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

                        $login = 0;
                        if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                            $login = 1;
                        }

                        echo <<< room
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="card border-none shadow pop pb-3" style="max-width: 350px; min-height: 400px; margin:auto;">
                                    <img src="./images/rooms/$images_row[image]" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="text-center">$row[name]</h5>
                                    </div>
                                    <div class="d-flex justify-content-evenly mb-2 align-items-center">
                                        <a href="room_details.php?id=$row[id]" class="btn btn-outline-dark shadow-none">Chi tiết </a>
                                        <button onclick='checkLoginToBook($login, $row[id])' class="btn text-white custom-bg shadow-none">Đặt phòng</button>
                                    </div>
                                </div>
                            </div>
                        room;
                    }
                ?>
            </div>

        </div>

    </div>

    <div class="container-fluid p-0 mb-5" style="background-image: url(images/about/youtube.jpg); width: 100%; height: 800px; background-size: cover; background-position: bottom center;" >
        <div class="youtube_overlay h-100">
            <div class="text-center text-white d-flex flex-column justify-content-center align-items-center h-100">
                <div>
                    <a href="https://youtu.be/CMC8jaUjVQk" target="_blank" class="text-decoration-none"><i class="bi bi-youtube" style="font-size: 50px; color: white;"></i></a>
                </div>
                <div class="mb-2">Khám phá. Đi lang thang. Nghỉ ngơi</div>
                <h2>
                    Một cuộc đi chơi bạn sẽ <br>đặc biệt nhớ tới
                </h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="text-center mb-5">
            <h2>Phản hồi khách hàng</h2>
        </div>
        <div class="row d-flex justify-content-between">
            <?php 
                $res = mysqli_query($conn, "SELECT r.*, u.* FROM `reviews` as r
                                    JOIN `user_cre` as u
                                    ON r.user_id = u.id
                                    ORDER BY `rating` desc LIMIT 3");
                while($row = mysqli_fetch_assoc($res)){
                    $rating = "";
                    for($i=0; $i<$row['rating'];$i++)$rating .= "<i class='bi bi-star-fill text-warning'></i>";
                    echo <<<data
                        <div class="col-lg-3 col-md-6 text-center border p-3" style="min-height: 400px">
                            <img src="./images/users/$row[profile]" alt="" class="rounded-circle mb-3" style="width: 50%; height:40%;">
                            <h3 class="mb-3">$row[name]</h3>
                            $rating
                            <p class="my-3">"$row[review]"</p>
                        </div>
                    data;
                }
            ?>
        </div>
    </div>

    <section class="restaurant my-3 py-3" id="restaurant">
        <div class="container mt-5 pt-4 mb-4 d-flex justify-content-between">
            <div class="heading">
                <h2>Câu hỏi thường gặp</h2>
            </div>
        </div>

        <div class="container d-flex shadow" style="min-height: 500px;">
            <div class="col-md-6">
                <img src="./images/rooms/IMG_18933.jpg" class="w-100">
            </div>
            <div class="col-md-6 p-3">
                <div class="mb-3">
                    <h2 class="text-center">Hotel</h2>
                </div>
                <div class="accordionWrapper">
                    <div class="accordionItem open">
                        <h2 class="accordionIHeading d-flex justify-content-between justify-items-center p-3">Khách sạn có bể bơi không? <i class="bi bi-caret-down-fill"></i></h2>
                        <div class="accordionItemContent shadow">
                            <p>Khách sạn có bể bơi vô cực ngoài trời</p>
                        </div>
                    </div>
                    <div class="accordionItem close">
                    <h2 class="accordionIHeading d-flex justify-content-between justify-items-center p-3">Khách sạn có khu vực để xe cho ô tô không? <i class="bi bi-caret-down-fill"></i></h2>
                        <div class="accordionItemContent">
                            <p>Khách sạn có tầng hầm là khu để xe, đảm bảo an toàn cho quý khách.</p>
                        </div>
                    </div>
                    <div class="accordionItem close">
                    <h2 class="accordionIHeading d-flex justify-content-between justify-items-center p-3">Khách sạn có bể bơi không <i class="bi bi-caret-down-fill"></i></h2>
                        <div class="accordionItemContent">
                            <p>Khách sạn có bể bơi vô cực ngoài trời</p>
                        </div>
                    </div>
                    <div class="accordionItem close">
                    <h2 class="accordionIHeading d-flex justify-content-between justify-items-center p-3">Khách sạn có bể bơi không <i class="bi bi-caret-down-fill"></i></h2>
                        <div class="accordionItemContent">
                            <p>Khách sạn có bể bơi vô cực ngoài trời</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <script>
    var accItem = document.getElementsByClassName('accordionItem');
    var accHD = document.getElementsByClassName('accordionIHeading');

    for (i = 0; i < accHD.length; i++) {
      accHD[i].addEventListener('click', toggleItem, false);
    }

    function toggleItem() {
      var itemClass = this.parentNode.className;
      for (var i = 0; i < accItem.length; i++) {
        accItem[i].className = 'accordionItem close';
      }
      if (itemClass == 'accordionItem close') {
        this.parentNode.className = 'accordionItem open';
      }
    }
  </script>

    <div class="container my-5">
        <div class="mt-5 pt-4 mb-4 d-flex justify-content-between">
            <div class="heading">
                <h2>Không gian</h2>
            </div>
        </div>
        <div class="row mt-5">
            <?php 
                $image = mysqli_query($conn, "SELECT * FROM `room_images` LIMIT 8");
                while($row = mysqli_fetch_assoc($image)){
                    echo <<<data
                        <div class="col-lg-3 col-md-4 p-1 pop">
                            <img src="./images/rooms/$row[image]" class="w-100" style="border-radius: 20px;">
                        </div>
                    data;
                }
            ?>
        </div>
    </div>
    <!-- Reach us -->

    <?php include('./inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>