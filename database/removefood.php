<?php
session_start();
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$formId = $_POST['formId'];
$itemToRemove = $_POST['remove'];
$date = $_POST['date'];

$statement = $pdo->prepare("DELETE
                            FROM foodforday
                            WHERE date=:date
                            AND email=:email
                            AND `$formId`=:itemToRemove");
$statement->bindValue(':date', $date);
$statement->bindValue(':email', $_SESSION["email"]);
$statement->bindValue(':itemToRemove', $itemToRemove);
$statement->execute();
?>