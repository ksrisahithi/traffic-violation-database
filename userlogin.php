<?php //user login page
    echo("<h1>user login</h1>");
    echo("<br>");   
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
    <title>TRVMS USER LOGIN</title>
</head>
<body>
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form name="loginform" action="userlogin.php" onsubmit = "return validation()" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">LOGIN</legend>
                        <label for="aadharno" class="form-label">AADHAR NUMBER:</label><br>
                        <input type="text" name="aadharno" id="aadharno" class="form-control"><br>
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
            var id = document.forms["loginform"]["aadharno"].value;
            if(!/^[0-9]+$/.test(id)){
                alert("enter a valid aadhar number");
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
        $aadharno = $_POST['aadharno'];
        $aadharno = trim($aadharno);
        $pwd = $_POST['pwd'];
        if(!empty($aadharno) && !empty($pwd)){
            $conn= open_conn();
            $sql = "SELECT * FROM user WHERE aadhar_no = $aadharno AND passwd = '$pwd'";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                echo("the query is working");
            }
            else{
                echo("the query is not working");
            }
        }
        else{
            echo("enter the details");
        }
    }
?>