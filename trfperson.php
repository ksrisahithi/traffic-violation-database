<?php 
    ob_start();
    session_start();
    require "connection.php";
    ob_end_clean();
    if(!isset($_SESSION['id'])){
        header('Location: trflogin.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic admin</title>
</head>
<body>
    <?php 
        //session_start();
        //$_SESSION['is_login'] = true;
        echo($_SESSION['id']);
        echo("<br>");
        echo($_SESSION['name']);
        echo("<br>");
        //$_SESSION['id'] = $_SESSION['id'];
    ?>
    <button id="trfreg" class="float-left submit-button" >add traffic person</button><br><br>
    <script type="text/javascript">
        document.getElementById("trfreg").onclick = function () {
            location.href = "/trfregister.php";
        };
    </script>
    <button id = "vehicledetails" class="float-left submit-button">view vehicle details</button><br><br>
    <script type="text/javascript">
        document.getElementById("vehicledetails").onclick = function(){
            location.href = "/vehicledetails.php";
        }
    </script>
    <button id = "ppl" class="float-left submit-button">add/delete people who violated</button><br><br>
    <script type="text/javascript">
        document.getElementById("ppl").onclick = function(){
            location.href = "/pplwhoviolated.php";
        }
    </script>
    <button id = "view" class="float-left submit-button">view traffic police</button><br><br>
    <script type="text/javascript">
        document.getElementById("view").onclick = function(){
            location.href = "/trafficpolice.php";
        }
    </script>
    <a href = "trflogout.php">logout</a>
</body>
</html>