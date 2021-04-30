<html lang="en">

<?php
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=fullplate_users', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

$statement = $pdo->prepare("SELECT breakfast
 FROM foodForDay 
 WHERE EXISTS
    (SELECT dayQuality 
    FROM foodForDay
    WHERE dayQuality = 'b'
    AND date >=:date1 
    AND date <=:date2
    )
 AND date >=:date1 
 AND date <=:date2");
$statement->bindValue(':date1', $date1);
$statement->bindValue(':date2', $date2);
$statement->execute();
$breakfast = $statement->fetchAll(PDO::FETCH_ASSOC);

echo var_dump($breakfast);

$statement = $pdo->prepare("SELECT lunch FROM foodForDay WHERE date >=:date1 AND date <=:date2");
$statement->bindValue(':date1', $date1);
$statement->bindValue(':date2', $date2);
$statement->execute();
$lunch = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT dinner FROM foodForDay WHERE date >=:date1 AND date <=:date2");
$statement->bindValue(':date1', $date1);
$statement->bindValue(':date2', $date2);
$statement->execute();
$dinner = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <title>Full-Plate</title>
    <link rel="stylesheet" type="text/css" href="../css/materialize.css">
</head>

<body style="background-color: bisque;">
    <div class="container">
        <div class="center-align background: white">

            <h1>Food you had through <?php echo $_GET['date1']?> and <?php echo $_GET['date2']?></h1><br>

            <h2>What you had for breakfast</h2>
            <?php foreach ($breakfast as $b) : ?>
                <div class="flow-text"><?php echo $b['breakfast'] ?></div>
            <?php endforeach; ?>

            <h2>What you had for lunch</h2>
            <?php foreach ($lunch as $l) : ?>
                <div class="flow-text"><?php echo $l['lunch'] ?></div>
            <?php endforeach; ?>

            <h2>What you had for dinner</h2>
            <?php foreach ($dinner as $d) : ?>
                <div class="flow-text"><?php echo $d['dinner'] ?></div>
            <?php endforeach; ?>

            <!-- used for loading xhttp GET/POST calls in javascript -->
            <p id="demo"></p>

            <a href="main.html" class="btn-floating btn-large waves-effect waves-light grey"><i class="material-icons">arrow_back</i></a><br>
            <p class="center-align">Return to calendar.</p>
            </form>
        </div>
    </div>


    <!--JavaScript at end of body for optimized loading-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        /* Javascript */
        document.addEventListener('DOMContentLoaded', function() {

        });
    </script>
</body>

</html>