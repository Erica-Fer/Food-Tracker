<html lang="en">

<?php
session_start();
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM foodForDay');
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

$breakfast = '';
$lunch = '';
$dinner = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $breakfast = $_POST['breakfast'];
    $lunch = $_POST['lunch'];
    $dinner = $_POST['dinner'];

    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO foodForDay (breakfast, lunch, dinner)
                    VALUES (:breakfast, :lunch, :dinner)");

        $statement->bindValue(':breakfast', $breakfast);
        $statement->bindValue(':lunch', $lunch);
        $statement->bindValue(':dinner', $dinner);
        $statement->execute();
        header('Location: addfood.php');
    }
}

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
            <div class="chips chips-autocomplete chips-placeholder"></div>


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
            var instances = M.Chips.init(elems, {});
        });

        /* JQuery */
        // $(document).ready(function() {
        //     $('.chips').chips();
        //     $('.chips-initial').chips({
        //         data: [{
        //             tag: 'Apple',
        //         }, {
        //             tag: 'Microsoft',
        //         }, {
        //             tag: 'Google',
        //         }],
        //     });
        //     $('.chips-placeholder').chips({
        //         placeholder: 'Enter a tag',
        //         secondaryPlaceholder: '+Tag',
        //     });
        //     $('.chips-autocomplete').chips({
        //         autocompleteOptions: {
        //             data: {
        //                 'Apple': null,
        //                 'Microsoft': null,
        //                 'Google': null
        //             },
        //             limit: Infinity,
        //             minLength: 1
        //         },
        //         data: [{
        //             tag: 'Apple',
        //         }],
        //         onChipAdd: () => {
        //             console.log("Chip add");
        //             console.log($('.chips'));
        //         },
        //     });


        // });
    </script>


</body>

</html>