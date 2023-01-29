<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/title.css">
    <link rel="stylesheet" href="css/trfregister.css">
    <title>TRVMS Traffic Police Registeration</title>
</head>
<body>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>Register Officer</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="trfperson.php" class="nav-btn">Back</a>
        </div>
    </header>
    <div id="reg-form-container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form name="registerform" action="trfregister.php" onsubmit = "return validation()" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">REGISTER</legend>
                        <label for="id" class="form-label">ID</label><br>
                            <input type="number" min="0" name="id" id="id" class="form-control"><br>
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
                            <input type="password" name="pwd" id="pwd" class="form-control">
                            <input type="checkbox" onclick="showPassword('pwd')">Show Password<br><br>
                        <label for="cnfpwd" class="form-label">CONFIRM PASSWORD</label><br>
                            <input type="password" name="cnfpwd" id="cnfpwd" class="form-control">
                            <input type="checkbox" onclick="showPassword('cnfpwd')">Show Password<br>
                        <div id="submit-wrapper"><input class="btn" type="submit" name= "submit" id = "submit" value="Submit"></div>
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
    include "formvalidations.php";
    ob_end_clean();
    
    if(isset($_POST['submit'])){
        //id validation
        if(!empty($_POST['id'])){
            if (!id_validation($_POST['id'])){  
                $ErrMsg = "Only numeric value is allowed for id.";  
                echo $ErrMsg;
                session_destroy();  
            } else {  
                $id = $_POST['id'];
            } 
        }
        else{
            echo("<script>alert('Id field can't be empty')</script>");
        }

        //name validation 
        if(!empty($_POST['name'])){
            if (!name_validation($_POST['name'])) {  
                $ErrMsg = "Only alphabets and whitespace are allowed.";  
                echo($ErrMsg);  
                session_destroy();
            } else {  
                $name = $_POST['name'];
                echo($name."<br>");
            } 
        }
        else{
            echo("<script>alert('Name field can't be empty')</script>");
        }

        //zone
        $zone_ = $_POST['zone'];

        //designation
        $desg = $_POST['desg'];

        //password validation
        if(!empty($_POST['id']) && !empty($_POST['name'])){
            if(!empty($_POST['pwd']) && !empty($_POST['cnfpwd'])){
                $pwd = $_POST['pwd'];
                $cnfpwd = $_POST['cnfpwd'];
                $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT);
                $hash_cnfpwd = password_hash($cnfpwd, PASSWORD_BCRYPT);

                if(password_verify($pwd, $hash_pwd) === password_verify($cnfpwd, $hash_pwd)){
                    echo("the passwords match<br>");
                    $conn = open_conn();
                    $sql = "INSERT INTO traffic_police VALUES($id, '$name', '$desg', '$zone_', '$hash_pwd')";
                    $result = $conn->query($sql);
                    if($result){
                        header("Location: trfperson.php");
                    }
                    else{
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
            echo("<script>alert('dont leave the id or name field empty')</script>");
        }
    }
?>