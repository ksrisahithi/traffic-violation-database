<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/trlogin.css">
    <title>TRVMS TRAFFIC LOGIN</title>
</head>
<body>
    <header>
        <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
        <div id="links">
            <a href="#" class="nav-btn">About</a>
            <a href="#" class="nav-btn">Source Code</a>
        </div>
    </header>
    <div id="content">
        <div id="form-box">
            <h1>Hi! Welcome back.</h1>
            <form name="loginform" action="trflogin.php" onsubmit = "return validation()" method="post">
                <label for="id">ID</label><br>
                <div class="input-box">
                    <input type="text" name="id" id="id">
                </div>
                <label for="pwd">PASSWORD</label><br>
                <div class="input-box">
                    <input type="password" name="pwd" id="pwd"> 
                </div>
                <div class="input-box">
                    <input type="submit" name= "submit" id = "submit" value="Login">
                </div>
            </form>
        </div>
        <img src="assests/7514770.jpg" alt="" id="img-box">
    </div>
    <a href="index.php" id="back2index">Back To Landing Page</a>


    <script>
        function validation() {
            var id = document.forms["loginform"]["id"].value;
            if(!/^[0-9]+$/.test(id)){
                alert("Enter a vaild ID");
            }
        }
    </script>
</body>
</html>

<?php
    ob_start();
    include "connection.php";
    ob_end_clean();
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $pwd = $_POST['pwd'];
        if(!empty($id) && !empty($pwd)){
            $conn = open_conn();
            $sql = "SELECT * FROM traffic_police WHERE id = $id";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                session_start();
                $row = $result->fetch_assoc();
                if($id === $row['id'] && password_verify($pwd, $row['password'])){
                    $_SESSION['is_login'] = true;
                    $_SESSION['id'] = $id;
                    $_SESSION['name'] = $row['name'];
                    header("Location: trfperson.php");
                }
                else{
                    echo("<script>alert('Wrong password')</script>");
                }
            }
            else{
                echo("<script>alert('The user doesn\'t exist.')</script>");
            }
        }
        else if (!empty($id)){
            echo("<script>alert('Enter the password')</script>");
        }
    }
?>