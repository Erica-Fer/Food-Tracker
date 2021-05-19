<?php
session_start();

$date = $_GET['date'];
// ? TODO: if no date, default to current day

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare("SELECT * FROM foodForDay WHERE date=:date");
$statement->bindValue(':date', $date);
$statement->execute();

$food = $statement->fetchAll(PDO::FETCH_ASSOC);

$breakfastArr = array();
foreach($food as $f){
    if($f['breakfast'] != "")
        array_push($breakfastArr, $f['breakfast']);
}
// var_dump($breakfastArr);

$lunchArr = array();
foreach($food as $f){
    if($f['lunch'] != "")
        array_push($lunchArr, $f['lunch']);
}
// var_dump($lunchArr);

$dinnerArr = array();
foreach($food as $f){
    if($f['dinner'] != "")
        array_push($dinnerArr, $f['dinner']);
}
// var_dump($dinnerArr);

// var_dump($food);

// make sure that values are actually there
// var_dump($food[0]['breakfast']);
$breakfastFood = $breakfastArr; //(isset($food[0]['breakfast']) ? $food[0]['breakfast'] : null); ?
// var_dump($breakfastFood);
$lunchFood = $lunchArr; //(isset($food[0]['lunch']) != null ? $food[0]['lunch'] : null); ?
$dinnerFood = $dinnerArr; //(isset($food[0]['dinner']) != null ? $food[0]['dinner'] : null); ?
//echo json_encode($date); //UNCOMMENTED THIS MIGHT NEED IT BACK
?>