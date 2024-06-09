<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <style>
        .box{
            border-top-color: #C1B086 !important;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php include('./inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">ABOUT US</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3 col-md-6 mx-auto">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
            Consectetur dolorum inventore odio qui consequuntur, cumque illo aspernatur mollitia 
            corrupti molestiae, debitis, explicabo totam maxime earum nulla placeat ipsam doloribus facilis.
        </p>
    </div>

    <div class="container">
        <div class="row align-items-center p-4 justify-content-between">
            <div class="col-lg-6 col-md-5 order-md-1 order-2 mb-4">
                <h3>Lorem ipsum dolor</h3>
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Voluptate consectetur necessitatibus eligendi voluptatibus veritatis soluta, 
                    porro maxime commodi dolor nostrum, omnis ut reprehenderit nemo quas, vitae laborum? Odit, vero quod.
                </p>
            </div>

            <div class="col-lg-5 col-md-5 order-md-2 order-1 mb-4">
                <img src="./images/about/about.jpg" alt="" class="w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white shadow text-center border-top border-4 p-4 rounded box">
                    <img src="./images/about/hotel.svg" width="70px">
                    <h4 class="mt-3">50+ PHÒNG</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white shadow text-center border-top border-4 p-4 rounded box">
                    <img src="./images/about/customers.svg" width="70px">
                    <h4 class="mt-3">500+ KHÁCH HÀNG</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white shadow text-center border-top border-4 p-4 rounded box">
                    <img src="./images/about/rating.svg" width="70px">
                    <h4 class="mt-3">200+ ĐÁNH GIÁ</h4>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white shadow text-center border-top border-4 p-4 rounded box">
                    <img src="./images/about/staff.svg" width="70px">
                    <h4 class="mt-3">100+ NHÂN VIÊN</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="fw-bold h-font text-center mt-5">BAN QUẢN LÝ</h3>
    <div class="h-line bg-dark"></div>
    
    <div class="container px-4 mt-5">
        <div class="swiper mySwiper swiper-initialized swiper-horizontal swiper-backface-hidden">
            <div class="swiper-wrapper mb-3">
                <div class="swiper-slide swiper-slide-active text-center">
                    <img src="./images/about/IMG_16569.jpeg" class="w-100">
                    <h5>Name</h5>
                </div>
                <div class="swiper-slide swiper-slide-active text-center">
                    <img src="./images/about/IMG_16569.jpeg" class="w-100">
                    <h5>Name</h5>
                </div>
                <div class="swiper-slide swiper-slide-active text-center">
                    <img src="./images/about/IMG_16569.jpeg" class="w-100">
                    <h5>Name</h5>
                </div>
                <div class="swiper-slide swiper-slide-active text-center">
                    <img src="./images/about/IMG_16569.jpeg" class="w-100">
                    <h5>Name</h5>
                </div>
                <div class="swiper-slide swiper-slide-active text-center">
                    <img src="./images/about/IMG_16569.jpeg" class="w-100">
                    <h5>Name</h5>
                </div>
                <div class="swiper-slide swiper-slide-active text-center">
                    <img src="./images/about/IMG_16569.jpeg" class="w-100">
                    <h5>Name</h5>
                </div>
                <div class="swiper-slide swiper-slide-active text-center">
                    <img src="./images/about/IMG_16569.jpeg" class="w-100">
                    <h5>Name</h5>
                </div>
            </div>
            <div class="swiper-pagination swiper-pagination-bullets swiper-pagination-horizontal">
                <span class="swiper-pagination-bullet swiper-pagination-bullet-active" aria-current="true"></span>
                <span class="swiper-pagination-bullet"></span>
                <span class="swiper-pagination-bullet"></span>
                <span class="swiper-pagination-bullet"></span>
                <span class="swiper-pagination-bullet"></span>
                <span class="swiper-pagination-bullet"></span>
                <span class="swiper-pagination-bullet"></span>
                <span class="swiper-pagination-bullet"></span>
                <span class="swiper-pagination-bullet"></span>
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>

    <?php include('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        
    <script>
        var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 5,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
        },
        });
    </script>

    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>