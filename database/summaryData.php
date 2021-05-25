<?php
session_start();
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the date information from the URL
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

// ? test values
// $date1 = '2021-04-01';
// $date2 = '2021-04-21';

// Select all food values which appeared on a bad day
// Helps eliminate irrelevant food info
// ? may need to include okay days as well
// ? TODO: update database to be 'bad'
$statement = $pdo->prepare(
    "SELECT breakfast, lunch, dinner
    FROM foodForDay 
    WHERE date >=:date1 
    AND date <=:date2
    AND email=:email
    AND date IN (
	    SELECT date
	    FROM foodForDay
	    WHERE dayQuality = 'bad'
	)
    AND (breakfast <> '' OR lunch <> '' OR dinner <> '')
    ORDER BY breakfast,lunch,dinner");
$statement->bindValue(':date1', $date1);
$statement->bindValue(':date2', $date2);
$statement->bindValue(':email', $_SESSION["email"]);
$statement->execute();
$food = $statement->fetchAll(PDO::FETCH_ASSOC);

// Data to be passed back in summary.js AJAX call
echo json_encode($food);
?>