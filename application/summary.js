// ? set to be strict when done debugging

window.addEventListener('load',
    function () {
        // Use callback methods to pass data from PHP to be processed
        // Allows for async processing of information
        checkLoggedIn(redirectToMain);
        let params = new URLSearchParams(location.search);
        document.getElementById("dateInfo").innerHTML = stringifyDateOutput(params);

        var date = params.toString()
        callDatabase(date, combineData);
    }, false);

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


function stringifyDateOutput(params) {
    var rangeOfDates = "";
    var parsedDate1 = parseDate(params.get('date1'));
    var parsedDate2 = parseDate(params.get('date2'));

    rangeOfDates = "Food had between "
                    + parsedDate1[0] 
                    + " " 
                    + parsedDate1 [1]
                    + ", "
                    + parsedDate1[2]
                    + " and "
                    + parsedDate2[0] 
                    + " " 
                    + parsedDate2[1]
                    + ", "
                    + parsedDate2[2];

    return rangeOfDates;
}

function parseDate(dateStr) {
    var result = {};
    var parsed = dateStr.split("-", 3);

    switch (parsed[1]) {
        case "01": //january
            result[0] = "January"
            break;
        case "02": //february
            result[0] = "February"
            break;
        case "03": //march
            result[0] = "March"
            break;
        case "04": //april
            result[0] = "April"
            break;
        case "05": //may
            result[0] = "May"
            break;
        case "06": //june
            result[0] = "June"
            break;
        case "07": //july
            result[0] = "July"
            break;
        case "08": //august
            result[0] = "August"
            break;
        case "09": //september
            result[0] = "September"
            break;
        case "10": //october
            result[0] = "October"
            break;
        case "11": //november
            result[0] = "November"
            break;
        case "12": //december
            result[0] = "December"
        default:
            alert("Invalid date!");
            window.location.href = "../presentation/main.html";
    }

    result[1] = parsed[2]; // Day
    result[2] = parsed[0]; // Year
    return result;
}

// Return the database information between the given date numbers
// ? TODO: include a call to validate user request in admin
function callDatabase(date, callback) {
    // out("entered");
    var myObj;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Async callback
            // Will call the function 'combineData' when info is retrieved
            callback(JSON.parse(this.responseText));
        }
    };
    xhttp.open("POST", "../database/summaryData.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(date); // ? TODO: need dates to be variables
}

// Get all data into one easy to sort array
// Keeps the sortData() function more specific
function combineData(data) {
    // out(Object.prototype.toString.call(data))
    let allFoodItems = new Map();
    let foodAtTime = new Map();
    var top3 = [{
        food: "cheese",
        count: 4
    },
    {
        food: "taco",
        count: 2
    },
    {
        food: "lasgancan",
        count: 7
    }];

    out("food = " + top3[2].food + "\ncount = " + top3[2].count);


    for (i = 0; data[i] != null; i++) {
        // out(data[i]["breakfast"]); // ?
        var br = data[i]["breakfast"];
        var ln = data[i]["lunch"];
        var dn = data[i]["dinner"];

        // Add all food to a hashmap and increment how many times its been seen
        // Should be used to define which are worst problem foods
        var value;
        if (br != "") {
            value = allFoodItems.get(br);
            // If NaN, initialize the values
            if (isNaN(value)) {
                allFoodItems.set(br, 1);
                foodAtTime.set("breakfast", br);
            }
            else {
                allFoodItems.set(br, value + 1);
                foodAtTime.set("breakfast", foodAtTime.get("breakfast") + br);
            }

            // out("\n" + allFoodItems.get(br));
            top3 = addSorted(allFoodItems.get(br), top3);
        }

        if (ln != "") {
            value = allFoodItems.get(ln);
            // If NaN, initialize the values
            if (isNaN(value)) {
                allFoodItems.set(ln, 1);
            }
            else {
                allFoodItems.set(ln, value + 1);
            }

            // foodAtTime.set("lunch", ln);
            foodAtTime.set("lunch", foodAtTime.get("lunch") + ln);
            top3 = addSorted(allFoodItems.get(ln), top3);

        }

        if (dn != "") {
            value = allFoodItems.get(dn);
            // If NaN, initialize the values
            if (isNaN(value)) {
                allFoodItems.set(dn, 1);
            }
            else {
                allFoodItems.set(dn, value + 1);
            }

            // out("dn: " + dn)
            if (isNaN(foodAtTime.get("dinner"))) {
                // out("got here in nan")
                var obj = [dn]
                foodAtTime.set("dinner", obj);
            } else {
                var obj = foodAtTime.get("dinner");
                // out ( "obj: " + obj);
                foodAtTime.set("dinner",);
            }
            top3 = addSorted(allFoodItems.get(dn), top3);

        }
    }

    //     for (let i in allFoodItems) {
    //     out("top3 value: " + top3[i])
    // }
    console.log("i'M HERE");
    for (let [key, value] of allFoodItems) {
        out("\t\t" + key + " = " + value)
    }
    formatData(allFoodItems); //changed from top3 to allFoodItems

    // for(let value of foodAtTime["dinner"]){
    //     out("\t\t" + "Dinner = " + value)
    // }
}


