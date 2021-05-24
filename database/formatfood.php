<?php
session_start();
$date = $_POST['date'];
$key = $_POST['key'];

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email = $_SESSION["email"];

$statement = $pdo->prepare("SELECT * 
                            FROM foodForDay 
                            WHERE email=:email 
                            AND date=:date");
$statement->bindValue(':date', $date);
$statement->bindValue(':email', $email);

$statement->execute();

$food = $statement->fetchAll(PDO::FETCH_ASSOC);

$foodArr = array();
foreach($food as $f){
    if($f[$key] != "")
    array_push($foodArr, $f[$key]);
}

echo json_encode($foodArr);
?> 