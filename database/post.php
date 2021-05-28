<?php
session_start();
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM foodForDay');
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$breakfast = '';
$lunch = '';
$dinner = '';
$snacks = '';
$mood = '';
$symptoms = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    print "here first";
    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }
    
    if (isset($_POST['breakfast'])) {
        $breakfast = $_POST['breakfast'];
    } 
    else if(isset($_POST['lunch'])){
        $lunch = $_POST['lunch'];
    } 
    else if(isset($_POST['dinner'])) { // ? may need to be an if/else
        $dinner = $_POST['dinner'];
    } 
    else if(isset($_POST['snacks'])){
        print "shouldn't be here here";

        $snacks = $_POST['snacks'];
    }
    else if(isset($_POST['symptoms'])){
        print "in here";
        $symptoms = $_POST['symptoms'];
    }
    

    // if (empty($errors)) {
    $statement = $pdo->prepare("INSERT INTO foodForDay (date, email, breakfast, lunch, dinner, snacks, symptoms)
                VALUES (:date, :email, :breakfast, :lunch, :dinner, :snacks, :symptoms)");
    
    $statement->bindValue(':date', $date);
    $statement->bindValue(':email', $_SESSION["email"]);
    $statement->bindValue(':breakfast', $breakfast);
    $statement->bindValue(':lunch', $lunch);
    $statement->bindValue(':dinner', $dinner);
    $statement->bindValue(':snacks', $snacks);
    $statement->bindValue(':symptoms', $symptoms);
    $statement->execute();
}

?>