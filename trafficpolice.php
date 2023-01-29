<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/trafficpolice.css">
    <link rel="stylesheet" href="css/title.css">
    <title>Traffic Police</title>
</head>
<body>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>View Offcer Details</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="trfperson.php" class="nav-btn">Back</a>
        </div>
    </header>
    <div id="tp-form">
        <form action = "trafficpolice.php" method = "POST">
            <label for = "id_" class = "form label">Enter the ID of the officer: </label>
            <input type = "number" name = "id" id = "id"><br>
            <input type="submit" name= "submit" id = "submit" value="Submit">
        </form>
        <p id="message"></p>
    </div>
    
    <?php
        session_start();
        ob_start();
        include "connection.php";
        ob_end_clean();
        if(!isset($_SESSION['id'])){
            header("Location: trflogin.php");
            die();
        }
        if(isset($_POST['submit'])){
            if(!empty($_POST['id'])){
                $id = $_POST['id'];
                $conn = open_conn();
                $sql = "SELECT * FROM traffic_police WHERE id = $id";
                $result = $conn->query($sql);
                if($result->num_rows === 1){
                    echo("<table>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>DESIGNATION</th>
                            <th>ZONE</th>
                        </tr>
                    ");
                    while($row = $result->fetch_assoc()){
                        echo("<tr>");
                        echo("<td>".$row['id']."</td>");
                        echo("<td>".$row['name']."</td>");
                        echo("<td>".$row['designation']."</td>");
                        echo("<td>".$row['zone_']."</td>");
                    }
                    $result->free();
                } else {
                    echo("<script>document.getElementById('message').innerHTML = 'No officer with ID ".$id."'</script>");
                }
            }
        }
    ?>
</body>
</html>