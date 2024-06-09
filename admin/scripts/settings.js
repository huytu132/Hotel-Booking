let general_data, contacts_data;

let site_title = document.getElementById("site_title");
let site_about = document.getElementById("site_about");

let site_title_inp = document.getElementById("site_title_inp");
let site_about_inp = document.getElementById("site_about_inp");
let shutdown_toggle = document.getElementById("shutdown-toggle");

let address = document.getElementById("address");
let gmap = document.getElementById("gmap");
let pn1 = document.getElementById("pn1");
let pn2 = document.getElementById("pn2");
let email = document.getElementById("email");
let twitter = document.getElementById("x");
let insta = document.getElementById("ins");
let fb = document.getElementById("fb");
let iframe = document.getElementById("iframe");

let address_inp = document.getElementById("address-inp");
let gmap_inp = document.getElementById("gmap-inp");
let pn1_inp = document.getElementById("pn1-inp");
let pn2_inp = document.getElementById("pn2-inp");
let email_inp = document.getElementById("email-inp");
let twitter_inp = document.getElementById("x-inp");
let insta_inp = document.getElementById("ins-inp");
let fb_inp = document.getElementById("fb-inp");
let iframe_inp = document.getElementById("iframe-inp");

let team_s_form = document.getElementById("team-s-form");
let member_name_inp = document.getElementById("member-name-inp");
let member_picture_inp = document.getElementById("member-picture-inp");

function get_general(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        general_data = JSON.parse(this.responseText);
        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;

        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;

        if(general_data.shutdown == 0){
            shutdown_toggle.checked = false;
            shutdown_toggle.value = 0;
        }
        else{
            shutdown_toggle.checked = true;
            shutdown_toggle.value = 1;
        }
    }

    xhr.send('get_general');
}

function upd_general(site_title_val, site_about_val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let myModal = document.getElementById('general-1');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == '1'){
            alert('success', 'Change saved!');
            get_general();
        }
        else{
            alert('', 'No change saved!')
        }
    }

    xhr.send('site_title='+site_title_val+'&site_about='+site_about_val+'&upd_general');
}

function get_contacts(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        contacts_data = JSON.parse(this.responseText);

        address.innerText = contacts_data.address;
        gmap.innerText = contacts_data.gmap;
        pn1.innerText = contacts_data.pn1;
        pn2.innerText = contacts_data.pn2;                
        email.innerText = contacts_data.email;
        twitter.innerHTML = contacts_data.x;
        insta.innerText = contacts_data.ins;
        fb.innerText = contacts_data.fb;              
        iframe.src = contacts_data.iframe;

        address_inp.value = contacts_data.address;
        gmap_inp.value = contacts_data.gmap;
        pn1_inp.value = contacts_data.pn1;
        pn2_inp.value = contacts_data.pn2;                
        email_inp.value = contacts_data.email;
        twitter_inp.value = contacts_data.x;
        insta_inp.value = contacts_data.ins;
        fb_inp.value = contacts_data.fb;              
        iframe_inp.value = contacts_data.iframe;
    }

    xhr.send('get_contacts');
}

function upd_contacts(address_inp_val, gmap_inp_val, pn1_inp_val, pn2_inp_val, email_inp_val, twitter_inp_val, insta_inp_val, fb_inp_val, iframe_inp_val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let myModal = document.getElementById('contact-1');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == '1'){
            alert('success', 'Change saved!');
            get_contacts();
        }
        else{
            alert('', 'No change saved!')
        }
    }

    xhr.send('address='+address_inp_val+'&gmap='+gmap_inp_val+'&pn1='+pn1_inp_val+'&pn2='+pn2_inp_val+'&email='+email_inp_val+'&x='+twitter_inp_val+'&ins='+insta_inp_val+'&fb='+fb_inp_val+'&iframe='+iframe_inp_val+'&upd_contacts');
}

function upd_shutdown(shutdown_value){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.responseText == 1){
            alert('success', 'Server turn on');
        }
        else alert('success', 'Server turn off');
        get_general();
    }

    xhr.send('shutdown_value='+shutdown_value+'&upd_shutdown');
}

team_s_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_member();
});

function add_member(){
    let data = new FormData();
    data.append('name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);

    xhr.onload = function(){
        let myModal = document.getElementById('team-1');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 1){
            alert('success', 'Add successfully');
            get_members();
        }
        else if(this.responseText == 'inv_img')alert('', 'Only JPG and PNG images are allowed!');
        else if(this.responseText == 'inv_size')alert('', 'Image should be less than 2MB');
        else alert('Image upload failed!');

        member_name_inp.value = '';
        member_picture_inp.value = '';
    }

    xhr.send(data);
}

function get_members(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById("team-data").innerHTML = this.responseText;
    }

    xhr.send('get_members');
}

window.onload = function(){
    get_general();
    get_contacts();
    get_members();
}