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
    
    <?php 
        include('./inc/header.php'); 

        $checkin_default = "";
        $chekckout_default = "";
        $adult_default = "";
        $children_default = "";
        
        if(isset($_GET['check_availability'])){
            $search_input = filteration($_GET);

            $checkin_default = $search_input['checkin'];
            $chekckout_default = $search_input['checkout'];
            $adult_default = $search_input['adult'];
            $children_default = $search_input['children'];
        }
    ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Phòng</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3 col-md-6 mx-auto">
            Khách sạn chúng tôi cung cấp những căn hộ với chất lượng tốt nhất!!
        </p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow rounded">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">LỌC</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch" id="navbarNav">
                            <div class="border bg-light rounded p-3 mb-3">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size: 18px;">
                                    <span>CHỌN THỜI GIAN</span>
                                    <button id="reset-time-button" type="button" class="btn btn-sm border-none shadow-none d-none">clear</button>
                                </h5>
                                <label class="form-label" style="font-weight: 500;">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-2" id="checkin" value="<?php echo $checkin_default ?>" onchange="check_avail_filter()">
                                <label class="form-label" style="font-weight: 500;">Check-out</label>
                                <input type="date" class="form-control shadow-none mb-2" id="checkout" value="<?php echo $chekckout_default ?>" onchange="check_avail_filter()">
                            </div>

                            <div class="border bg-light rounded p-3 mb-3">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size: 18px;">
                                    <span>TIỆN ÍCH</span>
                                    <button id="reset-feature-button" type="button" class="btn btn-sm border-none shadow-none d-none">clear</button>
                                </h5>

                                <?php    
                                    $rows = selectAll('features');
                                    while($opt = mysqli_fetch_assoc($rows)){
                                        echo "
                                            <div class='col-lg-12 mb-2'>
                                                <label>
                                                    <input type='checkbox' onclick='fet_rooms()' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                    $opt[name]
                                                </label>
                                            </div>
                                        ";
                                    }
                                ?>
                            </div>

                            <div class="border bg-light rounded p-3 mb-3">
                                <h5 class="mb-3 d-flex align-items-center justify-content-between" style="font-size: 18px;">
                                    <span>LƯỢNG KHÁCH</span>
                                    <button id="reset-guest-button" type="button" class="btn btn-sm border-none shadow-none d-none">clear</button>
                                </h5>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="form-label">Người lớn</label>
                                        <input type="number" min="1" id="adults" value="<?php echo $adult_default ?>" class="form-control shadow-none" oninput="check_guest()">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Trẻ em</label>
                                        <input type="number" min="1" id="children" value="<?php echo $children_default ?>" class="form-control shadow-none" oninput="check_guest()">
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12 px-4">      
                <div id="room-data">
                
                </div>
                <div id="page">
                    
                </div>
            </div>

            
        </div>
    </div>

    <?php include('inc/footer.php'); ?>

    <script>
        let room_data = document.getElementById('room-data');
        let checkin = document.getElementById('checkin');
        let checkout = document.getElementById('checkout');
        let reset_time_button = document.getElementById('reset-time-button');
        let adults = document.getElementById('adults');
        let children = document.getElementById('children');
        let reset_guest_button = document.getElementById('reset-guest-button');
        let reset_feature_button = document.getElementById('reset-feature-button');

        if(checkin.value != '' && checkout.value != ''){
            reset_time_button.classList.remove('d-none');
        }
        if(adults.value != '' && children != ''){
            reset_guest_button.classList.remove('d-none');
        }

        function fet_rooms(page = 1){
            let data = new FormData();
            let check_input = JSON.stringify({
                checkin : checkin.value,
                checkout : checkout.value
            });

            let features_list = {"features":[]};
            let features = document.querySelectorAll('[name="features"]:checked');
            if(features.length > 0){
                features.forEach((feature) => {
                    features_list.features.push(feature.value);
                });
                reset_feature_button.classList.remove('d-none');
            }
            else{
                reset_feature_button.classList.add('d-none');
            }
            data.append('features_list', JSON.stringify(features_list));

            let people = JSON.stringify({
                adults : adults.value,
                children : children.value
            });
            data.append('time_input', check_input);
            data.append('people', people);
            data.append('fet_rooms', '');

            pre_disable = '';
            if(page == 1)pre_disable = 'disabled';
            next_disable = '';
            

            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'ajax/rooms_crud.php?fet_rooms&time_input='+check_input+'&people='+people+'&features_list='+JSON.stringify(features_list)+'&page='+page, true);

            xhr.onprogress = function(){
                room_data.innerHTML = `
                <div class='spinner-border text-info mx-auto d-block' role='status'>
                    <span class='visually-hidden'>Loading...</span>
                </div>`;
            }

            xhr.onload = function(){
                room_data.innerHTML = this.responseText;
                let page_data = document.getElementById('page');
                page_data.innerHTML = `
                    <nav aria-label='Page navigation example'>
                        <ul class='pagination justify-content-center'>
                            <li class='page-item'>
                                <button onclick='previous_pages(${page})' ${pre_disable} class='page-link shadow-none' aria-label='Previous'>
                                    <span aria-hidden='true'>&laquo;</span>
                                </button>
                            </li>
                            <li class='page-item'>
                                <button onclick='next_pages(${page})' class='page-link shadow-none' aria-label='Next'>
                                    <span aria-hidden='true'>&raquo;</span>
                                </button>
                            </li>
                        </ul>
                    </nav>
                `;
            }

            xhr.send();
        }

        function previous_pages(page){
            fet_rooms(page-1);
        }

        function next_pages(page){
            fet_rooms(page+1);
        }

        function check_avail_filter(){
            if(checkin.value != '' && checkout.value != ''){
                fet_rooms();
            }
            reset_time_button.classList.remove('d-none');
        }

        reset_time_button.addEventListener('click', function(e){
            e.preventDefault();
            checkin.value = '';
            checkout.value = '';
            reset_time_button.classList.add('d-none');
            fet_rooms();
        });

        reset_guest_button.addEventListener('click', function(e){
            e.preventDefault();
            adults.value = '';
            children.value = '';
            reset_guest_button.classList.add('d-none');
            fet_rooms();
        });

        reset_feature_button.addEventListener('click', function(e){
            e.preventDefault();
            document.querySelectorAll('[name="features"]').forEach((feature) => {
                feature.checked = false;
            })
            fet_rooms();
        });

        function check_guest(){
            fet_rooms();
            reset_guest_button.classList.remove('d-none');
        }

        window.onload = function(){
            fet_rooms();
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script type="text/javascript" src="./js/home.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>