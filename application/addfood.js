/* Javascript */

window.onload = function () {
    checkLoggedIn(redirectToMain);
    fixDate();
};

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

function redirectToMain(response){
    if(response == -1){
        window.location.href = "../index.html";
    }
}

// Handles materialize elements
document.addEventListener('DOMContentLoaded', function () {
    mood();
    chips();
    symptomChips();
    suppleChips();
    exerciseChips();
});

/* CODE FOR DAY QUALITY */
function mood() {
    var elemsSelect = document.querySelectorAll('select');
    M.FormSelect.init(elemsSelect, {});
    document.getElementById("submit").onclick = saveMood;
}

/* CODE FOR CHIPS(tags) */
function chips() {
    // array of all chips forms
    // add as needed, just use '.chips<name>' for the querySelector
    // ONLY USE FOR CHIP ELEMENTS
    var elemChips = [document.querySelectorAll('.chipsbreakfast')
        , document.querySelectorAll('.chipslunch')
        , document.querySelectorAll('.chipsdinner')
        , document.querySelectorAll('.chipssnacks')];

    // set values for each element
    // should let each user form keep unique elements, and elements featured in other forms
    for (i = 0; i < elemChips.length; i++) {
        getFood(i, elemChips[i]);
    }
}

// CODE FOR chips(tags) specifically for the symptom section
function symptomChips(){
    var elemChips = [document.querySelectorAll('.chipssymptoms')];

    for (i = 0; i < elemChips.length; i++) {
        getSymptoms(i, elemChips[i]);
    }

}

// CODE FOR chips(tags) specifically for the supplement section
function suppleChips(){
    var elemChips = [document.querySelectorAll('.chipssupplements')];

    for (i = 0; i < elemChips.length; i++) {
        getSupple(i, elemChips[i]);
    }

}

// CODE FOR chips(tags) specifically for the exercise section
function exerciseChips(){
    var elemChips = [document.querySelectorAll('.chipsexercise')];

    for (i = 0; i < elemChips.length; i++) {
        getExercise(i, elemChips[i]);
    }
}

function getFood(formNum, elemChips) {
    // Start by initializing the blank chips before finding food
    initializeChips(elemChips, []);

    // Default to a null value so that if there is nothing, return is not empty
    var key = '';

    switch (formNum) {
        case 0: // Breakfast
            key = 'breakfast';
            break;
        case 1: // Lunch
            key = 'lunch';
            break;
        case 2: // Dinner
            key = 'dinner';
            break;
        case 3: //Snack
            console.log("in ssnacks");
            key = 'snacks';
            break;
    }

    callDatabase(parseFood, key, elemChips);
}

function getSymptoms(formNum, elemChips) {
    // Start by initializing the blank chips before finding symptoms
    initializeLifeChips(elemChips, []);

    // sets key we're looking for
    var key = 'symptoms';

    callDatabase(parseSymptoms, key, elemChips);
}

function getSupple(formNum, elemChips) {
    // Start by initializing the blank chips before finding supplements
    initializeSupplementChips(elemChips, []);

    // sets key we're looking for
    var key = 'supplements';

    callDatabase(parseSupplements, key, elemChips);
}

function getExercise(formNum, elemChips) {
    // Start by initializing the blank chips before finding exercise
    initializeExerciseChips(elemChips, []);

    // sets key we're looking for
    var key = 'supplements';

    callDatabase(parseExercise, key, elemChips);
}

function callDatabase(callback, key, elemChips) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            callback(JSON.parse(this.responseText), elemChips);
        }
    };
    xhttp.open("POST", "../database/formatfood.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("date=" + getDate() + "&key=" + key); // ? TODO: some way to reuse this
}

function parseFood(foodType, elemChips) {
    // Begin the string to be used for parsing input
    var food = '';

    if (foodType == null || foodType.length < 1) {
        return 0;
    }

    // This is what allows for each input food to have individual chip
    // The format of string should be the following:
    //'[' + '{ "tag": "' + foodTest[0] + '" }' + ',' + '{ "tag": "' + foodTest[2] + '" }' + ']';
    for (var i = 0; i < foodType.length; i++) {
        food += '{ "tag": "' + foodType[i] + '" }';
        if (i < foodType.length - 1) {
            food += ',';
        }
    }

    var res = "[" + food + "]";
    initializeChips(elemChips, JSON.parse(res));
}

function parseSymptoms(lifeStat, elemChips) {
    // Begin the string to be used for parsing input
    var input = '';

    if (lifeStat == null || lifeStat.length < 1) {
        return 0;
    }

    // This is what allows for each input food to have individual chip
    // The format of string should be the following:
    //'[' + '{ "tag": "' + foodTest[0] + '" }' + ',' + '{ "tag": "' + foodTest[2] + '" }' + ']';
    for (var i = 0; i < lifeStat.length; i++) {
        input += '{ "tag": "' + lifeStat[i] + '" }';
        if (i < lifeStat.length - 1) {
            input += ',';
        }
    }

    var res = "[" + input + "]";
    initializeLifeChips(elemChips, JSON.parse(res));
}

