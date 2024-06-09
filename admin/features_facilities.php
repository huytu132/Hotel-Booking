<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminLogin();

    if(isset($_GET['seen'])){
        $filtered_data = filteration($_GET);
        $sql = "UPDATE `user_queries` SET `seen`=?";

        if($filtered_data['seen'] == 'all'){
            $sql = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            $res = update($sql, $values, 'i');
            if($res)alert('success', 'Mark all as read');
            else alert('', 'Fail to mark all!');
        }
        else{
            $sql = "UPDATE `user_queries` SET `seen`=? WHERE `id`=?";
            $values = [1, $filtered_data['seen']];
            $res = update($sql, $values, 'ii');
            if($res)alert('success', 'Mark as read');
            else alert('', 'Fail to mark!');
        }
    }

    if(isset($_GET['del'])){
        $filtered_data = filteration($_GET);

        if($filtered_data['del'] == 'all'){
            $sql = "DELETE FROM `user_queries`";
            if(mysqli_query($conn, $sql))alert('success', 'Delete all');
            else alert('', 'Fail to delete all!');
        }
        else{
            $sql = "DELETE FROM `user_queries` WHERE `id`=?";
            $values = [$filtered_data['del']];
            $res = delete($sql, $values, 'i');
            if($res)alert('success', 'Deleted');
            else alert('', 'Fail to delete!');
        }
    }
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
                <h3 class="mb-4 text-dark fw-bold align-items-center">Tiện ích</h3>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">  </h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s">
                                <i class="bi bi-plus-square"></i> Thêm
                            </button>
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y:scroll">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="text-light bg-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="feature-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 ms-auto overflow-hidden p-2">
                <h3 class="mb-4 text-dark fw-bold align-items-center">Tiện nghi</h3>
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">  </h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                                <i class="bi bi-plus-square"></i> Thêm
                            </button>
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y:scroll">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="text-light bg-dark">
                                        <th scope="col">#</th>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Mô tả</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="facility-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->

    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="feature-s-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Feature</h5>                       
                    </div>
                    <div class="modal-body">    
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="feature_name" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset"class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- facilities modal -->
    <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="facility-s-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm tiện ích</h5>                       
                    </div>
                    <div class="modal-body">    
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="facility-name" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon</label>
                            <input type="file" name="facility-icon" accept=".svg, .jpg" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="facility-desc" rows="3" class="form-control shadow-none" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let feature_s_form = document.getElementById('feature-s-form');
        let facility_s_form = document.getElementById('facility-s-form');
        feature_s_form.addEventListener('submit', function(e){
            e.preventDefault();
            add_feature();
        });

        // feature

        function add_feature(){
            let data = new FormData();
            data.append('name',feature_s_form.elements['feature_name'].value);
            data.append('add_feature','');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/features_facilities.php', true);

            xhr.onload = function(){
                var myModal = document.getElementById("feature-s");
                var mymodal = bootstrap.Modal.getInstance(myModal);
                mymodal.hide();

                if(this.responseText == 1){
                    alert('success', 'New feature added');
                    feature_s_form.elements['feature_name'].value = '';
                    get_feature();
                }
                else{
                    alert('error', 'Invalid input!')
                }
            }

            xhr.send(data);
        }

        function get_feature(){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/features_facilities.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                document.getElementById('feature-data').innerHTML = this.responseText;
            }

            xhr.send('get_feature');
        }

        function rem_feature(id){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/features_facilities.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == '1'){
                    alert('success', 'Delete successfully');
                    get_feature();
                }
                else alert('error', 'Fail to delete');
            }

            xhr.send('rem_feature='+id);
        }

        // facility

        facility_s_form.addEventListener('submit', function(e){
            e.preventDefault();
            add_facility();
        });

        function add_facility(){
            let data = new FormData();
            data.append('name',facility_s_form.elements['facility-name'].value);
            data.append('icon',facility_s_form.elements['facility-icon'].files[0]);
            data.append('desc', facility_s_form.elements['facility-desc'].value);
            data.append('add_facility','');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/features_facilities.php', true);

            xhr.onload = function(){
                var myModal = document.getElementById("facility-s");
                var mymodal = bootstrap.Modal.getInstance(myModal);
                mymodal.hide();

                if(this.responseText == 1){
                    alert('success', 'Add successfully');
                    get_facility();
                }
                else if(this.responseText == 'inv_img')alert('', 'Only JPG and PNG images are allowed!');
                else if(this.responseText == 'inv_size')alert('', 'Image should be less than 2MB');
                else alert('Image upload failed!');

                facility_s_form.reset();
            }

            xhr.send(data);
        }

        function get_facility(){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/features_facilities.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                document.getElementById('facility-data').innerHTML = this.responseText;
            }

            xhr.send('get_facility');
        }

        function rem_facility(id){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", './ajax/features_facilities.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function(){
                if(this.responseText == 1){
                    alert('success', 'Delete successfully');
                    get_facility();
                }
                else alert('error', 'Fail to delete');
            }

            xhr.send('rem_facility='+id);
        }

        window.onload = function(){
            get_feature();
            get_facility();
        }
    </script>

    <?php include('inc/scripts.php') ?>
</body>
</html>