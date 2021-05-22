<?php
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$formId = $_POST['formId'];
$itemToRemove = $_POST['remove'];
$date = $_POST['date'];

$statement = $pdo->prepare("DELETE
                            FROM foodforday
                            WHERE date=:date
                            AND `$formId`=:itemToRemove");
$statement->bindValue(':date', $date);
$statement->bindValue(':itemToRemove', $itemToRemove);
$statement->execute();
?>