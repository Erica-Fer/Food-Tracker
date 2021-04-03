<html lang="en">

<!-- This page should be removed. It is for testing adding food by date in the addfood page -->
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
            <h1>Test date navigation for food here.</h1>
            <!-- go back -->

            <div class="row">
                <div class="column s12">

                    <a href="addfood.php?date=<?php echo '3/3/21' ?>" class="waves-effect waves-light btn-small">March 3, 2021</a>

                    <a href="addfood.php?date=<?php echo '4/1/21' ?>" class="waves-effect waves-light btn-small">April 1, 2021</a>

                    <a href="addfood.php?date=<?php echo '3/10/21' ?>" class="waves-effect waves-light btn-small">March 10, 2021</a>

                    <br><br><br>
                </div>
            </div>

        </div>
    </div>


    <!--JavaScript at end of body for optimized loading-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {

        });
    </script>


</body>

</html>