function parseSupplements(lifeStat, elemChips) {
    // Begin the string to be used for parsing input
    var input = '';

    if (lifeStat == null || lifeStat.length < 1) {
        return 0;
    }

    // This is what allows for each input food to have individual chip
    // The format of string should be the following:
    //'[' + '{ "tag": "' + foodTest[0] + '" }' + ',' + '{ "tag": "' + foodTest[2] + '" }' + ']';
    for (var i = 0; i < lifeStat.length; i++) {
        input += '{ "tag": "' + lifeStat[i] + '" }';
        if (i < lifeStat.length - 1) {
            input += ',';
        }
    }

    var res = "[" + input + "]";
    initializeSupplementChips(elemChips, JSON.parse(res));
}

function parseExercise(lifeStat, elemChips) {
    // Begin the string to be used for parsing input
    var input = '';

    if (lifeStat == null || lifeStat.length < 1) {
        return 0;
    }

    // This is what allows for each input food to have individual chip
    // The format of string should be the following:
    //'[' + '{ "tag": "' + foodTest[0] + '" }' + ',' + '{ "tag": "' + foodTest[2] + '" }' + ']';
    for (var i = 0; i < lifeStat.length; i++) {
        input += '{ "tag": "' + lifeStat[i] + '" }';
        if (i < lifeStat.length - 1) {
            input += ',';
        }
    }

    var res = "[" + input + "]";
    initializeExerciseChips(elemChips, JSON.parse(res));
}

// Initializes the chips and their relevant data
function initializeChips(elemChips, food) {
    var prevFood = food;
    var instances = M.Chips.init(elemChips, {
        autocompleteOptions: {
            data: {
                'Apple': null,
                'Rice': null,
                'Custard': null,
                'Chocolate': null
            },
            limit: Infinity,
            minLength: 1
        },
        placeholder: 'Enter a tag',
        secondaryPlaceholder: 'Enter a tag',
        data: prevFood,
        onChipAdd: (event) => {
            var formId = event[0].id; // the form that was being added to; like lunch/dinner/breakfast/etc.
            console.log(formId);
            var formData = '.chips' + formId;

            var chipsData = M.Chips.getInstance($(formData)).chipsData;

            var newestTag = chipsData[chipsData.length - 1].tag;

            // Get the date from the given url
            var date = "&date=" + getDate();

            // make call to PHP file to handle giving tags info to be put in database
            // should let the user add information without ever pressing a "save" button
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                }
            };
            xhttp.open("POST", "../database/post.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
            xhttp.send(formId + "=" + newestTag + date); // should send something in the form of "breakfast=cheese", or other input
        },
        onChipDelete: (event, chip) => {
            // The form that was being added to; like lunch/dinner/breakfast/etc.
            var formId = event[0].id; 
            var form = "formId=" + formId;

            // Get the data for the chip being deleted
            var toDelete = "&remove=" + chip["firstChild"]["wholeText"];

            // Set the date toe be used in the database update
            var date = "&date=" + getDate();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            xhttp.open("POST", "../database/removefood.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // MESSAGE FORMAT:
            // formId=<$breakfast/$lunch/$dinner/$symptoms>&remove=<$text>&date=<$yyyy-mm-dd>
            xhttp.send(form + toDelete + date);
        }
    });
}

// Initializes the symptom chips and their relevant data
function initializeLifeChips(elemChips, input) {
    console.log("in intiailize");
    var prevInput = input;
    var instances = M.Chips.init(elemChips, {
        autocompleteOptions: {
            data: {
                'nausea': null,
                'cramps': null,
                'diarrhea': null,
                'constipation': null
            },
            limit: Infinity,
            minLength: 1
        },
        placeholder: 'Enter a tag',
        secondaryPlaceholder: 'Enter a tag',
        data: prevInput,
        onChipAdd: (event) => {
            var formId = event[0].id; // the form that was being added to; like lunch/dinner/breakfast/etc.
            console.log("formId" + formId);
            var formData = '.chips' + formId;

            var chipsData = M.Chips.getInstance($(formData)).chipsData;

            var newestTag = chipsData[chipsData.length - 1].tag;

            // Get the date from the given url
            var date = "&date=" + getDate();

            // make call to PHP file to handle giving tags info to be put in database
            // should let the user add information without ever pressing a "save" button
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                }
            };
            xhttp.open("POST", "../database/post.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
            xhttp.send(formId + "=" + newestTag + date); // should send something in the form of "breakfast=cheese", or other input
        },
        onChipDelete: (event, chip) => {
            // The form that was being added to; like lunch/dinner/breakfast/etc.
            var formId = event[0].id; 
            var form = "formId=" + formId;

            // Get the data for the chip being deleted
            var toDelete = "&remove=" + chip["firstChild"]["wholeText"];

            // Set the date toe be used in the database update
            var date = "&date=" + getDate();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            xhttp.open("POST", "../database/removefood.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // MESSAGE FORMAT:
            // formId=<$breakfast/$lunch/$dinner/$symptoms>&remove=<$text>&date=<$yyyy-mm-dd>
            xhttp.send(form + toDelete + date);
        }
    });
}

