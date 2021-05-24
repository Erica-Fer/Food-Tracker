// Submit the request given in loginPage.html
window.onload = function(){
    checkLoggedIn(redirectToApp);
}

function submitReq(login){
    var pageInfo = "";
    var formInfo = "";
    var email = document.getElementById("email").value;
    
    if(login){
        var password = document.getElementById("password").value;
        pageInfo = "../admin/login.php";
        // format:
        // "date1=2021-04-01&date2=2021-04-21"
        formInfo = "email=" + email + "&password=" + password;
    }else{
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;
        pageInfo = "../admin/register.php";
        formInfo = "email=" + email + "&password1=" + password1 + "&password2=" + password2;
    }

    callDatabase(pageInfo, formInfo, errorParse);
}

function checkLoggedIn(callback){
    console.log("got here");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callback(this.response);
       }
    };
    xhttp.open("GET", "../admin/sessionValidate.php", true);
    xhttp.send();
}

function redirectToApp(response){
    if(response != -1){
        window.location.href = "../presentation/main.html";
    }
}

// Use POST to pass user info the PHP file to parse and return errors
function callDatabase(page, data, callback) {
    var result;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText)
            callback(JSON.parse(this.responseText)); // ?
        }
    };
    xhttp.open("POST", page, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data); // ? TODO: need dates to be variables
}

// Handle what should display based on errors found in submit
function errorParse(errors){
    // If no errors, go ahead and go to the main calendar
    if(errors.length == 0){
        window.location.href = "../presentation/main.html";
        return;
    }

    // If there are errors, format data to be shown on the current page
    var err = "";
    for(var i = 0; i < errors.length; i++){
        err += errors[i] + '<br>';
    }

    document.getElementById("errors").innerHTML = err;
}
