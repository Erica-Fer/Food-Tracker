<?php
// session_start();
$date = $_POST['date'];
$key = $_POST['key'];

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare("SELECT * FROM foodForDay WHERE date=:date");
$statement->bindValue(':date', $date);
$statement->execute();

$food = $statement->fetchAll(PDO::FETCH_ASSOC);

$breakfastArr = array();
foreach($food as $f){
    if($f[$key] != "")
    array_push($breakfastArr, $f[$key]);
}

echo json_encode($breakfastArr);

$lunchArr = array();
foreach($food as $f){
    if($f['lunch'] != "")
        array_push($lunchArr, $f['lunch']);
}

$dinnerArr = array();
foreach($food as $f){
    if($f['dinner'] != "")
        array_push($dinnerArr, $f['dinner']);
}
$breakfastFood = $breakfastArr;
$lunchFood = $lunchArr; 
$dinnerFood = $dinnerArr; 
?>