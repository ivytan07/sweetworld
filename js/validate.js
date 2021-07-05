 function validateRegForm() {
    var email = document.forms["registerForm"]["idemail"].value;
    var pass = document.forms["registerForm"]["idpassword"].value;
    if ((email === "") || (pass === "")) {
        alert("Please fill out your username/password");
        return false;
    }
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(String(email))) {
        alert("Please correct your email");
        return false;
    }
}

function validateLoginForm() {
    var email = document.forms["loginForm"]["idemail"].value;
    var pass = document.forms["loginForm"]["idpassword"].value;
    if ((email === "") || (pass === "")) {
        alert("Please fill out your username/password");
        return false;
    }
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(String(email))) {
        alert("Please correct your email");
        return false;
    }
    setCookies(10);
}

function previewFile() {
    const preview = document.querySelector('.imgselection');
    const file = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();
    reader.addEventListener("load", function () {
        // convert image file to base64 string
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

function setCookies(email, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = "email=" + email + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function loadCookies() {
    var email = getCookie("email");
    if (email == null || email == "") {
        email = prompt("Please enter your email", "");
        setCookies(email, 30);
        alert('Email stored');
    } else {
        return;
    }
}
function cookieproduct(){
    email = prompt("Please enter your email", "");
    setCookies(email, 30);
    alert('Email stored');
}

function addtoCart() {
    var r = confirm("Do you want to add this product into your cart?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function deleteCart() {
    var r = confirm("Do you want to delete this product from your cart?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function deleteProducts() {
    var r = confirm("Do you want to delete this product?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}

function updateProducts() {
    var r = confirm("Do you want to update this product?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}


