<?php 
    ob_start();
    session_start();
    require "connection.php";
    ob_end_clean();
    if(!isset($_SESSION['id'])){
        header('Location: trflogin.php');
        die();
    }
?>
<html>
    <title>People's violation</title>
    <head>
    </head>
    <body>
    <form action = "pplwhoviolated.php" method = 'POST'>
    <input type="submit" name="view" value="VIEW ppl who violated"/><br><br>
    <?php  
        if(isset($_POST['view'])){
            $conn = open_conn();
            //revise the query
            $sql = "SELECT p.traffic_tkt_no, p.reg_no, p.violation_id, q.violation_name FROM ppl_who_violated p, violation q WHERE p.violation_id = q.violation_id";
            $result = $conn->query($sql);
            if($result){
                //too much time for making that stuff get displayed
                echo("if the query works<br>");
            }
            else{
                echo($conn->error."<br>");
            }
            close_conn($conn);
        }
    ?>
    <input type = "submit" name = "add" value = "ADD ppl who violated"/><br><br>
    <?php
        if(isset($_POST['add'])){
            //create a form and include the required fields for ppl who violated table
            //initialize them into php and then execute a query for inserting all those initialized value into the table
            //should also work on the sorting of this list and stuff but for now this much is enough ig
            echo("this button works<br>");
        }
    ?>
    <input type = "submit" name = "rm" value = "REMOVE ppl who violated"/><br><br>
    <?php
        if(isset($_POST['rm'])){
            //this should just include the register number or some primary key initialization and then
            //its just removing nothing much
            echo("this button also works<br>");
        }
    ?>
    </form>
    <button id="back">Back</button>
    <script type="text/javascript">
        document.getElementById("back").onclick = function () {
            location.href = "/trfperson.php";
        };
    </script>
    </body>
</html>