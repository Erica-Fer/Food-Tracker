// ? set to be strict when done debugging

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
    xhttp.open("POST", "../php/summaryData.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("date1=2021-04-01&date2=2021-04-21"); // ? TODO: need dates to be variables
}

// Get all data into one easy to sort array
// Keeps the sortData() function more specific
function combineData(data) { 
    // out(Object.prototype.toString.call(data))
    let allFoodItems = new Map();
    let foodAtTime = new Map();


    for(i = 0; data[i] != null; i++){
        // out(data[i]["breakfast"]); // ?
        var br = data[i]["breakfast"];
        var ln = data[i]["lunch"];
        var dn = data[i]["dinner"];
        
        // Add all food to a hashmap and increment how many times its been seen
        // Should be used to define which are worst problem foods
        var value;
        if(br != ""){
            value = allFoodItems.get(br);
            // If NaN, initialize the values
            if(isNaN(value)){
                allFoodItems.set(br, 1);
                foodAtTime.set("breakfast", br);
            }
            else{
                allFoodItems.set(br, value+1);
                foodAtTime.set("breakfast", foodAtTime.get("breakfast")+br);
            }

        }

        value = allFoodItems.get(ln);
        if(ln != ""){
            // If NaN, initialize the values
            if(isNaN(value)){
                allFoodItems.set(ln, 1);
            }
            else{
                allFoodItems.set(ln, value+1);
            }

            foodAtTime.set("lunch", ln);
            foodAtTime.set("lunch", foodAtTime.get("lunch")+ln);
        }

        value = allFoodItems.get(dn);
        if(dn != ""){
            // If NaN, initialize the values
            if(isNaN(value)){
                allFoodItems.set(dn, 1);
            }
            else{
                allFoodItems.set(dn, value+1);
            }

            var obj = [];
            if(!isNaN(foodAtTime.get("dinner")))
                obj.push(foodAtTime.get("dinner"));
            obj.push(dn);
            out("object: " + obj);
            foodAtTime.set("dinner", obj);
        }
    }

    for(let [key, value] of allFoodItems){
        out("\t\t" + key + " = " + value)
    }

    // for(let value of foodAtTime["dinner"]){
    //     out("\t\t" + "Dinner = " + value)
    // }
}

// Sort the data gotten from the database
// Should be called before formatting data
// Makes it easier to know which was most common bad-day food
function sortData() { } // ? not currently used

// Format the data based on most common
// Should list out top 3
function formatData() { }


/* DEBUG ONLY FUNCTIONS */
// Easier output messages
// Lets you see the function which called the given message
function out(msg) {
    console.log(arguments.callee.caller.name + "() msg: " + msg);
}