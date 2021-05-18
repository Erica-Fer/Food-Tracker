function test(){
    console.log("got here!!!!!!");
}

// Submit the request given in loginPage.html
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
    }

    callDatabase(pageInfo, formInfo);
}

function callDatabase(page, data) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(JSON.parse(this.responseText));
            // callback(JSON.parse(this.responseText)); // ?
        }
    };
    xhttp.open("POST", page, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data); // ? TODO: need dates to be variables
}

function login(){

}

function register(){

}