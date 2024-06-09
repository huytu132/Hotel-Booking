<?php
    require('inc/essentials.php');
    adminLogin();
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
                <h3 class="mb-4 text-dark fw-bold align-items-center"><i class="bi bi-gear-fill"></i> Cài đặt</h3>
                 <!-- general-1 setting -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title">Cài đặt chung</h5>
                            <button type="button" class="btn btn-outline-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                        </div>
                        <div>
                            <h6 class="card-subtitle fw-bold mb-1">Tên trang web</h6>
                            <p class="card-text" id="site_title"></p>
                            <h6 class="card-subtitle fw-bold mb-1">Mô tả</h6>
                            <p class="card-text" id="site_about"></p>
                        </div>
                    </div>
                </div>

                <!-- shutdown section -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Tắt website</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
                                </form>
                            </div>
                        </div>
                        <p class="card-text">
                            Khách hàng không thể đặt phòng khi tắt website
                        </p>
                    </div>
                </div>

                <!-- contact details section -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title">Cài đặt liên hệ</h5>
                            <button type="button" class="btn btn-outline-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contact-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Địa chỉ</h6>
                                    <p class="card-text" id="address"></p>
                                </div>

                                <div class="mb-4">
                                     <h6 class="card-subtitle fw-bold mb-1">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Số điện thoại</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>

                                <div class="mb-4">
                                     <h6 class="card-subtitle fw-bold mb-1">Email</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">Mạng xã hội</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-twitter-x me-2"></i>
                                        <span id="x"></span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-instagram me-2"></i>
                                        <span id="ins"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-facebook me-2"></i>
                                        <span id="fb"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle fw-bold mb-1">iframe</h6>
                                    <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- management team section -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title">Management Team</h5>
                            <button type="button" class="btn btn-outline-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-1">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="row" id="team-data">
                            
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <!-- modal general-1-->
    <div class="modal fade" id="general-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">General Settings</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">    
                    <div class="mb-3">
                        <label class="form-label">Site Title</label>
                        <input type="text" id="site_title_inp" name="site_title" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">About us</label>
                        <textarea class="form-control shadow-none" id="site_about_inp" name="site_about" rows="3" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" onclick = "site_title_inp.value = general_data.site_title, site_about_inp.value = general_data.site_about" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" onclick="upd_general(site_title_inp.value, site_about_inp.value)" class="btn custom-bg text-white shadow-none">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal contact -->
    <div class="modal fade" id="contact-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Contact Settings</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" id="address-inp" name="address-input" class="form-control shadow-none">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Google Map</label>
                                <input type="text" id="gmap-inp" name="gmap-input" class="form-control shadow-none">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone Numbers</label>
                                <br>
                                <label class="form-label">First</label>
                                <input type="text" id="pn1-inp" name="pn1-input" class="form-control shadow-none mb-1">
                                <label class="form-label">Second</label>
                                <input type="text" id="pn2-inp" name="pn2-input" class="form-control shadow-none">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" id="email-inp" name="email-input" class="form-control shadow-none">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Social Links</label>
                                <br>
                                <label class="form-label">Twitter (X)</label>
                                <input type="text" id="x-inp" name="x-input" class="form-control shadow-none mb-1">
                                <label class="form-label">Instagram</label>
                                <input type="text" id="ins-inp" name="ins-input" class="form-control shadow-none mb-1">
                                <label class="form-label">Facebook</label>
                                <input type="text" id = "fb-inp" name="fb-inp" class="form-control shadow-none mb-1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Iframe</label>
                                <textarea name="iframe-inp" id="iframe-inp" rows="5" style="resize: none;" class="form-control shadow-none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" onclick = "address_inp.value = contacts_data.address, gmap_inp.value = contacts_data.gmap,
                    pn1_inp.value = contacts_data.pn1, pn2_inp.value = contacts_data.pn2, email_inp.value = contacts_data.email,
                    twitter_inp.value = contacts_data.x, insta_inp.value = contacts_data.ins, fb_inp.value = contacts_data.fb,              
                    iframe_inp.value = contacts_data.iframe;" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" onclick="upd_contacts(address_inp.value, gmap_inp.value, pn1_inp.value, pn2_inp.value,
                    email_inp.value, twitter_inp.value, insta_inp.value, fb_inp.value, iframe_inp.value)" class="btn custom-bg text-white shadow-none">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>     

    <!-- management team modal -->
    <div class="modal fade" id="team-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="team-s-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Member</h1>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">    
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="member-name-inp" name="member-name" class="form-control shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Picture</label>
                            <input type="file" id="member-picture-inp" name="member-picture" accept="[.jpg, .png, .webp, .jpeg]" class="form-control shadow-none">
                        </div>
                    </div>  
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="reset" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 

    <script type="text/javascript" src="./scripts/settings.js"></script>

    <?php include('inc/scripts.php') ?>
</body>
</html>