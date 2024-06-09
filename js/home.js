var swiper = new Swiper(".firstSlider", {
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false
    }
}); 

var swiper = new Swiper(".testimonial", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "3",
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    pagination: {
      el: ".swiper-pagination",
    },
});

let register_form = document.getElementById('register-form');

register_form.addEventListener('submit', function(e){
    e.preventDefault();
    addNewUser();  
});

function addNewUser(){
    let data = new FormData();
    data.append('name', register_form.elements['name'].value);
    data.append('email', register_form.elements['email'].value);
    data.append('phone', register_form.elements['phone'].value);
    data.append('profile', register_form.elements['profile'].files[0]);
    data.append('address', register_form.elements['address'].value);
    data.append('pincode', register_form.elements['pincode'].value);
    data.append('dob', register_form.elements['dob'].value);
    data.append('pass', register_form.elements['pass'].value);
    data.append('cpass', register_form.elements['cpass'].value);
    data.append('register','');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', './ajax/login_register_crud.php', true);

    xhr.onload = function(){
        if(this.responseText == 'pass_missmatch')showToast('warning', 'Mật khẩu xác nhận không trùng khớp!');
        else if(this.responseText == 'email_already')showToast('error', 'Email đã được sử dụng!');
        else if(this.responseText == 'phone_already')showToast('error', 'Số điện thoại đã được sử dụng!');
        else if(this.responseText == 'inv_img')showToast('warning', 'Sai định dạng ảnh!');
        else if(this.responseText == 'upd_fail')showToast('error', 'Có lỗi xảy ra');
        else if(this.responseText == 'mail_failed')showToast('warning', 'Gửi email thất bại!');
        else if(this.responseText == 'ins_failed')showToast('error', 'Có lỗi xảy ra!');
        else{
            let myModal = document.getElementById('registerModal');
            let modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            showToast('success', 'Đăng ký thành công, vào email để xác thực tài khoản!');
            register_form.reset();
        }
        
    }
    xhr.send(data);
}

let login_form = document.getElementById('login-form');

login_form.addEventListener('submit', function(e){
    e.preventDefault();
    send_login();
});

function send_login(){
    let data = new FormData();
    data.append('email_phone', login_form.elements['email-phone'].value);
    data.append('pass', login_form.elements['password'].value);
    data.append('login','');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', './ajax/login_register_crud.php', true);

    xhr.onload = function(){
        if(this.responseText == 'not_verified')showToast('warning', 'Tài khoản chưa được xác thực qua email!');
        else if(this.responseText == 'inactive')showToast('error','Tài khoản của bạn đã bị khóa, vui lòng liên hệ qua SĐT hoặc email!');
        else if(this.responseText == 'inv_user')showToast('error', 'Tài khoản hoặc mật khẩu không đúng!');
        else if(this.responseText == 1){
            window.location.href=window.location;
            login_form.reset();
        }
    }
    xhr.send(data);
}

let forgot_form = document.getElementById('forgot-form');

forgot_form.addEventListener('submit', function(e){
    e.preventDefault();
    forgotPassword();
});

function forgotPassword(){
    let data = new FormData();
    data.append('email', forgot_form.elements['email'].value);
    data.append('forgotPass','');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', './ajax/login_register_crud.php', true);

    xhr.onload = function(){
        if(this.responseText == 'not_verified')showToast('warning', 'Tài khoản chưa được xác thực qua email!');
        else if(this.responseText == 'inactive')showToast('error','Tài khoản của bạn đã bị khóa, vui lòng liên hệ qua SĐT hoặc email!');
        else if(this.responseText == 'inv_user')showToast('error', 'Tài khoản hoặc số điện thoại không đúng!');
        else if(this.responseText == 'mail_failed')showToast('warning', 'Dịch vụ gửi email đang được bảo trì, vui lòng quay lại sau!');
        else if(this.responseText == 'upd_failed')showToast('error', 'Có lỗi xảy ra!');
        else if(this.responseText == 1){
            let myModal = document.getElementById('forgotModal');
            let modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            showToast('success', 'Email đã được gửi tới địa chỉ!');
            forgot_form.reset();
        }  
    }
    xhr.send(data);
}

function checkLoginToBook(status, room_id){
    if(status){
        window.location.href = 'confirm_booking.php?id='+room_id;
    }
    else{
        showToast('warning', 'Bạn phải đăng nhập để thực hiện hành động này!')
    }
}

let toastBox = document.getElementById('toastBox');

function showToast(type, msg){
    let toast = document.createElement('div');
    let text = "";
    toast.classList.add('toastCustom');
    toast.classList.add('shadow');
    toast.classList.add('bg-light');
    if(type == 'success'){
        toast.classList.add('green');
        text = 'text-success';
        toast.innerHTML = "<i class='bi bi-check-circle-fill icon " + text + "'></i> " + msg;
    }
    else if(type == 'error'){
        toast.classList.add('red');
        text = 'text-danger';
        toast.innerHTML = "<i class='bi  bi-x-circle-fill icon " + text + "'></i> " + msg;
    }
    else{
        toast.classList.add('yellow');
        text = 'text-warning';
        toast.innerHTML = "<i class='bi bi-exclamation-circle-fill icon " + text + "'></i> " + msg;
    }
    
    
    toastBox.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 5000)
}

let confirmBox = document.getElementById('confirmBox');

function confirmAction(){
    let toast = document.createElement('div');
    toast.innerHTML = "<div id='toastConfirm' class='bg-white shadow' role='alert' aria-live='assertive' aria-atomic='true'> \
                <div class='toast-body'> \
                Bạn chắc chắn muốn hủy đặt phòng? \
                <div class='mt-2 pt-2 border-top d-flex justify-content-between'> \
                    <button type='button' onclick='cancelBooking()' class='btn btn-primary btn-sm shadow-none'>Xác nhận hủy</button> \
                    <button type='button' onclick='closeConfirmBox()' class='btn btn-secondary btn-sm shadow-none'>Đóng</button> \
                </div> \
                </div> \
            </div>";
    confirmBox.appendChild(toast);
}

function closeConfirmBox(){
    let toastConfirm = document.getElementById('toastConfirm');
    toastConfirm.remove();
}

function cancelBooking(){
    let data = new FormData();
    data.append('cancelBooking', '');
    data.append('booking_id', review_form.elements['booking_id'].value);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', './ajax/review_crud.php', true);

    xhr.onload = function(){
        if(this.responseText == 1){
            showToast('success', 'Huỷ thành công!');
            window.location.href = window.location.href;
        }
        else showToast('error', 'Có lỗi xảy ra!');                
    }
    xhr.send(data);
};