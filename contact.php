<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>
<body class="bg-light">
    
    <?php include('./inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Liên hệ</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3 col-md-6 mx-auto">
            Đặt câu hỏi cho chúng tôi!!!
        </p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 px-4">
                <div class="bg-white shadow rounded p-4">
                    <div>
                        <iframe class="w-100" height="350" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6483.288266585901!2d105.7857165263717!3d20.97957904818472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135accdd8a1ad71%3A0xa2f9b16036648187!2zSOG7jWMgdmnhu4duIEPDtG5nIG5naOG7hyBCxrB1IGNow61uaCB2aeG7hW4gdGjDtG5n!5e0!3m2!1svi!2s!4v1711794425502!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <h5 class="fw-bold mt-3">Địa chỉ</h5>
                    <a href="https://maps.app.goo.gl/SoT6QjkTNrwjDwBCA" target="_blank" class="text-decoration-none text-dark">
                        <i class="bi bi-geo-alt-fill"></i>
                        96A Đường Trần Phú, P. Mộ Lao, Hà Đông, Hà Nội
                    </a>
                    <h5 class="fw-bold mt-3">Call</h5>
                    <a href="#" class="d-inline-block text-dark mb-2 text-decoration-none">
                        <i class="bi bi-telephone-fill"></i> +122483825
                    </a>
                    <br>
                    <a href="#" class="d-inline-block text-dark mb-2 text-decoration-none">
                        <i class="bi bi-telephone-fill"></i> +1224429240205
                    </a>
                    <h5 class="fw-bold mt-3">Email</h5>
                    <a href="#" class="text-dark text-decoration-none">
                        <i class="bi bi-envelope-fill"></i>
                        tunh.ptit@gmail.com
                    </a>
                    <h5 class="fw-bold mt-3">Follow us</h5>
                    <a href="" class="d-inline-block mb-2">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-twitter-x"></i>
                        </span>
                    </a>
                    <a href="" class="d-inline-block mb-2">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram"></i>
                        </span>
                    </a>
                    <a href="" class="d-inline-block">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 px-4">
                <div class="bg-white shadow p-4 rounded">
                    <form method="POST">
                        <div>
                            <label class="form-label" style="font-weight: 500;">Họ và tên</label>
                            <input name="name" type="text" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Email</label>
                            <input name="email" type="email" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Tiêu đề</label>
                            <input name="subject" type="text" class="form-control shadow-none" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Nội dung</label>
                            <textarea name="message" class="form-control shadow-none" rows="5" style="resize: none;" required></textarea>
                        </div>
                           <button type="submit" name="send" class="custom-bg btn text-white mt-3">GỬI</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php 
        if(isset($_POST['send'])){
            $filtered_data = filteration($_POST);

            $sql = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$filtered_data['name'], $filtered_data['email'], $filtered_data['subject'], $filtered_data['message']];
            
            $res = insert($sql, $values, 'ssss');
            if($res == 1)alert('success', 'Mail sent!');
            else alert('', 'Error!');
        }
    ?>

    <?php include('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>