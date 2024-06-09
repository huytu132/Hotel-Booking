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
        .pop:hover{
            border-top-color: #279e8c !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>
</head>
<body class="bg-light">
    
    <?php include('./inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Tiện nghi</h2>
        <div class="h-line bg-dark"></div>
        <p class="col-md-6 text-center mt-3 mx-auto">
            Khách sạn cung cấp các dịch vụ và tiện nghi phù hợp với phong cách sống của mỗi khách lưu trú.
        </p>
    </div>

    <div class="container">
        <div class="row">
            <?php 
                $facilities = selectAll('facilities');

                while($row = mysqli_fetch_assoc($facilities)){
                    echo <<<facilities
                        <div class="col-lg-6 col-md-6 mb-5 px-4">
                            <div class="bg-white shadow border-top border-4 p-4 rounded border-dark pop">
                                <img src="./images/facilities/$row[icon]" width="100%" class="mb-2">
                                <h5 class="text-center fw-bold">$row[name]</h5>
                            </div>
                        </div>
                    facilities;
                }
            ?>       
        </div>
    </div>

    <?php include('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>