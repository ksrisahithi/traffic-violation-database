<?php
    ob_start();
    session_start();
    include "connection.php";
    include "formvalidations.php";
    ob_end_clean();
    if(!isset($_SESSION['id'])){
        header('Location: trflogin.php');
        die();
    }   
?>
<!-- 

    GOT TO MAKE THE STUFF LOOK VERY NEAT THEN ALL OF IT IS FINE

    >>>NEED TO FIND THE WAY OF AVOIDING JUST THROWING THE HTML RIGHT HERE IN THIS PHP FILE
       DOES NOT LOOK NEAT. TRIED THIS CODE DOWN BELOW BUT DOES NOT WORK!!!!!!
    >>>>

    if($_SERVER['DOCUMENT_ROOT'].'/assets/addppl.php' == true){
        echo("this works<br>");
    }
    else{
        echo("this does not work<br>");
    }
    //include(__DIR__.'/assets/addppl.php');
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    echo($base_dir);
    //echo(__FILE__);
    require_once("{$base_dir}assets{$ds}addppl.php");
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <title>add people who violated</title>
</head>
<body>

<div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form name="registerform" action="addpplwhoviolated.php" onsubmit = "return validation()" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">ADD</legend>
                        <label for="traffic_tkt_no" class="form-label">TICKET NO:</label><br>
                        <input type="text" name="traffic_tkt_no" id="traffic_tkt_no" class="form-control"><br>
                        <label for="reg_no" class="form-label">REGISTER NO:</label><br>
                            <input type="text" name = "state" id = "state" maxlength = "2" size = "2">
                            <input type="text" name="no" id = "no" maxlength = "2" size = "2">
                            <input type="text" name="somed" id = "somed" maxlength = "2" size = "2">
                            <input type="text" name="no1" id= "no1" maxlength = "4" size = "2"><br><br>
                        <label for="violation_id" class="form-label">VIOLATION ID:</label><br>
                        <input type="text" name="violation_id" id="violation_id" class="form-control" maxlength = 3><br>
                        <label for="traffic_polic_id" class="form-label">ENTER YOUR ID (TRAFFIC POLICE):</label><br>
                        <input type="text" name="traffic_polic_id" id="traffic_polic_id" class="form-control"><br>
                        <label for="due" class="form-label">ISSUE A DUE DATE</label><br>
                        <input type="date" name="due" id="due" class="form-control"><br>
                        <label for="date_of_violation" class="form-label">DATE OF VIOLATION RECORDED</label><br>
                        <input type="date" name="date_of_violation" id="date_of_violation" class="form-control"><br>
                        <label for="aadhar_no" class="form-label">ENTER THE AADHAR NO OF THE BOOKED:</label><br>
                        <input type="text" name="aadhar_no" id="aadhar_no" class="form-control"><br>
                        <input type="submit" name= "submit" id = "submit" value="submit">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    if(isset($_POST['submit'])){
        if(!empty($_POST['traffic_tkt_no'])){
            if(id_validation($_POST['traffic_tkt_no'])){
                $traffic_tkt_no = $_POST['traffic_tkt_no'];
                //echo($traffic_tkt_no);
            }
            else{
                echo("invalid ticket number<br>");
            }         
        }
        else {
            echo("enter a valid ticket number");
        }

        if(!empty($_POST['aadhar_no'])){
            if(aadhar_validation($_POST['aadhar_no'])){
                $aadhar_no = $_POST['aadhar_no'];
                //echo($aadhar_no);
            }
            else{
                echo("invalid aadhar number<br>");
            }
        }
        if(empty($_POST['state']) && empty($_POST['no']) && empty($_POST['somed']) && empty($_POST['no1']) && !is_int($_POST['no']) && !is_int($_POST['no1'])) {
            echo("enter the valid details");
        }
        else {
            $state = strtolower($_POST['state']);
            $no = $_POST['no'];
            $somed = strtolower($_POST['somed']);
            $no1 = $_POST['no1'];
            $regno = strval($state.$no.$somed.$no1);
            //echo($regno);
        }
        if(!empty($_POST['violation_id'])){
            if(id_validation($_POST['violation_id'])){
                $violation_id = $_POST['violation_id'];
                //echo($violation_id);
            }
            else{
                echo("enter valid violation id");
            }
        }
        else{
            echo("enter a valid violation id");
        }
        if(!empty($_POST['traffic_polic_id'])){
            if(id_validation($_POST['traffic_polic_id'])){
                $traffic_polic_id = $_POST['traffic_polic_id'];
               // echo($traffic_polic_id);
            }
            else{
                echo("enter valid id");
            }
        }
        else{
            echo("dont leave the traffic p id mt");
        }
        if(!empty($_POST['due'])){
            $due = $_POST['due'];
            //echo($due);
        }
        else{
            echo("dont leave the date field mt");
        }
        if(!empty($_POST['date_of_violation'])){
            $date_of_violation = $_POST['date_of_violation'];
            //echo($date_of_violation);
        }
        else{
            echo("dont leave the date of violation field empty");
        }
        $conn = open_conn();
        $sql = "INSERT INTO ppl_who_violated VALUES($traffic_tkt_no, '$regno', $violation_id, $traffic_polic_id, '$due', '$date_of_violation', $aadhar_no)";
        $result = $conn->query($sql);
        if($result){
            echo("<script>
                alert('you have added the person into the violations table!!');
                window.location.href = 'trfperson.php';
            </script>");
        }
        else{
            echo($conn->error);
        }
    }
?>