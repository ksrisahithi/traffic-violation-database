<!-- TEMP-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles Details</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size:12px;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        echo("<h3>VEHICLES DETAILS<br>");
        ob_start();
        include "connection.php";
        ob_end_clean();
        //echo($_SESSION['id']."<br>");
        if(!isset($_SESSION['id'])){
            header("Location: trflogin.php");
            die();
        }
        $conn = open_conn();
        $sql = "SELECT * FROM vehicle_details";
        $result = $conn->query($sql);      
    ?>
    <table cellspacing = "2" cellpadding = "2">
        <tr>
            <th style=font-size:12px>REGISTER NUMBER</th>
            <th style=font-size:12px>REGISTERATION DATE</th>
            <th style=font-size:12px>CHASSIS NUMBER</th>
            <th style=font-size:12px>ENGINE NUMBER</th>
            <th style=font-size:12px>AADHAR NUMBER</th>
            <th style=font-size:12px>VEHICLE CLASS</th>
            <th style=font-size:12px>FUEL TYPE</th>
            <th style=font-size:12px>MODEL</th>
            <th style=font-size:12px>REGISTERATION VALIDITY</th>
            <th style=font-size:12px>MV TAX VALIDITY</th>
            <th style=font-size:12px>INSURANCE VALIDITY</th>
            <th style=font-size:12px>PUCC VALIDITY</th>
            <th style=font-size:12px>EMISSION NORMS</th>
            <th style=font-size:12px>RC STATUS</th>
        </tr>
        <?php
            if($result){
                while($row = $result->fetch_assoc()){
                    echo("<tr>");
                    echo("<td>".$row['reg_no']."</td>");
                    echo("<td>".$row['reg_date']."</td>");
                    echo("<td>".$row['chassis_no']."</td>");
                    echo("<td>".$row['engine_no']."</td>");
                    echo("<td>".$row['aadhar_no']."</td>");
                    echo("<td>".$row['vehicle_class']."</td>");
                    echo("<td>".$row['fuel']."</td>");
                    echo("<td>".$row['model']."</td>");
                    echo("<td>".$row['regn_upto']."</td>");
                    echo("<td>".$row['mv_tax_upto']."</td>");
                    echo("<td>".$row['insurance_upto']."</td>");
                    echo("<td>".$row['pucc_upto']."</td>");
                    echo("<td>".$row['emission_norms']."</td>");
                    echo("<td>".$row['rc_status']."</td>");
                }
                $result->free();
            }
        ?>
    </table><br>
    <button id="back">Back</button>
    <script type="text/javascript">
        document.getElementById("back").onclick = function () {
            location.href = "/trfperson.php";
        };
    </script>
</body>
</html>