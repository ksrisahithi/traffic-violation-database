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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/addpplwhoviolated.css">
    <link rel="stylesheet" href="css/title.css">
    <title>add people who violated</title>
</head>
<body>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>Add people who violated</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="trfperson.php" class="nav-btn">Back</a>
        </div>
    </header>
<div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form name="registerform" action="addpplwhoviolated.php" onsubmit = "return validation()" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">ADD</legend>
                        <label for="traffic_tkt_no" class="form-label">TICKET NO:</label><br>
                            <input type="number" name="traffic_tkt_no" id="traffic_tkt_no" class="form-control"><br>
                        <label for="reg_no" class="form-label">REGISTER NO:</label><br>
                            <input type="text" name = "state" id = "state" class="veh-no">
                            <input type="text" name="no" id = "no" class="veh-no">
                            <input type="text" name="somed" id = "somed" class="veh-no">
                            <input type="text" name="no1" id= "no1"class="veh-no"><br><br>
                        <label for="violation_id" class="form-label">VIOLATION ID:</label><br>
                            <input type="number" name="violation_id" id="violation_id" class="form-control" maxlength = 3><br>
                        <label for="traffic_polic_id" class="form-label">ENTER YOUR ID (TRAFFIC POLICE):</label><br>
                            <input type="number" name="traffic_polic_id" id="traffic_polic_id" class="form-control"><br>
                        <label for="due" class="form-label">ISSUE A DUE DATE</label><br>
                            <input type="date" name="due" id="due" class="form-control"><br>
                        <label for="date_of_violation" class="form-label">DATE OF VIOLATION RECORDED</label><br>
                            <input type="date" name="date_of_violation" id="date_of_violation" class="form-control"><br>
                        <div id="submit-wrapper"><input type="submit" name= "submit" id = "submit" value="submit"></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script src="js/regno.js"></script>
</body>
</html>
<?php
    if(isset($_POST['submit'])){
        if(!empty($_POST['traffic_tkt_no'])){
            if(id_validation($_POST['traffic_tkt_no'])){
                $traffic_tkt_no = $_POST['traffic_tkt_no'];

                if(empty($_POST['state']) && empty($_POST['no']) && empty($_POST['somed']) && empty($_POST['no1']) && !is_int($_POST['no']) && !is_int($_POST['no1'])) {
                    echo("<script>alert('enter the valid registration number')</script>");
                }
                else {
                    $state = strtolower($_POST['state']);
                    $no = $_POST['no'];
                    $somed = strtolower($_POST['somed']);
                    $no1 = $_POST['no1'];
                    $regno = strval($state.$no.$somed.$no1);

                    if(!empty($_POST['violation_id'])){
                        if(id_validation($_POST['violation_id'])){
                            $violation_id = $_POST['violation_id'];

                            if(!empty($_POST['traffic_polic_id'])){
                                if(id_validation($_POST['traffic_polic_id'])){
                                    $traffic_polic_id = $_POST['traffic_polic_id'];

                                    if(!empty($_POST['due'])){
                                        $due = $_POST['due'];

                                        if(!empty($_POST['date_of_violation'])){
                                            $date_of_violation = $_POST['date_of_violation'];


                                            $conn = open_conn();
                                            $sql = "INSERT INTO ppl_who_violated VALUES($traffic_tkt_no, '$regno', $violation_id, $traffic_polic_id, '$due', '$date_of_violation',0)";
                                            $result = $conn->query($sql);
                                            if($result){
                                                echo("<script>
                                                    alert('you have added the person into the violations table!!');
                                                    window.location.href = 'trfperson.php';
                                                </script>");
                                            }
                                            else{
                                                echo("error");
                                                echo($conn->error);
                                            }
                                        }
                                        else{
                                            echo("<script>alert('dont leave the date of violation empty')</script>");
                                        }
                                    }
                                    else{
                                        echo("<script>alert('dont leave the date field empty')</script>");
                                    }
                                }
                                else{
                                    echo("<script>alert('enter the valid traffic police id')</script>");
                                }
                            }
                            else{
                                echo("<script>alert('dont leave the traffic id field empty')</script>");
                            }
                        }
                        else{
                            echo("<script>alert('enter the valid violation id')</script>");
                        }
                    }
                    else{
                        echo("<script>alert('enter the valid violation id')</script>");
                    }
                }
            }
            else{
                echo("<script>alert('invalid ticket number')</script>");
            }         
        }
        else {
            echo("<script>alert('enter a valid ticket number')</script>");
        }
    }
?>