
window.addEventListener('load',
    function () {
        callDatabase();
    }, false);


// Return the database information between the given date numbers
function callDatabase() {
    out("entered");
}

// ? do we need this
// Get all data into one easy to sort array
// Keeps the sortData() function more specific
function combineData(){}

// Sort the data gotten from the database
// Should be called before formatting data
// Makes it easier to know which was most common bad-day food
function sortData(){}

// Format the data based on most common
// Should list out top 3
function formatData(){}


/* DEBUG ONLY FUNCTIONS */
// Easier output messages
function out(msg){
    console.log(arguments.callee.caller.name + "() msg: " + msg);
}