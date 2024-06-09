<?php
    define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/tuts/Hotel/');
    define('ABOUT_FOLDER', 'images/about/');
    define('FACILITY_FOLDER','images/facilities/');
    define('ROOMS_FOLDER','images/rooms/');
    define('USERS_FOLDER','images/users/');

    function adminLogin(){
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
            echo "<script>
                window.location.href='index.php';
            </script>";
            exit;
        }       
    }

    function redirect($url){
        echo "<script>
            window.location.href='$url';
        </script>";
        exit();
    }

    function alert($type, $msg){
        $bs_class = (($type == 'success') ? "alert-success" : "alert-danger");
        echo "<div class='alert $bs_class alert-dismissible fade show mt-2 me-2' role='alert' style='position: fixed; top: 80px; right: 25px;'>
                <strong>$msg</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }

    function uploadImage($image, $folder){
        $value_mime = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $value_mime)){
            return 'inv_img';
        }else if(($image['size'])/(1024*1024) > 2){
            return 'inv_size';
        }
        else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111,99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else{
                return 'upd_fail';
            }
        }
    }

    function uploadSVGImage($image, $folder){
        $value_mime = ['image/svg+xml'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $value_mime)){
            return 'inv_img';
        }else if(($image['size'])/(1024*1024) > 1){
            return 'inv_size';
        }
        else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111,99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else{
                return 'upd_fail';
            }
        }
    }

    function uploadUserImage($image){
        $value_mime = ['image/jpeg', 'image/png', 'image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $value_mime)){
            return 'inv_img';
        }
        else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111,99999).".jpeg";
            $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

            if($ext == 'png' || $ext == 'PNG'){
                $img = imagecreatefrompng($image['tmp_name']);
            }
            else if($ext == 'webp' || $ext == 'WEBP'){
                $img = imagecreatefromwebp($image['tmp_name']);
            }
            else{
                $img = imagecreatefromjpeg($image['tmp_name']);
            }

            if(imagejpeg($img, $img_path, 75)){
                return $rname;
            }
            else{
                return 'upd_fail';
            }
        }
    }

    function formatCurrency($number) {
        // Định dạng số với dấu phẩy cho hàng nghìn và thêm ' VND' vào cuối
        return number_format($number, 0, ',', '.') . ' VND';
    }
?>
