<html lang="en">

<?php
session_start();

$date = $_GET['date'];
// ? TODO: if no date, default to current day

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare("SELECT * FROM foodForDay WHERE date=:date");
$statement->bindValue(':date', $date);
$statement->execute();

$food = $statement->fetchAll(PDO::FETCH_ASSOC);

$breakfastArr = array();
foreach($food as $f){
    if($f['breakfast'] != "")
        array_push($breakfastArr, $f['breakfast']);
}
// var_dump($breakfastArr);

$lunchArr = array();
foreach($food as $f){
    if($f['lunch'] != "")
        array_push($lunchArr, $f['lunch']);
}
// var_dump($lunchArr);

$dinnerArr = array();
foreach($food as $f){
    if($f['dinner'] != "")
        array_push($dinnerArr, $f['dinner']);
}
// var_dump($dinnerArr);

// var_dump($food);

// make sure that values are actually there
// var_dump($food[0]['breakfast']);
$breakfastFood = $breakfastArr; //(isset($food[0]['breakfast']) ? $food[0]['breakfast'] : null); ?
// var_dump($breakfastFood);
$lunchFood = $lunchArr; //(isset($food[0]['lunch']) != null ? $food[0]['lunch'] : null); ?
$dinnerFood = $dinnerArr; //(isset($food[0]['dinner']) != null ? $food[0]['dinner'] : null); ?
//echo json_encode($date); //UNCOMMENTED THIS MIGHT NEED IT BACK
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <title>Full-Plate</title>
    <link rel="stylesheet" type="text/css" href="../css/materialize.css">
</head>

<body style="background-color: bisque;">
    <div class="container">
        <div class="center-align background: white">

            <h1>Add food for <?php echo $_GET['date'] ?> </h1><br>

            <form>
                <label for="askDay">How was the quality of your day?</label>
                <select name="askDay" id="askDay">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="good">Good</option>
                    <option value="okay">Okay</option>
                    <option value="bad">Bad</option>
                </select>
                <input type="button" id="submit" value="Submit">
            </form>
            <h2>What did you have for breakfast?</h2>
            <div class="chipsbreakfast chips-autocomplete" id="breakfast"></div>

            <h2>What did you have for lunch?</h2>
            <div class="chipslunch chips-autocomplete" id="lunch"></div>

            <h2>What did you have for dinner?</h2>
            <div class="chipsdinner chips-autocomplete" id="dinner"></div>

            <!-- used for loading xhttp GET/POST calls in javascript -->
            <p id="demo"></p>

            <a href="main.html" class="btn-floating btn-large waves-effect waves-light grey"><i class="material-icons">arrow_back</i></a><br>
            <p class="center-align">Return to calendar.</p>
            </form>
        </div>
    </div>


    <!--JavaScript at end of body for optimized loading-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        /* Javascript */

        // get the php values as defined the beginning of the file
        // lets us set food already in the database as chips data
        window.onload = function () {
            document.getElementById("submit").onclick = saveMood;
    };

        function getFood(formNum) {
            // Default to a null value so that if there is nothing, return is not empty
            var result = '';

            // Begin the string to be used for parsing input
            // This is what allows for each input food to have individual chip
            // The format of string should be the following:
            //'[' + '{ "tag": "' + foodTest[0] + '" }' + ',' + '{ "tag": "' + foodTest[2] + '" }' + ']';
            var food = '[';

            switch (formNum) {
                case 0: // breakfast
                    result = <?php echo json_encode($breakfastFood, JSON_HEX_TAG) ?>;
                    console.log("breakfast: " + result[0]);
                    for(var i = 0; i < result.length; i++){
                        food += '{ "tag": "' + result[i] + '" }';
                        if(i < result.length-1){
                            food += ',';
                        }
                    }
                    break;
                case 1: // lunch
                    result = <?php echo json_encode($lunchFood, JSON_HEX_TAG) ?>;
                    for(var i = 0; i < result.length; i++){
                        food += '{ "tag": "' + result[i] + '" }';
                        if(i < result.length-1){
                            food += ',';
                        }
                    }
                    break;
                case 2: // dinner
                    result = <?php echo json_encode($dinnerFood, JSON_HEX_TAG) ?>;
                    for(var i = 0; i < result.length; i++){
                        food += '{ "tag": "' + result[i] + '" }';
                        if(i < result.length-1){
                            food += ',';
                        }
                    }
                    break;
            }

            if (result == null || result.length < 1) {
                return 0;
            }

            // Close off the string and return the parsed food info to be used in the event listener
            food += ']';
            return JSON.parse(food);
        }

        function saveMood(){
            //alert("i'm here");
            var mood = document.getElementById("askDay").value;
            console.log("value is " + mood);
            //this isn't quite right
            //$date
            //console.log(<?php echo json_encode($date) ?>);
            var date = "&date=" + <?php echo json_encode($date) ?>;
            console.log(date);
            //var date = "&date=2021-04-21";

            // make call to PHP file to handle giving tags info to be put in database
            // should let the user add information without ever pressing a "save" button
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                }
            };
            xhttp.open("POST", "../php/postmoods.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
            console.log("made it here");
            xhttp.send("dayQuality" + "=" + mood + date); // should send something in the form of "breakfast=cheese", or other input
            console.log("hello");
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log("going in here");
            /* CODE FOR DAY QUALITY */
            var elemsSelect = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elemsSelect, {
            });
            console.log(elemsSelect.value);

            // var askForm = document.querySelector('askDay');
            // askForm.addEventListener('change', function() {
            //     alert('changed form!!');
            // });
            //for(int i = 0; i <elemsSelect.length; i++){
              //  console.log("elemsSelect" + elemsSelect[i];
           // }
            
            console.log("instances" + instances.toString());


            /* CODE FOR CHIPS(tags) */
            // array of all chips forms
            // add as needed, just use '.chips<name>' for the querySelector
            // ONLY USE FOR CHIP ELEMENTS
            var elemChips = [document.querySelectorAll('.chipsbreakfast'), document.querySelectorAll('.chipslunch'), document.querySelectorAll('.chipsdinner')];

            // set values for each element
            // should let each user form keep unique elements, and elements featured in other forms
            for (i = 0; i < elemChips.length; i++) {
                var prevFood = getFood(i);

                var instances = M.Chips.init(elemChips[i], {
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
                        var formData = '.chips' + formId;
                        var chipsData = M.Chips.getInstance($(formData)).chipsData;

                        var newestTag = chipsData[chipsData.length - 1].tag;
                        var date = "&date=" + <?php echo json_encode($date) ?>;

                        // make call to PHP file to handle giving tags info to be put in database
                        // should let the user add information without ever pressing a "save" button
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                            }
                        };
                        xhttp.open("POST", "../php/post.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
                        xhttp.send(formId + "=" + newestTag + date); // should send something in the form of "breakfast=cheese", or other input
                    }
                });
            }
        });

    </script>
</body>

</html>