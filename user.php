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
    <title>USER Dashboard</title>
</head>
<body>
    <button id = "view" class="float-left submit-button">view violations</button><br><br>
    <script type="text/javascript">
        document.getElementById("view").onclick = function(){
            location.href = "/violation.php";
        }
    </script>
    <a href = "trflogout.php">logout</a>
</body>
</html>

<?php
    $aadhar_no = $_SESSION['aadhar_no'];
    $conn = open_conn();
    $sql = "SELECT aadhar_no FROM ppl_who_violated WHERE aadhar_no = $aadhar_no";
    $result = $conn->query($sql);
    if($result){
        echo("<br>you have been booked for the violations");
    }
?>