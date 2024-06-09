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
                <h3 class="mb-4 text-dark fw-bold align-items-center">CAROUSEL</h3>

    <!-- Carousel -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0">Carousel</h5>
                            <button type="button" class="btn btn-sm btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#carousel-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Carousel modal -->

    <div class="modal fade" id="carousel-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">General Settings</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">    
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" id="member-name-inp" name="member-name" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Picture</label>
                        <textarea class="form-control shadow-none" id="member-picture-inp" name="member-picture" rows="3" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" onclick = "" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn custom-bg text-white shadow-none">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="./scripts/settings.js"></script>

    <?php include('inc/scripts.php') ?>
</body>
</html>