window.addEventListener('load',
    function () {
        // Use callback methods to pass data from PHP to be processed
        // Allows for async processing of information
        callDatabase(combineData);
    }, false);

function returnResult(result){
    return result;
}

// Return the database information between the given date numbers
// ? TODO: include a call to validate user request in admin
function callDatabase(callback) {
    out("entered");
    var myObj;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            myObj = this.responseText;
            // out(myObj);
            callback(myObj);
        }
    };
    xhttp.open("POST", "../php/summaryData.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("date1=2021-04-01&date2=2021-04-21"); // ? TODO: need dates to be variables
}

// ? do we need this
// Get all data into one easy to sort array
// Keeps the sortData() function more specific
function combineData(data) { 
    out(data);
    
}

// Sort the data gotten from the database
// Should be called before formatting data
// Makes it easier to know which was most common bad-day food
function sortData() { }

// Format the data based on most common
// Should list out top 3
function formatData() { }


/* DEBUG ONLY FUNCTIONS */
// Easier output messages
// Lets you see the function which called the given message
function out(msg) {
    console.log(arguments.callee.caller.name + "() msg: " + msg);
}