// Initializes the supplement chips and their relevant data
function initializeSupplementChips(elemChips, input) {
    // console.log("in intiailize");
    var prevInput = input;
    var instances = M.Chips.init(elemChips, {
        autocompleteOptions: {
            data: {
                'fiber': null,
                'probiotic': null,
                'calcium': null,
                'fish oil': null
            },
            limit: Infinity,
            minLength: 1
        },
        placeholder: 'Enter a tag',
        secondaryPlaceholder: 'Enter a tag',
        data: prevInput,
        onChipAdd: (event) => {
            var formId = event[0].id; // the form that was being added to; like lunch/dinner/breakfast/etc.
            console.log("formId" + formId);
            var formData = '.chips' + formId;

            var chipsData = M.Chips.getInstance($(formData)).chipsData;

            var newestTag = chipsData[chipsData.length - 1].tag;

            // Get the date from the given url
            var date = "&date=" + getDate();

            // make call to PHP file to handle giving tags info to be put in database
            // should let the user add information without ever pressing a "save" button
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                }
            };
            xhttp.open("POST", "../database/post.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
            xhttp.send(formId + "=" + newestTag + date); // should send something in the form of "breakfast=cheese", or other input
        },
        onChipDelete: (event, chip) => {
            // The form that was being added to; like lunch/dinner/breakfast/etc.
            var formId = event[0].id; 
            var form = "formId=" + formId;

            // Get the data for the chip being deleted
            var toDelete = "&remove=" + chip["firstChild"]["wholeText"];

            // Set the date toe be used in the database update
            var date = "&date=" + getDate();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            xhttp.open("POST", "../database/removefood.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // MESSAGE FORMAT:
            // formId=<$breakfast/$lunch/$dinner/$symptoms>&remove=<$text>&date=<$yyyy-mm-dd>
            xhttp.send(form + toDelete + date);
        }
    });
}

// Initializes the exercise chips and their relevant data
function initializeExerciseChips(elemChips, input) {
    // console.log("in intiailize");
    var prevInput = input;
    var instances = M.Chips.init(elemChips, {
        autocompleteOptions: {
            data: {
                'yoga': null,
                'walking': null,
                'running': null,
                'volleyball': null
            },
            limit: Infinity,
            minLength: 1
        },
        placeholder: 'Enter a tag',
        secondaryPlaceholder: 'Enter a tag',
        data: prevInput,
        onChipAdd: (event) => {
            var formId = event[0].id; // the form that was being added to; like lunch/dinner/breakfast/etc.
            console.log("formId" + formId);
            var formData = '.chips' + formId;

            var chipsData = M.Chips.getInstance($(formData)).chipsData;

            var newestTag = chipsData[chipsData.length - 1].tag;

            // Get the date from the given url
            var date = "&date=" + getDate();

            // make call to PHP file to handle giving tags info to be put in database
            // should let the user add information without ever pressing a "save" button
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                }
            };
            xhttp.open("POST", "../database/post.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
            xhttp.send(formId + "=" + newestTag + date); // should send something in the form of "breakfast=cheese", or other input
        },
        onChipDelete: (event, chip) => {
            // The form that was being added to; like lunch/dinner/breakfast/etc.
            var formId = event[0].id; 
            var form = "formId=" + formId;

            // Get the data for the chip being deleted
            var toDelete = "&remove=" + chip["firstChild"]["wholeText"];

            // Set the date toe be used in the database update
            var date = "&date=" + getDate();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            xhttp.open("POST", "../database/removefood.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // MESSAGE FORMAT:
            // formId=<$breakfast/$lunch/$dinner/$symptoms>&remove=<$text>&date=<$yyyy-mm-dd>
            xhttp.send(form + toDelete + date);
        }
    });
}

function saveMood() {
    var mood = document.getElementById("askDay").value;
    var date = "&date=" + getDate();

    // make call to PHP file to handle giving tags info to be put in database
    // should let the user add information without ever pressing a "save" button
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        }
    };
    xhttp.open("POST", "../database/postmoods.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("dayQuality" + "=" + mood + date);
}

// Returns the current date that is in the URL
function getDate() {
    let params = new URLSearchParams(location.search);
    var dateVal = params.get('date');
    return dateVal;
}

function fixDate() {

    let months = new Map([
        ["01", "January"],
        ["02", "February"],
        ["03", "March"],
        ["04", "April"],
        ["05", "May"],
        ["06", "June"],
        ["07", "July"],
        ["08", "August"],
        ["09", "September"],
        ["10", "October"],
        ["11", "November"],
        ["12", "December"]
    ]);
    let params = new URLSearchParams(location.search);
    var current_date = params.get('date'); //<?php echo json_encode($date, JSON_HEX_TAG) ?>;
    var year = current_date.substring(0, 4);
    var month = current_date.substring(5, 7);
    var day = current_date.substring(8, 10);
    var result = months.get(month) + " " + day + ", " + year;

    var update = document.getElementById("title");
    update.innerHTML += result;
}
