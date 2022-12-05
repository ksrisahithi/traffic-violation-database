<?php //index.php bro
    session_start();
    echo("<h1>index</h1>");
    echo("<br>");   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRVMS</title>
</head>
<body>
    <button id="myButton" class="float-left submit-button" >user login</button>

    <script type="text/javascript">
        document.getElementById("myButton").onclick = function () {
            location.href = "/userlogin.php";
        };
    </script>

    <button id="myButton2" class="float-left submit-button" >traffic police login</button>
    <script type="text/javascript">
        document.getElementById("myButton2").onclick = function () {
            location.href = "/trflogin.php";
        };
    </script>
</body>
</html>