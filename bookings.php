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
        if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
            redirect("index.php"); 
        }
    ?>

    <div class="container mt-5 pt-4 mb-4 d-flex justify-content-between">
        <div class="heading">
            <h2>LỊCH SỬ ĐẶT PHÒNG</h2>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php 
                $sql = "SELECT bo.*, bd.* FROM `booking_order` bo
                JOIN `booking_details` bd ON bo.id = bd.booking_id
                WHERE bo.user_id = ? ORDER BY bo.id DESC";

                $res = select($sql, [$_SESSION['uID']], 'i');
                while($order = mysqli_fetch_assoc($res)){
                    $currency = formatCurrency($order['price']);
                    $total = formatCurrency($order['total_pay']);
                    $date = date("d-m-Y", strtotime($order['datentime']));
                    $checkin = date("d-m-Y", strtotime($order['check_in']));
                    $checkout = date("d-m-Y", strtotime($order['check_out']));

                    $status_bg = "";
                    $content = "";
                    $btn = "";

                    if($order['status'] == 1){
                        $content = "Đã nhận phòng";
                        $status_bg = "bg-success";
                        $btn = "<a href='generate_pdf.php?gen_pdf&id=$order[booking_id]' class='btn btn-dark btn-sm shadow-none'>Tải PDF</a>
                        ";
                        if($order['reviewed'] == 0)$btn .= "<button onclick='getID($order[booking_id], $order[room_id], $_SESSION[uID])' type='button' class='btn btn-dark btn-sm shadow-none' data-bs-toggle='modal' data-bs-target='#reviewModal'>Đánh giá</button>";
                    }
                    else if($order['status'] == 0){
                        $content = "Chờ nhận phòng";
                        $status_bg = "bg-warning";
                        $btn = "<button id='cancelButtonOut' onclick='getID($order[booking_id], $order[room_id], $_SESSION[uID])' type='button' class='btn btn-danger btn-sm shadow-none'>Hủy</button>";
                    }
                    else{
                        $status_bg = "bg-danger";
                        $content = "Đã hủy";
                        $btn = "<a href='generate_pdf.php?gen_pdf&id=$order[booking_id]' class='btn btn-dark btn-sm shadow-none'>Tải PDF</a>
                        ";
                    }
                    

                    echo <<<bookings
                        <div class="col-md-4 px-4 mb-4">
                            <div class="bg-white p-3 rounded shadow-sm" style="min-height: 350px;">
                                <h5 class="fw-bold">$order[room_name]</h5>
                                <p> $currency/đêm</p>
                                <p>
                                    <b>Check-in: </b>$checkin <br>
                                    <b>Check-out: </b>$checkout
                                </p>

                                <p>
                                    <b>Tổng tiền: </b>$total <br>
                                    <b>Ngày đặt: </b>$date
                                </p>

                                <p>
                                    <span class="badge $status_bg mb-3">$content</span> <br>
                                    $btn
                                </p>
                            </div>
                        </div>
                    bookings;
                }
            ?>
        </div>
    </div>

    <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="review-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-person-circle fs-3 me-2"></i> Nhận xét 
                        </h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Đánh giá</label>
                                    <select class="form-select" name="rating" required aria-label="Floating label select example">
                                        <option selected>Cảm nhận của khách hàng</option>
                                        <option value="5">Xuất sắc</option>
                                        <option value="4">Tốt</option>
                                        <option value="3">Khá</option>
                                        <option value="2">Trung bình</option>
                                        <option value="1">Tệ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="form-label">Cảm nhận của bạn</label>
                                    <textarea name="review" style="resize: none;" class="form-control shadow-none" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="booking_id">
                    <input type="hidden" name="room_id">
                    <input type="hidden" name="user_id">
                    <div class="mb-3 mx-3 text-center">
                        <button type="submit" class="btn btn-dark shadow-none">Gửi đánh giá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let review_form = document.getElementById('review-form');

        function getID(booking_id, room_id, user_id){
            review_form.elements['booking_id'].value = booking_id;
            review_form.elements['room_id'].value = room_id;
            review_form.elements['user_id'].value = user_id;
        }

        review_form.addEventListener('submit', function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('submitReview', '');
            data.append('booking_id', review_form.elements['booking_id'].value);
            data.append('room_id', review_form.elements['room_id'].value);
            data.append('rating', review_form.elements['rating'].value);
            data.append('review', review_form.elements['review'].value);
            data.append('user_id', review_form.elements['user_id'].value);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/review_crud.php', true);

            xhr.onload = function(){
                if(this.responseText == 1){
                    showToast('success', 'Gửi đánh giá thành công!');
                    window.location.href = window.location.href;
                    review_form.reset();
                }
                else showToast('error', 'Có lỗi xảy ra!');

                
            }
            xhr.send(data);
        });

        let cancelButtonOut = document.getElementById('cancelButtonOut');
        cancelButtonOut.addEventListener('click', function(e){
            confirmAction();
        });

        
    </script>

    <?php include('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>