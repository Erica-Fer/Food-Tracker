/* Javascript */

// get the php values as defined the beginning of the file
// lets us set food already in the database as chips data
window.onload = function () {
    document.getElementById("submit").onclick = saveMood;
    fixDate();
};

function fixDate(){

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
        ["11","November"],
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


document.addEventListener('DOMContentLoaded', function () {
    /* CODE FOR DAY QUALITY */
    var elemsSelect = document.querySelectorAll('select');
    M.FormSelect.init(elemsSelect, {
    });
    
    
    /* CODE FOR CHIPS(tags) */
    // array of all chips forms
    // add as needed, just use '.chips<name>' for the querySelector
    // ONLY USE FOR CHIP ELEMENTS
    var elemChips = [document.querySelectorAll('.chipsbreakfast')
    , document.querySelectorAll('.chipslunch')
    , document.querySelectorAll('.chipsdinner')];
    
    // set values for each element
    // should let each user form keep unique elements, and elements featured in other forms
    for (i = 0; i < elemChips.length; i++) {
        // var prevFood = [];
        getFood(i, elemChips[i]);
    }
});

function initializeChips(elemChips, food){
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
            alert("here");
            var formId = event[0].id; // the form that was being added to; like lunch/dinner/breakfast/etc.
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
        onChipDelete: (event) =>{
            alert("i here bitch");
            var formId = event[0].id; // the form that was being added to; like lunch/dinner/breakfast/etc.
            var formData = '.chips' + formId;
            var chipsData = M.Chips.getInstance($(formData)).chipsData;

            console.log("formId: " + formId + "formData: " + formData + "chipsData: " + chipsData);
        }
    });
}

// Returns the current date that is in the URL
function getDate() {
    let params = new URLSearchParams(location.search);
    var dateVal = params.get('date');
    return dateVal;
}

function getFood(formNum, elemChips) {
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
    }

    callDatabase(parseFood, key, elemChips);
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
    // result = <? php echo json_encode($breakfastFood, JSON_HEX_TAG) ?>; // ?
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
    updatePrevFood(JSON.parse(res), elemChips);
}

function updatePrevFood(food, elemChips){
    // console.log(elemChips);
    // console.log(elemChips.data);

    // elemChips.data = [{tag: 'apple'}];
    // console.log(elemChips.data);

    initializeChips(elemChips, food);

    // var elem = M.Chips.getInstance(elemChips);
    // console.log(elem.chipsData);
}

function saveMood() {
    var mood = document.getElementById("askDay").value;
    var date = "&date=" + getDate();

    // make call to PHP file to handle giving tags info to be put in database
    // should let the user add information without ever pressing a "save" button
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("demo").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "../database/postmoods.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("dayQuality" + "=" + mood + date);
}
