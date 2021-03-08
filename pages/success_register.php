<html lang="en">

<?php

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $statement = $pdo->prepare('SELECT * FROM users ORDER BY email');
// $statement->execute();
// $users = $statement->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($users);
// echo '</pre>';

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
    <link rel="stylesheet" type="text/css" href="css/materialize.css">
</head>

<body style="background-color: bisque;">
    <!-- login box -->
    <div class="container">
        <div class="row">
            <div class="col s12"></div>
            <div class="col s12 m7 l6">
                <div class="card">
                    <div class="card-content">
                        <!-- intro paragraph -->
                        <p class="center-align">
                        <p class="flow-text">Hello, and welcome to Full-Plate!</p> <br>
                        We provide a number of settings you can change to make the app as accessible as possible. <b>Font size, color, and contrast</b> are all customizable. Would you like to make those changes now?
                        </p><br><br>

                        <!-- go to settings button -->
                        <p class="center-align">
                            <a href="settings.php" class="waves-effect waves-light btn-large center">Yes! Take me to settings.</a><br><br><br>

                        <!-- go to main button -->
                        <p class="center-align">
                            <a href="main.php" class="waves-effect waves-light btn-large center grey">No, take me to the app.</a><br><br><br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {

        });
    </script>


</body>

</html>