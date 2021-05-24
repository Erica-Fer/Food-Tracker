window.onload = function(){
    checkLoggedIn(redirectToApp);
}

function checkLoggedIn(callback){
    console.log("got here");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callback(this.response);
       }
    };
    xhttp.open("GET", "admin/sessionValidate.php", true);
    xhttp.send();
}

function redirectToApp(response){
    if(response != -1){
        window.location.href = "presentation/main.html";
    }
}