function locationOf(element, array, start, end) {
    start = start || 0;
    end = end || array.length;
    var pivot = parseInt(start + (end - start) / 2, 10);
    if (array[pivot] === element) return pivot;
    if (end - start <= 1)
        return array[pivot] > element ? pivot - 1 : pivot;
    if (array[pivot] < element) {
        return locationOf(element, array, pivot, end);
    } else {
        return locationOf(element, array, start, pivot);
    }
}
// https://stackoverflow.com/questions/1344500/efficient-way-to-insert-a-number-into-a-sorted-array-of-numbers/21822316#21822316

// Add top 3 bad day foods in sorted order
// Makes it easier to know which was most common bad-day food
// Just swap values in a while loop of size 3 O(1)
function addSorted(element, array) {
    // for (let i in top) {
    //     out("top3 value: " + top[i])
    // }
    // array.splice(locationOf(element, array) + 1, 0, element);
    // return array;


}


// Format the data based on most common
// Should list out top 3
function formatData(allFood) {
    console.log("NOW IN FORMAT DATA");
    console.log(allFood);
    for (let [key, value] of allFood) {
        console.log(key + " = " + value);
    }

    var top3 = new Array(3);
    //top3[0] = [1,2];
    //var x = [[1,2]];
    //console.log(x[0][1]);
    console.log(top3);
    // if(top3[1] == null){
    //     console.log("hello");
    // }
    //might need to refactor this later
    //[1,2,3] 4
    for (let [key, value] of allFood) {
        if (top3[2] == null) {
            top3[2] = [key, value];
        }
        else if (top3[2][1] > value) {
            if (top3[1] != null) { //something is already in there
                if (top3[1][1] < value) {
                    top3[0] = top3[1];
                    top3[1] = [key, value];
                }
                else {
                    if (top3[0] == null || top3[0][1] < value) {
                        top3[0] = [key, value];
                    }
                }
            }
            else {
                top3[1] = [key, value];
            }
        }
        else if (top3[2][1] < value) {
            if (top3[1] == null) { //nothing in top[1]
                top3[1] = top3[2];
                top3[2] = [key, value];
            }
            else { //something in top[1]
                top3[0] = top[1];
                top3[1] = top3[2];
                top3[2] = [key, value];
            }
        }
        else {
            console.log("i don't think we should get here???");
        }

    }
    console.log(top3);

    // for(var i = 0; i < allFood.length; i++){
    //     console.log(allFood);
    // }
    // for(let [key, value] of allFood){
    //     out("\t\t" + key + " = " + value)
    // }

    // out(allFood)
    // for(var i in allFood){
    //     out(allFood[i]);
    // }

    var first = "1. ";
    var second = "2. ";
    var third = "3. ";
    var total = first;
    if (top3[2] != null) {
        total += top3[2][0];
    }
    else {
        total += "N/A";
    }
    total += "<br>" + second;
    if (top3[1] != null) {
        total += top3[1][0];
    }
    else {
        total += "N/A";
    }
    total += "<br>" + third;
    if (top3[0] != null) {
        total += top3[0][0];
    }
    else {
        total += "N/A";
    }

    //var total = first + top3[2][0] + "<br>" + second + top3[1][0]+ "<br>" + third + top3[0][0];

    document.getElementById("top3").innerHTML = total;

}


/* DEBUG ONLY FUNCTIONS */
// Easier output messages
// Lets you see the function which called the given message
function out(msg) {
    console.log(arguments.callee.caller.name + "() msg: " + msg);
}