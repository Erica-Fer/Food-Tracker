<html lang="en">

<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- js file to help handle chips logic -->
    <script src="../js/chipsHelper.js" type="text/javascript"></script>

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <title>Full-Plate</title>
    <link rel="stylesheet" type="text/css" href="../css/materialize.css">
</head>

<body style="background-color: bisque;">
    <div class="container">
        <div class="center-align background: white">

            <h1>Add food for <?php echo $_GET['date'] ?> </h1><br>

            <h2>What did you have for breakfast?</h2>
            <div class="chips1 chips-autocomplete" id="breakfast"></div>

            <h2>What did you have for lunch?</h2>
            <div class="chips2 chips-autocomplete" id="lunch"></div>

            <h2>What did you have for dinner?</h2>
            <div class="chips3 chips-autocomplete" id="dinner"></div>


            <!-- 
            <form action="" class="" method="post">
                <section>
                    <h2>What did you have for breakfast?</h2>
                    <input id="breakfast" type="text" name="breakfast">
                </section>

                <section>
                    <h2>What did you have for lunch?</h2>
                    <input id="lunch" type="text" name="lunch">
                </section>

                <section>
                    <h2>What did you have for dinner?</h2>
                    <input id="dinner" type="text" name="dinner">
                </section> -->

            <!-- submit -->
            <!-- <p class="center-align flow-text">
                <button type="submit" class="waves-effect waves-light btn-large center">Submit</a></button><br><br><br> -->

            <!-- go back -->

            <p id="demo"></p>

            <a href="main.html" class="btn-floating btn-large waves-effect waves-light grey"><i class="material-icons">arrow_back</i></a><br>
            <p class="center-align">Return to calendar.</p>
            </form>
        </div>
    </div>


    <!--JavaScript at end of body for optimized loading-->
    <script src="../js/chipsHelper.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        /* Javascript */

        // get the values from the database for each form
        // used for the chips, so a user can see what theyve already input
        // should let them see previous lunch/dinner/breakfast/etc. entries
        function getDatabase(formNum) {
            switch (formNum) {
                case 0: // breakfast
                    return [{
                        tag: 'Apple'
                    }, {
                        tag: 'Banana'
                    }];
                    break;
                case 1: // lunch
                    return 0;
                    break;
                case 2: // dinner
                    return [{
                        tag: 'Ribeye'
                    }];
                    break;
            }

            return [{
                tag: 'Apple'
            }, {
                tag: 'Locust'
            }];
        }

        document.addEventListener('DOMContentLoaded', function() {
            var elems = [document.querySelectorAll('.chips1'), document.querySelectorAll('.chips2'), document.querySelectorAll('.chips3')];
            // console.log("elems: " + elems); // ? debug

            // set values for each element
            // should let each user form keep unique elements, and elements featured in other forms
            for (i = 0; i < 3; i++) {
                var prevFood = getDatabase(i);

                var instances = M.Chips.init(elems[i], {
                        autocompleteOptions: {
                            data: {
                                'Apple': null,
                                'Microsoft': null,
                                'Google': null
                            },
                            limit: Infinity,
                            minLength: 1
                        },
                        placeholder: 'Enter a tag',
                        secondaryPlaceholder: 'Enter a tag',
                        data: prevFood,
                        onChipAdd: (event) => {
                            console.log("Chip add");
                            console.log(event[0].id); // ? for debug

                            var formId = event[0].id; // the form that was being added to; like lunch/dinner/breakfast/etc.
                            var chipsData = M.Chips.getInstance($('.chips')).chipsData;
                            var newestTag = chipsData[chipsData.length - 1].tag;
                            // console.log("last item: " + chipsData[chipsData.length - 1].tag); // ? for debugging

                            // make call to PHP file to handle giving tags info to be put in database
                            // should let the user add information without ever pressing a "save" button
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("demo").innerHTML = this.responseText; // ? do i need this?
                                }
                            };
                            xhttp.open("POST", "php/post.php", true);
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // ? is this correct?
                            xhttp.send(formId + "=" + newestTag); // should send something in the form of "breakfast=cheese", or other input
                        },
                    }

                );
            }

            console.log("instances: " + instances[0].data);
            // instances[0].data
        });
    </script>


</body>

</html>