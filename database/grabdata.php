

<?php
session_start();
    // File for handling grabbing database information.
    // Should be used so that chips in addfood.html can display info that a user has already input.

    // Referenced StackOverflow page for SQL statement preperation:
    //     https://stackoverflow.com/questions/28283141/how-to-select-from-a-dynamic-column-through-a-variable-with-pdo

// set this to prevent SQL injection
// expand as needed
$allowedCol = array('breakfast', 'lunch', 'dinner');
$formType = $_POST['formType'];
$date = $_POST['date'];
$result = '';

if (in_array($formType, $allowedCol)){
    $result = getFood($date, $formType);
}

$foodArr = $result[0];
$food = $foodArr[$formType];
echo json_encode($food);
// echo '<pre>';
// var_dump($food);
// echo '</pre>';

function getFood($date, $form){
    $pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = $_SESSION["email"];
    
    $statement = $pdo->prepare("SELECT $form FROM foodForDay WHERE date=:date AND email=:email");
    $statement->bindValue(':date', $date);
    $statement->bindValue(':email', $email);

    $statement->execute();
    
    $food = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $food;
}