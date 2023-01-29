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
    <link rel="stylesheet" href="css/trfperson.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Traffic admin</title>
</head>
<body>
    <!-- <?php 
        echo($_SESSION['id']);
        echo("<br>");
        echo($_SESSION['name']);
        echo("<br>");
    ?> -->
    <header>
        <div class="loti">
            <a href="index.php"><img src="/assests/logo.png" alt="Logo" id="logo"></a>
            <h1>Officer Dashboard</h1>
        </div>
        <div class="whitespace"></div>
        <div class="dets">
            <p><span class="thin">Name : </span><span class="thick"><?php echo($_SESSION['name']);?></span></p>
            <p><span class="thin">ID : </span><span class="thick"><?php echo($_SESSION['id']);?></span></p>
        </div>
        <div id="links">
            <a href="trflogout.php" class="nav-btn">logout</a>
        </div>
    </header>
    <div class="content">
        <div class="card">
            <img src="assests/pngaaa.com-3777426.png" alt="">
            <p>Add new traffic police officer to the database.</p>
            <a href="trfregister.php">add traffic police</a>
        </div>
        <div class="card">
            <img src="assests/icon-inventory-vehicle.svg" alt="">
            <p>View user's vehicle details.</p>
            <a href="vehicledetails.php">view vehicle details</a>
        </div>
        <div class="card">
            <img src="assests/pngaaa.com-3777426.png" alt="">
            <p>View registered traffic police officer details.</p>
            <a href="trafficpolice.php">view traffic police</a>
        </div>
        <div class="card">
            <img src="assests/20946025.jpg" alt="">
            <p>Issue traffic violation fines or view violations.</p>
            <a href="addpplwhoviolated.php">add violations</a>
        </div>
        <div class="card">
            <img src="assests/20946030.jpg" alt="">
            <p>Issue traffic violation fines or view violations.</p>
            <a href="rmpplwhoviolated.php">remove violations</a>
        </div>
    </div>
</body>
</html>