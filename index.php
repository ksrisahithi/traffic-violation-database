<?php //index.php bro
    session_start();
    echo("<h1>index</h1>");
    echo("<br>");

    ob_start();
    include 'connection.php';
    ob_end_clean();

    $conn = open_conn();
    echo("connected succesfully");
    echo("<br>");
    close_conn($conn);

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
    <button id="userlogin" class="float-left submit-button" >user login</button>
    <script type="text/javascript">
        document.getElementById("userlogin").onclick = function () {
            location.href = "/userlogin.php";
        };
    </script>

    <button id="trflogin" class="float-left submit-button" >traffic police login</button>
    <script type="text/javascript">
        document.getElementById("trflogin").onclick = function () {
            location.href = "/trflogin.php";
        };
    </script>

    <button id="dbconn" class="float-left submit-button" >database connection status</button>
    <script type="text/javascript">
        document.getElementById("dbconn").onclick = function () {
            location.href = "/connection.php";
        };
    </script>
</body>
</html>