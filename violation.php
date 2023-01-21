<?php 
    ob_start();
    session_start();
    require "connection.php";
    ob_end_clean();
    if(!isset($_SESSION['aadhar_no'])){
        header("Location: userlogin.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/violation.css">
    <title>VIOLATIONS DETAILS</title>
</head>
<body>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>Traffic violations & fines</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="user.php" class="nav-btn">Back</a>
        </div>
    </header>
    <table cellspacing = "2" cellpadding = "2">
        <tr>
            <th style=font-size:12px>SL.NO</th>
            <th style=font-size:12px>VIOLATION TYPE</th>
            <th style=font-size:12px>FINE CHARGED WHEN BOOKED</th>
        </tr>
    <?php
        $conn = open_conn();
        $sql = "SELECT * FROM violation";
        $result = $conn->query($sql);
        if($result){
            while($row = $result->fetch_assoc()){
                echo("<tr>
                        <td>".$row['violation_id']."</td>
                        <td>".$row['violation_name']."</td>
                        <td>".$row['fine']."</td>
                        </tr>");
            }
            $result->free();
        }
        else{
            echo($conn->error);
        }
    ?>
    </table><br><br>
    <button id="back">Back</button>
    <script type="text/javascript">
        document.getElementById("back").onclick = function () {
            location.href = "user.php";
        };
    </script>
</body>
</html>