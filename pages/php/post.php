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