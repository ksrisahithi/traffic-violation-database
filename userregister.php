<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/title.css">
    <link rel="stylesheet" href="css/userregister.css">
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <title>TRVMS User Registeration</title>
</head>
<body>
<header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>User Register</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="userlogin.php" class="nav-btn">Back</a>
        </div>
    </header>
<div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form name="registerform" action="userregister.php" onsubmit = "return validation()" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">REGISTER</legend>
                        <label for="aadharno" class="form-label">AADHAR NUMBER:</label><br>
                            <input type="number" name="aadharno" id="aadharno" class="form-control"><br>
                        <label for="name" class="form-label">NAME</label><br>
                            <input type="text" name="name" id="name" class="form-control"><br>
                        <label for="pwd" class="form-label">PASSWORD</label><br>
                            <input type="password" name="pwd" id="pwd" class="form-control"><br>
                            <input type="checkbox" onclick="showPassword('pwd')">Show Password<br>
                        <label for="cnfpwd" class="form-label">CONFIRM PASSWORD</label><br>
                            <input type="password" name="cnfpwd" id="cnfpwd" class="form-control"><br>
                            <input type="checkbox" onclick="showPassword('cnfpwd')">Show Password<br>
                        <div id="submit-wrapper"><input type="submit" name= "register" id = "register" value="Register" class="btn"></div>
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
    session_start();
    ob_start();
    include "connection.php";
    ob_end_clean();

    function  aadhar($aadharno){
        if($string = ""){
            return;
        }
        else{
            $temp = $aadharno;
            $temp = strval($temp);
            $temp = str_replace(" ", "", $temp);
            return $temp;
        }
    }

    if(isset($_POST['register'])){
        if(!empty($_POST['aadharno'])){
            if (!preg_match ("/(^[0-9]{4}[0-9]{4}[0-9]{4}$)|(^[0-9]{4}\s[0-9]{4}\s[0-9]{4}$)/", aadhar($_POST['aadharno'])) ){  
                echo("<script>alert('Enter the valid aadhar number (12 digits)')</script>");
                session_destroy();  
            } else {  
                $aadharno = aadhar($_POST['aadharno']);
                if(!empty($_POST['name'])){
                    if (!preg_match ("/^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$/", $_POST['name'])) {  
                        $ErrMsg = "Only alphabets and whitespace are allowed.";  
                        echo($ErrMsg);  
                        session_destroy();
                    } else {  
                        $name = $_POST['name'];

                        if($aadharno && $name){
                            if(!empty($_POST['pwd']) && !empty($_POST['cnfpwd'])){
                                $pwd = $_POST['pwd'];
                                $cnfpwd = $_POST['cnfpwd'];
                                $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT);
                                $hash_cnfpwd = password_hash($cnfpwd, PASSWORD_BCRYPT);
                                if(password_verify($pwd, $hash_pwd) === password_verify($cnfpwd, $hash_pwd)){
                                    echo("the passwords match<br>");
                                    $conn = open_conn();
                                    $sql = "INSERT INTO user VALUES('$aadharno', '$hash_pwd', '$name')";
                                    $result = $conn->query($sql);
                                    if($result){
                                        $_SESSION['is_login'] = true;
                                        $_SESSION['name'] = $name;
                                        $_SESSION['aadharno'] = $aadharno;
                                        header("Location: user.php");
                                    }
                                    else{
                                        echo("the query didnt work<br>");
                                        echo($conn->error);
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
                    } 
                }
            } 
        }
    }
?>