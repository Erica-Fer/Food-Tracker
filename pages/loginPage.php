<html lang="en">

<?php

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM users');
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

$email = '';
$password = '';
$foundEmail = '';
$foundPassword = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $foundEmail = $users['$email'];
    $foundPassword = $users['$password'];
    
    echo '<pre>';
    var_dump($foundEmail);
    echo '</pre>';
    
    if (!$email) {
        $errors[] = 'Please provide a username.';
    }

    if (!$password) {
        $errors[] = 'Please provide a password.';
    }



    if (empty($errors)) {
        // $statement = $pdo->prepare("INSERT INTO users (email, password)
        //             VALUES (:email, :password)");

        // $statement->bindValue(':email', $email);
        // $statement->bindValue(':password', $password);
        // $statement->execute();
        header('Location: main.php');
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
                        <div class="card-title">Full-Plate Login</div>
                        
                        <form action="" method="post">
                        <!-- email -->
                        <div class="row">
                            <div class="input-field col s12 text-black">
                                <i class="material-icons prefix">email</i>
                                <input id="email" type="email" class="validate">
                                <label for="email">Enter your E-mail</label>
                                <span class="helper-text" data-error="Please enter a valid e-mail addreess."
                                    data-success=""></span>
                            </div>
                        </div>

                        <!-- password -->
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">phonelink_lock</i>
                                <input id="password" type="password" class="validate">
                                <label for="password">Enter your password</label>
                            </div>
                        </div>

                        <!-- submit -->
                        <p class="center-align flow-text">
                            <button type="submit" class="waves-effect waves-light btn-large center">Submit</a></button><br><br><br>

                            <!-- go back -->
                            <a href="../index.html" class="btn-floating btn-large waves-effect waves-light grey"><i
                                    class="material-icons">arrow_back</i></a><br>
                                    <p class="center-align">Return to welcome screen.</p>

                        </p>
                        </form>
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
        $(document).ready(function () {

        });
    </script>


</body>

</html>