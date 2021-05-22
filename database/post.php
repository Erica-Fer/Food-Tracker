<?php
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM foodForDay');
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$breakfast = '';
$lunch = '';
$dinner = '';
$mood = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //print "here first";
    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }
    
    if (isset($_POST['breakfast'])) {
        $breakfast = $_POST['breakfast'];
    } else if(isset($_POST['lunch']))
    {
        $lunch = $_POST['lunch'];
    } else { // ? may need to be an if/else
        $dinner = $_POST['dinner'];
    }

    // if (empty($errors)) {
    $statement = $pdo->prepare("INSERT INTO foodForDay (date, breakfast, lunch, dinner)
                VALUES (:date, :breakfast, :lunch, :dinner)");
    
    $statement->bindValue(':date', $date);
    $statement->bindValue(':breakfast', $breakfast);
    $statement->bindValue(':lunch', $lunch);
    $statement->bindValue(':dinner', $dinner);
    $statement->execute();
}

?>