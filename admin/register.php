<!--  -->

<?php

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$email = '';
$password1 = '';
$password2 = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if (!$email) {
        $errors[] = 'Please provide a username.';
    }

    if (!$password1) {
        $errors[] = 'Please provide a password.';
    } else if (!$password2) {
        $errors[] = 'Please re-enter your password.';
    } else if ($password1 != $password2) {
        $errors[] = 'Your passwords do not match. Please make sure you entered them correctly.';
    }

    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO users (email, password)
                    VALUES (:email, :password)");

        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password1);
        $statement->execute();
        // header('Location: ../presentation/main.html'); // ?
    }

    echo json_encode($errors);
}

?>