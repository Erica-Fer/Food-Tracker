<!-- 

    File for handling grabbing database information.
    Should be used so that chips in addfood.php can display info that a user has already input.

 -->


<?php
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM foodForDay');
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$breakfast = '';
$lunch = '';
$dinner = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['breakfast'])) {
        $breakfast = $_POST['breakfast'];
        echo "breakfast: $breakfast";
    } else if(isset($_POST['lunch']))
    {
        $lunch = $_POST['lunch'];
        echo "lunch: $lunch";

    } else { // ? may need to be an if/else
        $dinner = $_POST['dinner'];
        echo "dinner: $dinner";
    }

    // if (empty($errors)) {
    //     $statement = $pdo->prepare("INSERT INTO foodForDay (breakfast, lunch, dinner)
    //                 VALUES (:breakfast, :lunch, :dinner)");

    //     $statement->bindValue(':breakfast', $breakfast);
    //     $statement->bindValue(':lunch', $lunch);
    //     $statement->bindValue(':dinner', $dinner);
    //     $statement->execute();
    //     header('Location: addfood.php');
    // }
}

?>