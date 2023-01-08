<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usrlogin.css">
    <script src="https://kit.fontawesome.com/2182b01a00.js" crossorigin="anonymous"></script>
    <title>TRVMS USER LOGIN</title>
</head>
<body>
    <header>
        <a href="index.php"><img src="/assests/logo.png" alt="Logo" id="logo"></a>
        <div id="links">
            <a href="#" class="nav-btn">About</a>
            <a href="#" class="nav-btn">Source Code</a>
        </div>
    </header>
    <div id="content">
        <div id="form-box">
            <h1>Hi! Welcome back</h1>
            <form name="loginform" action="userlogin.php" onsubmit = "return validation()" method="post">
                <label for="aadharno">Aadhar Number</label><br>
                <div class="input-box">
                    <input type="text" name="aadharno" id="aadharno">
                </div>
                <label for="pwd">Password</label><br>
                <div class="input-box">
                    <input type="password" name="pwd" id="pwd">
                </div>
                <div class="input-box">
                    <input type="submit" name= "submit" id = "submit" value="Login">
                </div>
                <p id="sign-up">Don't have an account? <a href = "userregister.php">Sign Up</a></p>
            </form>
        </div>
        <img src="assests/6387974.jpg" alt="" id="img-box">
    </div>
    <a href="index.php" id="back2index"> Back To Landing Page</a>
</body>
</html>
<?php
    ob_start();
    include "connection.php";
    include "formvalidations.php";
    ob_end_clean();

    if(isset($_POST['submit'])){
        $aadharno = aadhar($_POST['aadharno']);
        $pwd = $_POST['pwd'];
        if(!empty($aadharno) && !empty($pwd)){
            $conn = open_conn();
            $sql = "SELECT * FROM user where aadhar_no = '$aadharno'";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                session_start();
                echo("the query worked<br>");
                $row = $result->fetch_assoc();
                if($aadharno === $row['aadhar_no'] && password_verify($pwd, $row['passwd'])){                    
                    //echo("there is the user<br>");
                    $_SESSION['is_login'] = true;
                    $_SESSION['aadhar_no'] = $row['aadhar_no'];
                    $_SESSION['legal_name'] = $row['legal_name'];
                    //echo("the fetching did work");
                    //echo($_SESSION['aadhar_no']);
                    header("Location: user.php");
                }
                else{
                    echo("the user dont exist<br>");
                    echo("register as a new user");
                }
            }
            else{
                echo("the query dont work<br>");
            }
        }
        else{
            echo("enter the fields");
        }
    }
?>