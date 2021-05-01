<?php
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

// ? test values
$date1 = '2021-04-01';
$date2 = '2021-04-21';

$statement = $pdo->prepare(
    "SELECT breakfast, lunch, dinner
    FROM foodForDay 
    WHERE date >=:date1 
    AND date <=:date2");
$statement->bindValue(':date1', $date1);
$statement->bindValue(':date2', $date2);
$statement->execute();
$food = $statement->fetchAll(PDO::FETCH_ASSOC);

echo var_dump($food);
?>