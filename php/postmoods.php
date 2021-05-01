<?php
echo "in post php";
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mood = '';

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

    // ? INSERT OVERWRITE
$statement = $pdo->prepare(
    "INSERT INTO foodForDay (date, dayQuality)
    VALUES (:date, :dayQuality)"
    );
    
    $statement->bindValue(':date', $date);
    $statement->bindValue(':dayQuality', $mood);
    $statement->execute();
}

?>