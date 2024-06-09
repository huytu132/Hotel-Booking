<!-- Footer -->
<?php 
    $res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `contact_details` WHERE `id`=1;"));

?>


<div class="container-fluid text-white shadow mt-5 footer p-0">
    <div class="row p-5">
        <div class="col-md-4 p-4" style="z-index: 2;">
            <h3 class="h-font fw-bold fs-3 mb-3">HOTEL</h3>
            <p>
                Chúng tôi luôn cố gắng mang lại 
                <br>những trải nghiệm tốt nhất cho khách hàng!
            </p>
        </div>

        <div class="col-md-3 p-2" style="z-index: 2;">
            <a href="index.php" class="text-white text-decoration-none d-inline-block mb-3">Trang chủ</a>
            <br>
            <a href="rooms.php" class="text-white text-decoration-none d-inline-block mb-3">Phòng</a>
            <br>
            <a href="facilities.php" class="text-white text-decoration-none d-inline-block mb-3">Tiện nghi</a>
            <br>
            <a href="contact.php" class="text-white text-decoration-none d-inline-block mb-3">Liên hệ</a>
            <br>
            <a href="about.php" class="text-white text-decoration-none d-inline-block mb-3">Về chúng tôi</a>
        </div>

        <div class="col-md-3 p-2" style="z-index: 2;">
            <a href="" class="d-inline-block mb-2 text-decoration-none text-white mb-3"><i class="bi bi-twitter-x"></i> X</a>
            <br>
            <a href="" class="d-inline-block mb-2 text-decoration-none text-white mb-3"><i class="bi bi-instagram"></i> Instagram</a>
            <br>
            <a href="" class="d-inline-block text-decoration-none text-white mb-3"><i class="bi bi-facebook"></i> Facebook</a>
        </div>

        <div class="col-md-2 p-2" style="z-index: 2;">
            <span class="d-inline-block mb-2 text-decoration-none text-white mb-3"><i class="bi bi-geo-alt-fill"></i> <?php echo  $res['address']?></span>
            <br>
            <span class="d-inline-block mb-2 text-decoration-none text-white mb-3"><i class="bi bi-telephone-fill"></i> <?php echo  $res['pn1']?></span>
            <br>
            <span class="d-inline-block mb-2 text-decoration-none text-white mb-3"><i class="bi bi-telephone-fill"></i> <?php echo  $res['pn2']?></span>
            <br>
            <span class="d-inline-block mb-2 text-decoration-none text-white mb-3"><i class="bi bi-envelope-fill"></i> <?php echo  $res['email']?></span>
        </div>
    </div>
</div>