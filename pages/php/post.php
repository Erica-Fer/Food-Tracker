<?php
echo "in post php";
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
        echo "date: $date";
    }
    
    if(isset($_POST['dayQuality'])){
        //var_dump("here");
        $mood = $_POST['dayQuality'];
        echo "dayQuality: $mood";
    }
    else if (isset($_POST['breakfast'])) {
        $breakfast = $_POST['breakfast'];
        echo "breakfast: $breakfast";
    } else if(isset($_POST['lunch']))
    {
        $lunch = $_POST['lunch'];
        echo "lunch: $lunch";

    } else { // ? may need to be an if/else
        $dinner = $_POST['dinner'];
        echo "dinner: $dinner";
    }

    // if (empty($errors)) {
    $statement = $pdo->prepare("INSERT INTO foodForDay (date, breakfast, lunch, dinner, dayQuality)
                VALUES (:date, :breakfast, :lunch, :dinner, :dayQuality)");
    
    $statement->bindValue(':date', $date);
    $statement->bindValue(':breakfast', $breakfast);
    $statement->bindValue(':lunch', $lunch);
    $statement->bindValue(':dinner', $dinner);
    $statement->bindValue(':dayQuality', $mood);
    $statement->execute();
}

?>