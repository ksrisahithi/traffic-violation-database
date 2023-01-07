<?php //index.php bro
    session_start();
    // echo("<h1>index</h1>");
    // echo("<br>");

    ob_start();
    include 'connection.php';
    ob_end_clean();

    $conn = open_conn();
    // echo("connected succesfully");
    // echo("<br>");
    close_conn($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://kit.fontawesome.com/2182b01a00.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="css/landingpg.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>TRVMS</title>
</head>
<body>
    <header>
        <img src="/assests/logo.png" alt="Logo" id="logo">
        <div id="links">
            <a href="#" class="nav-btn">About</a>
            <a href="#" class="nav-btn">Source Code</a>
        </div>
    </header>
    <div id="content">
        <div id="txt-box">
            <h1>Traffic <span id='violation'>Violation</span> Management <br>System</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Molestias sequi quas maxime itaque sint necessitatibus sunt iste cumque impedit sit.</p>
            <div id="btns">
                <a href="userlogin.php" class="m-btn">User Login</a>
                <a href="trflogin.php" class="m-btn">Traffic Police Login</a>
            </div>
        </div>
        <img src="assests/8249795.jpg" alt="" id="img-box">
    </div>
</body>
</html>