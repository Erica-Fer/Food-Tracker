<?php
//file that grabs the moods from the database for the user to utilize
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare(
    "SELECT date, dayQuality
    FROM foodForDay 
    WHERE dayQuality != '0' ");
    //at some point we should try to just grab the variables from the month? underneath not quite right
    //date >='2021-04-01' AND date <='2021-05-06' AND
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

// Data to be passed back in summary.js AJAX call
echo json_encode($results);
?>