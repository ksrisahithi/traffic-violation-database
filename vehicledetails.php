<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/title.css">
    <link rel="stylesheet" href="css/vehicledetails.css">
    <title>Vehicles Details</title>
</head>
<body>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>View Vehicle Details</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="trfperson.php" class="nav-btn">Back</a>
        </div>
    </header>
    <div id="reg-box">
        <h3>Enter registration number</h3><br>
        <form action = "vehicledetails.php" method = "POST" name = "vehicledets">
            <input class="veh-no" type = "text" name = "state" id = "state" >
            <input class="veh-no" type="text" name="no" id = "no">
            <input class="veh-no" type="text" name="somed" id = "somed">
            <input class="veh-no" type="text" name="no1" id= "no1"><br><br>
            <input type="submit" name= "submit" id = "submit" value="submit">
        </form>
    </div>
    <div id="veh-details">
        <h3>Details of Vehicle No: <span id="vehno"></span></h3>
    </div>
    <script src="js/regno.js"></script>
</body>
</html>
<?php
    ob_start();
    include "connection.php";
    ob_end_clean();
    if(isset($_POST['submit'])){
        if(empty($_POST['state']) && empty($_POST['no']) && empty($_POST['somed']) && empty($_POST['no1']) && !is_int($_POST['no']) && !is_int($_POST['no1'])) {
            echo("<script>alert('Enter the valid details')</script>");;
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
            if($result -> num_rows > 0){
                echo("<script>document.getElementById('veh-details').style.display = 'block';</script>");
                $row = $result->fetch_assoc();
                echo("<script>document.getElementById('vehno').innerText = '".$row['reg_no']."'</script>");
                echo("<table id='details-table'>
                        <tr>
                            <td>Model: </td>
                            <td>".$row['model']."</td>
                        </tr>
                        <tr>
                            <td>Aadhar No. of owner: </td>
                            <td>".$row['aadhar_no']."</td>
                        </tr>
                        <tr>
                            <td>Registration date: </td>
                            <td>".$row['reg_date']."</td>
                        </tr>
                        <tr>
                            <td>Registration validity: </td>
                            <td>".$row['regn_upto']."</td>
                        </tr>
                        <tr>
                            <td>Vehicle class: </td>
                            <td>".$row['vehicle_class']."</td>
                        </tr>
                        <tr>
                            <td>Fuel type: </td>
                            <td>".$row['fuel']."</td>
                        </tr>
                        <tr>
                            <td>Chassis No: </td>
                            <td>".$row['chassis_no']."</td>
                        </tr>
                        <tr>
                            <td>Engine No: </td>
                            <td>".$row['engine_no']."</td>
                        </tr>
                        <tr>
                            <td>MV Tax validity: </td>
                            <td>".$row['mv_tax_upto']."</td>
                        </tr>
                        <tr>
                            <td>Insurance validity: </td>
                            <td>".$row['insurance_upto']."</td>
                        </tr>
                        <tr>
                            <td>PUCC validity: </td>
                            <td>".$row['pucc_upto']."</td>
                        </tr>
                        <tr>
                            <td>Emission norms: </td>
                            <td>".$row['emission_norms']."</td>
                        </tr>
                        <tr>
                            <td>RC Status: </td>
                            <td>".$row['rc_status']."</td>
                        </tr>");
            }
            else {
                echo("<script>alert('Registration number not found')</script>");
            }
        }
    }
?>