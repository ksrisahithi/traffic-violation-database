<?php //traffic polic login page
    echo("<h1>traffic login</h1>");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <!-- <link rel="stylesheet" href="css/trflogin.css"> -->
    <title>TRVMS TRAFFIC LOGIN</title>
</head>
<body>
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form name="loginform" action="trflogin.php" onsubmit = "return validation()" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">LOGIN</legend>
                        <label for="id" class="form-label">ID</label><br>
                        <input type="text" name="id" id="id" class="form-control"><br>
                        <label for="pwd" class="form-label">PASSWORD</label><br>
                        <input type="password" name="pwd" id="pwd" class="form-control"><br>
<!-- 
                        <label for="zone" class="form-label">Zone</label><br>
                        <select name="zone" id="zone" class="form-select">
                            <option value="north">NORTH</option>
                            <option value="south">SOUTH</option>
                            <option value="northeast">NORTHEAST</option>
                            <option value="southeast">SOUTHEAST</option>
                            <option value="west">WEST</option>
                            <option value="central">CENTRAL</option>
                        </select> <br>
-->
                        <input type="submit" name= "submit" id = "submit" value="submit">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script>
        function validation() {
            var id = document.forms["loginform"]["id"].value;
            if(!/^[0-9]+$/.test(id)){
                alert("enter a valid id number");
            }
        }
    </script>

    <button id="backtoindex">back to index</button>
    <script type="text/javascript">
        document.getElementById("backtoindex").onclick = function () {
            location.href = "/index.php";
        };
    </script>
</body>
</html>

<?php
    ob_start();
    include "connection.php";
    ob_end_clean();
    if(isset($_POST['submit'])){
        //echo("the submit button has been clicked");
        $id = $_POST['id'];
        $pwd = $_POST['pwd']; //<<<-----should work more on the password validation-----<<<
        //echo($id);
        //echo($pwd);
        if(!empty($id) && !empty($pwd)){
            //echo($id.$pwd);
            $conn = open_conn();
            $sql = "SELECT * FROM traffic_police WHERE id = $id AND password = '$pwd'";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                session_start();
                echo("the query is working");
                $row = $result->fetch_assoc();
                if($id === $row['id'] && $pwd <> $row['password']){
                    echo("the password is wrong");
                }
                elseif($id === $row['id'] && $pwd === $row['password']){
                    $_SESSION['is_login'] = true;
                    $_SESSION['id'] = $id;
                    $_SESSION['name'] = $row['name'];
                    header("Location: trfperson.php");
                }
            }
            else{
                echo("enter the valid details");
            }
        }
        else{
            echo("enter the details");
        }    
    }
?>