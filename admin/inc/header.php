<div class="container-fluid bg-dark text-white shadow d-flex align-items-center justify-content-between sticky-top">
    <h3 class="h-font">Admin</h3>
    <a href="logout.php" class="btn btn-sm text-dark bg-white shadow-none">Đăng xuất</a>
</div>

<div class="col-lg-2 bg-dark border-top border-4 border-secondary dashboard-menu" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2 text-light">HOTEL</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch" id="adminNavbarNav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn text-white shadow-none px-3 w-100 text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#bookingLinks">
                            <span>Lịch đặt phòng</span>
                            <span><i class="bi bi-caret-down-fill"></i></span>
                        </button>

                        <div class="collapse" id="bookingLinks">
                            <ul class="nav nav-pills flex-column rounded border border-secondary">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="new_bookings.php">Lịch đặt phòng mới</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="booking_records.php">Lịch sử đặt phòng</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="users.php">Người dùng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rooms.php">Phòng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="features_facilities.php">Tiện ích</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rating_reviews.php">Đánh giá</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_queries.php">Câu hỏi của khách hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="carousel.php">Ảnh Slide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Cài đặt</a>
                    </li>
                </ul>
            </div>  
        </div>
    </nav>
</div>