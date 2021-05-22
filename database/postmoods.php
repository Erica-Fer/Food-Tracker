<?php
echo "in post php";
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mood = '';

// Find mood on day
// If exists, delete, then add
// If not, add it

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
    //ON DUPLICATE KEY UPDATE dayQuality='$mood'
    $statement = $pdo->prepare("SELECT count(*) 
                                FROM foodforday
                                WHERE date=:date
                                AND dayQuality != null");
     $statement->bindValue(':date', $date);
     $statement->execute();

     $moodCount = $statement->fetchAll(PDO::FETCH_ASSOC);
     echo $moodCount;

    
$statement = $pdo->prepare(
    "INSERT INTO foodForDay (date, dayQuality)
    VALUES (:date, :dayQuality)"
    );
    
    //INSERT INTO table (Date,Name,Values) VALUES (CURDATE(),'$name','$values') ON DUPLICATE KEY UPDATE Values='$values'
    $statement->bindValue(':date', $date);
    $statement->bindValue(':dayQuality', $mood);
    $statement->execute();
}
