<?php
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
    //find if mood exists on day
    session_start();
    $statement = $pdo->prepare("SELECT count(*) 
                                FROM foodforday 
                                WHERE date=:date
                                AND email=:email 
                                AND (dayQuality='okay' 
                                OR dayQuality='good' 
                                OR dayQuality='bad')");
    $statement->bindValue(':date', $date);
    $statement->bindValue(':email', $_SESSION["email"]);
    $statement->execute();
    
    //gets count 
    $moodStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
    $moodCount = 0;
    foreach($moodStatement as $m){
        foreach($m as $data)
            $moodCount = $data;
    } 
    //if there was already a value in the table 
    if($moodCount > 0){
        //echo "deleting";
        //DELETE FROM table_name WHERE condition;
        $statement = $pdo->prepare("DELETE FROM foodforday 
                                    WHERE date=:date
                                    AND email=:email
                                    AND (dayQuality='okay' 
                                    OR dayQuality='good' 
                                    OR dayQuality='bad')");
        $statement->bindValue(':date', $date);
        $statement->bindValue(':email', $_SESSION["email"]);
        $statement->execute();
    } 

    //add new value to table
    $statement = $pdo->prepare(
        "INSERT INTO foodForDay (date, email, dayQuality)
        VALUES (:date, :email, :dayQuality)"
        );
    
    //INSERT INTO table (Date,Name,Values) VALUES (CURDATE(),'$name','$values') ON DUPLICATE KEY UPDATE Values='$values'
    $statement->bindValue(':date', $date);
    $statement->bindValue(':email', $_SESSION["email"]);
    $statement->bindValue(':dayQuality', $mood);
    $statement->execute();
}
