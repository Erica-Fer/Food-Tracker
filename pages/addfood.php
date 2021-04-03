<html lang="en">

<?php
session_start();
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM foodForDay');
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if (isset($_POST['breakfast'])) {
    $temp = $_POST['breakfast'];
    echo "breakfast: $temp";
}
// $breakfast = $_POST['breakfast'];
$lunch = '';
$dinner = '';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $breakfast = $_POST['breakfast'];
//     $lunch = $_POST['lunch'];
//     $dinner = $_POST['dinner'];

//     if (empty($errors)) {
//         $statement = $pdo->prepare("INSERT INTO foodForDay (breakfast, lunch, dinner)
//                     VALUES (:breakfast, :lunch, :dinner)");

//         $statement->bindValue(':breakfast', $breakfast);
//         $statement->bindValue(':lunch', $lunch);
//         $statement->bindValue(':dinner', $dinner);
//         $statement->execute();
//         header('Location: addfood.php');
//     }
// }

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

            <h2>What did you have for breakfast?</h2>
            <div class="chips chips-autocomplete" id="breakfast"></div>

            <h2>What did you have for lunch?</h2>
            <div class="chips chips-autocomplete" id="lunch"></div>

            <h2>What did you have for dinner?</h2>
            <div class="chips chips-autocomplete" id="dinner"></div>


            <!-- 
            <form action="" class="" method="post">
                <section>
                    <h2>What did you have for breakfast?</h2>
                    <input id="breakfast" type="text" name="breakfast">
                </section>

                <section>
                    <h2>What did you have for lunch?</h2>
                    <input id="lunch" type="text" name="lunch">
                </section>

                <section>
                    <h2>What did you have for dinner?</h2>
                    <input id="dinner" type="text" name="dinner">
                </section> -->

            <!-- submit -->
            <!-- <p class="center-align flow-text">
                <button type="submit" class="waves-effect waves-light btn-large center">Submit</a></button><br><br><br> -->

            <!-- go back -->

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
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.chips');
            var instances = M.Chips.init(elems, {
                autocompleteOptions: {
                    data: {
                        'Apple': null,
                        'Microsoft': null,
                        'Google': null
                    },
                    limit: Infinity,
                    minLength: 1
                },
                placeholder: 'Enter a tag',
                secondaryPlaceholder: 'Enter a tag',
                data: [{
                    tag: 'Apple',
                }],
                onChipAdd: (event) => {
                    console.log("Chip add");
                    console.log(event[0].id);

                    var formId = event[0].id; // the form that was being added to
                    var chipsData = M.Chips.getInstance($('.chips')).chipsData;
                    var newestTag = chipsData[chipsData.length - 1].tag;
                    // console.log("last item: " + chipsData[chipsData.length - 1].tag); // ? for debugging

                    // make call to PHP file to handle giving tags info to be put in database
                    // should let the user add information without ever pressing a "save" button
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                        }
                    };
                    xhttp.open("POST", "php/post.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
                    xhttp.send(formId+"="+newestTag);
                },
            });
        });
    </script>


</body>

</html>