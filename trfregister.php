<!-- THE TRAFFIC POLICEMAN REGISTER FORM (DATABASE WORKS!) -->
<!-- STILL NEED TO STYLE THE PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">]
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <title>TRVMS Traffic Police Registeration</title>
</head>
<body>

    <form action = "trfregister.php" method="POST">
        <h2>REGISTER</h2>
        <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label for="name">name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="id">id:</label><br>
        <input type="text" id="id" name="id"><br>
        <label for="zone">zone:</label><br>
        <input type="text" id="zone" name="zone"><br>
        <label for="desg">designation:</label><br>
        <input type="text" id="desg" name="desg"><br>
        <input type="submit" value = "submit">
    </form>

</body>
</html>
<?php
    session_start();
    ob_start();
    include "connection.php";
    ob_end_clean();

    $name = $_REQUEST['name'];
    $id = $_REQUEST['id'];
    $zone = $_REQUEST['zone'];
    $desg = $_REQUEST['desg'];
    
    $conn = open_conn();
    $sql = "INSERT INTO traffic_police VALUES('$id', '$name', '$desg', '$zone')";
    $result = $conn->query($sql);
    if($result){
        echo("there is something added into the database");
    }
    else{
        echo("error ".$conn->error);
    }
    
    close_conn($conn);
?>