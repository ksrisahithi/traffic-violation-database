<!-- TEMP bro please work on tis shit-->
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

        #regtable {
            border: none;
        }
        #regno {
            width : 260 px
        }
    </style>
</head>
<body>
    <p>enter the register number
    <div class = "container-lg">
        <form name = "regno" action = "vehicledetails.php" method = "POST">
            <label for = "reg" class = "form label">RegNo</label><br>
                <input type = "text" name = "state" id = "state" maxlength = "2" size = "2">
                <input type="text" name="no" id = "no" maxlength = "2" size = "2">
                <input type="text" name="somed" id = "somed" maxlength = "2" size = "2">
                <input type="text" name="no1" id= "no1" maxlength = "4" size = "2"><br><br>
                <input type="submit" name= "submit" id = "submit" value="submit">
        </form>
    </div>
    
<?php
    ob_start();
    include "connection.php";
    ob_end_clean();
    if(isset($_POST['submit'])){
        if(empty($_POST['state']) && empty($_POST['no']) && empty($_POST['somed']) && empty($_POST['no1']) && !is_int($_POST['no']) && !is_int($_POST['no1'])) {
            echo("enter the valid details");
        }
        else {
            $state = strtolower($_POST['state']);
            $no = $_POST['no'];
            $somed = strtolower($_POST['somed']);
            $no1 = $_POST['no1'];
            $regno = $state.$no.$somed.$no1;
            $conn = open_conn();
            $sql = "SELECT * FROM vehicle_details where reg_no = '$regno'";
            $result = $conn->query($sql);
            if($result){
                //styling this is required
                $row = $result->fetch_assoc();
                echo("<table cellspacing = \"2\" cellpadding = \"2\">
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
                        <tr>
                            <td>".$row['reg_no']."</td>
                            <td>".$row['reg_date']."</td>
                            <td>".$row['chassis_no']."</td>
                            <td>".$row['engine_no']."</td>
                            <td>".$row['aadhar_no']."</td>
                            <td>".$row['vehicle_class']."</td>
                            <td>".$row['fuel']."</td>
                            <td>".$row['model']."</td>
                            <td>".$row['regn_upto']."</td>
                            <td>".$row['mv_tax_upto']."</td>
                            <td>".$row['insurance_upto']."</td>
                            <td>".$row['pucc_upto']."</td>
                            <td>".$row['emission_norms']."</td>
                            <td>".$row['rc_status']."</td>
                        </tr>");
            }
            else {
                echo("the query is not working");
            }
        }
    }
?>
    <button id="back">Back</button>
    <script type="text/javascript">
        document.getElementById("back").onclick = function () {
            location.href = "/trfperson.php";
        };
    </script>
</body>
</html>