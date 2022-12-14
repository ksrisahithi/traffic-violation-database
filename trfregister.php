<!-- THE TRAFFIC POLICEMAN REGISTER FORM (DATABASE WORKS!) -->
<!-- STILL NEED TO STYLE THE PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <title>TRVMS Traffic Police Registeration</title>
</head>
<body>

<div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form name="registerform" action="trfregister.php" onsubmit = "return validation()" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">REGISTER</legend>
                        <label for="id" class="form-label">ID</label><br>
                        <input type="text" name="id" id="id" class="form-control"><br>
                        <label for="name" class="form-label">NAME</label><br>
                        <input type="text" name="name" id="name" class="form-control"><br>
                        <label for="desg" class="form-label">DESIGNATION</label><br>
                        <select name="desg" id="desg" class="form-select">
                            <option value="asi">ASI</option>
                            <option value="psi">PSI</option>
                            <option value="pi">PI</option>
                            <option value="dgp">DGP</option>
                        </select> <br>
                        <label for="zone" class="form-label">ZONE</label><br>
                        <select name="zone" id="zone" class="form-select">
                            <option value="north">NORTH</option>
                            <option value="south">SOUTH</option>
                            <option value="northeast">NORTHEAST</option>
                            <option value="southeast">SOUTHEAST</option>
                            <option value="west">WEST</option>
                            <option value="central">CENTRAL</option>
                        </select> <br>
                        <label for="pwd" class="form-label">PASSWORD</label><br>
                        <input type="password" name="pwd" id="pwd" class="form-control"><br>
                        <input type="checkbox" onclick="showPassword('pwd')">Show Password<br>
                        <label for="cnfpwd" class="form-label">CONFIRM PASSWORD</label><br>
                        <input type="password" name="cnfpwd" id="cnfpwd" class="form-control"><br>
                        <input type="checkbox" onclick="showPassword('cnfpwd')">Show Password<br>
                        <input type="submit" name= "submit" id = "submit" value="submit">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script>
        function showPassword(pwd) {
            var x = document.forms["registerform"][pwd];
            if (x.type === "password") {
                x.type = "text";
            } else {
            x.type = "password";
            }
        }
    </script>

</body>
</html>
<?php
    ob_start();
    session_start();
    include "connection.php";
    ob_end_clean();
    
    if(isset($_POST['submit'])){
        //id validation
        if(!empty($_POST['id'])){
            if (!preg_match ("/^[0-9]*$/", $_POST['id']) ){  
                $ErrMsg = "Only numeric value is allowed for id.";  
                echo $ErrMsg;
                session_destroy();  
            } else {  
                $id = $_POST['id'];
                //echo($id."<br>"); 
            } 
        }
        else{
            echo("the id field cant be empty");
        }

        //name validation OK BRO THIS TING WORKS SOMEWHAT// BUT YOU CANNOT PUT FULL NAME WITH WHITESPACES
        if(!empty($_POST['name'])){
            if (!preg_match ("/^[a-zA-z]*$/", $_POST['name'])) {  
                $ErrMsg = "Only alphabets and whitespace are allowed.";  
                echo($ErrMsg);  
                session_destroy();
            } else {  
                $name = $_POST['name'];
                //$name = trim($name);
                //$name = stripslashes($name);
                //$name = htmlspecialchars($name);
                echo($name."<br>");
            } 
        }
        else{
            echo("the name field cant be empty");
        }

        //zone
        $zone_ = $_POST['zone'];
        //echo($zone_."<br>");
        //designation
        $desg = $_POST['desg'];

        //password validation
        if($id && $name){
            if(!empty($_POST['pwd']) && !empty($_POST['cnfpwd'])){
                $pwd = $_POST['pwd'];
                $cnfpwd = $_POST['cnfpwd'];
                $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT);
                $hash_cnfpwd = password_hash($cnfpwd, PASSWORD_BCRYPT);
                //echo($hash_pwd."<br>");
                //echo($hash_cnfpwd."<br>");
                if(password_verify($pwd, $hash_pwd) === password_verify($cnfpwd, $hash_pwd)){
                    echo("the passwords match<br>");
                    $conn = open_conn();
                    $sql = "INSERT INTO traffic_police VALUES($id, '$name', '$desg', '$zone_', '$hash_pwd')";
                    $result = $conn->query($sql);
                    if($result){
                        //echo("the thing works<br>");
                        $_SESSION['is_login'] = true;
                        $_SESSION['name'] = $name;
                        $_SESSION['id'] = $id;
                        header("Location: trfperson.php");
                    }
                    else{
                        //echo("the thing dont work<br>");
                         //<<<---- this should redirect, but it is not working----<<<<<
                        //exit;
                        //echo("<script type='text/javascript'>window.top.location='trfperson.php';</script>"); exit;
                        echo("the query didnt work<br>");
                    }
                }
                else{
                    echo("passwords dont match reenter again<br>");
                }
            }
            elseif(empty($_POST['pwd']) && !empty($_POST['cnfpwd'])){
                echo("enter the password field<br>");
                session_destroy();
            }
            elseif(!empty($_POST['pwd']) && empty($_POST['cnfpwd'])){
                echo("enter the confirm password field<br>");
                session_destroy();
            }
            else{
                echo("dont let the passwords field empty<br>");
                session_destroy();
            }
        }
        else{
            echo("dont leave the id or the name field empty<br>");
        }
    }
?>