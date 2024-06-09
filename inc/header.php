<?php 
    include('admin/inc/db_config.php');
    include('admin/inc/essentials.php');
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">Hotel</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active me-2" aria-current="page" href="index.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="rooms.php">Phòng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="facilities.php">Tiện nghi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="contact.php">Liên hệ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Về chúng tôi</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php 
                    if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                        echo <<<data
                            <div class="btn-group">
                                <button type="button" class="btn text-dark border dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    <img class="rounded-circle" src="./images/users/$_SESSION[uProfile]" width=25px>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-lg-end">
                                    <li><a class="dropdown-item" type="button" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" type="button" href="bookings.php">Lịch sử đặt phòng</a></li>
                                    <li><a class="dropdown-item" type="button" href="logout.php?id=$_SESSION[uID]">Đăng xuất</a></li>
                                </ul>
                            </div>
                        data;
                    }
                    else{
                        echo <<<data
                        <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Đăng nhập
                        </button>
                        <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#registerModal">
                            Đăng ký
                        </button>
                        data;
                    }
                ?>
            </div>
        </div>
    </div>
</nav>
<!-- Login Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="login-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Đăng nhập
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email/Phone</label>
                        <input type="text" name='email-phone' class="form-control shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-dark shadow-none" style="padding-left:25px; padding-right: 25px;">Đăng nhập</button>
                </div>
                <div class="d-flex align-items-center mb-3 mx-3 justify-content-between">
                    <button type="button" class="btn text-decoration-none text-secondary shadow-none p-0" data-bs-target="#registerModal" data-bs-toggle="modal" data-bs-dismiss="modal">Đăng ký</button>
                    <button type="button" class="btn text-decoration-none text-secondary shadow-none p-0" data-bs-target="#forgotModal" data-bs-toggle="modal" data-bs-dismiss="modal">Quên mật khẩu</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
<!-- Register Modal -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="register-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Register
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-danger text-wrap lh-base mb-3 mx-auto">
                        Note: Người dùng phải cung cấp thông tin đúng với khi check-in!
                    </span>
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Họ và tên</label>
                                <input name="name" type="text" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Số điện thoại</label>
                                <input name="phone" type="text" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Ảnh chính chủ</label>
                                <input name="profile" accept=".pnh, .jpeg, .jpg, .webp" type="file" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 ps-0">
                                <label for="form-label">Địa chỉ</label>
                                <textarea name="address" style="resize: none;" class="form-control shadow-none" rows="2" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Mã bưu điện</label>
                                <input name="pincode" type="text" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Ngày sinh</label>
                                <input name="dob" type="date" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Mật khẩu</label>
                                <input name="pass" type="password" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 ps-0">
                                <label class="form-label">Nhập lại mật khẩu</label>
                                <input name="cpass" type="password" class="form-control shadow-none" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3 mx-3 justify-content-between">
                    <button type="submit" class="btn btn-dark shadow-none">Đăng ký</button>
                    <button type="button" class="btn text-decoration-none text-secondary shadow-none p-0" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Đăng nhập</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- forgot pass -->
<div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgotModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="forgot-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Quên mật khẩu
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-dark text-wrap lh-base mb-3 mx-auto">
                        Lưu ý: Email quên mật khẩu sẽ được gửi tới bạn, nhấn vào link và thay đổi mật khẩu mới.
                    </span>
                    <div class="container-fluid">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name='email' class="form-control shadow-none" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3 mx-3 justify-content-between">
                    <button type="submit" class="btn btn-dark shadow-none">Gửi email</button>
                    <button type="button" class="btn text-decoration-none text-secondary shadow-none p-0" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Đăng nhập</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="toastBox"></div>

<div id="confirmBox"></div>