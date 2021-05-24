<?php

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM users');
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

$email = '';
$password = '';
$foundEmail = false;
$foundPassword = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    foreach ($users as $info) :
        $hashPwd = $info['password'];
        $foundPassword = password_verify($password, $hashPwd);
        
        $foundEmail = ($info['email'] == $email);

        // $foundPassword = $info['password'] == $password;

        if ($foundEmail || $foundPassword) {
            session_start();
            $_SESSION["uid"] = $info["id"];
            $_SESSION["email"] = $info["email"];
            break;
        }
    endforeach;

    if (!$email) {
        $errors[] = 'Please provide an email address.';
    }

    if (!$password) {
        $errors[] = 'Please provide a password.';
    }

    if (!$foundEmail && !$foundPassword) {
        $errors[] = 'Account does not exist.' . PHP_EOL . 'Try again, or sign-up here: <a href="register.php">Register for Full-Plate</a>';
    }else if (!$foundEmail && $email) {
        $errors[] = 'Email not found.';
    } else if (!$foundPassword && $password) {
        $errors[] = 'Password not found.';
    }

    // if (empty($errors)) {
        // $statement = $pdo->prepare("INSERT INTO users (email, password)
        //             VALUES (:email, :password)");

        // $statement->bindValue(':email', $email);
        // $statement->bindValue(':password', $password);
        // $statement->execute();
        // header('Location: ../presentation/main.html');
    // }else{
        echo json_encode($errors);
        // ? return to request.js
    // }
}


?>