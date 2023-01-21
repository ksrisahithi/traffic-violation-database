<?php //------->>>>>>>AFTER THE TRAFFIC POLICE'S DASH <<<<<<<<<<-----
    ob_start();
    session_start();
    require "connection.php";
    ob_end_clean();
    if(!isset($_SESSION['id'])){
        header('Location: trflogin.php');
        die();
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/pplwhoviolated.css">
        <link rel="stylesheet" href="css/title.css">
        <title>People's violation</title>
    </head>
    <body>
        <header>
            <div class="loti">
                <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
                <h1>Add / remove violations</h1>
            </div>
            <div class="whitespace"></div>
            <div id="links">
                <a href="trfperson.php" class="nav-btn">Back</a>
            </div>
        </header>
    <form action = "pplwhoviolated.php" method = 'POST'>
    <btn-wrapper>
        <input class="btn" type = "submit" name = "add" value = "ADD ppl who violated"/>
        <input class="btn" type = "submit" name = "rm" value = "REMOVE ppl who violated"/>
    </btn-wrapper>
    </form>
    <?php
        if(isset($_POST['add'])){
            //create a form and include the required fields for ppl who violated table
            //initialize them into php and then execute a query for inserting all those initialized value into the table
            //should also work on the sorting of this list and stuff but for now this much is enough ig
            header("Location: addpplwhoviolated.php");
        }

        if(isset($_POST['rm'])){
            //this should just include the register number or some primary key initialization and then
            //its just removing nothing much
            header("Location: rmpplwhoviolated.php");
        }
    ?>
    </body>
</html>