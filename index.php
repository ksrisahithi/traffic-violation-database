<?php
    session_start();
    ob_start();
    include 'connection.php';
    ob_end_clean();

    $conn = open_conn();
    close_conn($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/landingpg.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>TRVMS</title>
</head>
<body>
    <header>
        <img src="/assests/logo.png" alt="Logo" id="logo">
        <div id="links">
            <a href="https://github.com/ksrisahithi/traffic-violation-database/blob/main/README.md" target="_blank" rel="noopener noreferrer" class="nav-btn">About</a>
            <a href="https://github.com/ksrisahithi/traffic-violation-database" target="_blank" rel="noopener noreferrer" class="nav-btn">Source Code</a>
        </div>
    </header>
    <div id="content">
        <div id="txt-box">
            <h1>Traffic <span id='violation'>Violation</span> Management <br>System</h1>
            <p>Does your city have out of control traffic? Don't worry you have come to the right place. One stop solution for facilitating traffic violation management.</p>
            <div id="btns">
                <a href="userlogin.php" class="m-btn">User Login</a>
                <a href="trflogin.php" class="m-btn">Traffic Police Login</a>
            </div>
        </div>
        <img src="assests/8249795.jpg" alt="" id="img-box">
    </div>
</body>
</html>