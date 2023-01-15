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
    //$show = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>remove people who violated</title>
</head>
<body>
    <h>*can only view the people who are in the pplwhoviolated table but have paid the fine only have to authenticate and then remove them from the table<br>
    <form action="rmpplwhoviolated.php" method="POST">
    <input type = "submit" name = "viewpay" value = "view people who have paid the fine"/><br><br>
    <?php
    if(isset($_POST['viewpay'])){
        echo("<h3>the people who have paid the thing and can be authorized to be removed from the table<br></h3>");
        $conn = open_conn();
        echo("<h>*and also the table is in this order->>> traffic ticket no || legal name || register number || violation committed<br>");

        $sql = "SELECT traffic_tkt_no, legal_name, ppl_who_violated.reg_no, violation_name
                FROM ppl_who_violated, user, vehicle_details, violation
                WHERE ppl_who_violated.pay_status = 1
                AND vehicle_details.aadhar_no = user.aadhar_no
                AND ppl_who_violated.violation_id = violation.violation_id
                AND ppl_who_violated.reg_no = vehicle_details.reg_no";
        $result = $conn->query($sql);
        if($result->num_rows > 0){                
            while($row = $result->fetch_assoc()){
                
                echo("
                    <table>
                    
                    <tr>
                        <td>".$row['traffic_tkt_no']."</td>
                        <td>".$row['legal_name']."</td>
                        <td>".$row['reg_no']."</td>
                        <td>".$row['violation_name']."</td>

                    </tr>
                    </table>
                    <br>"); 
            }
            //echo("something")
            //GOTTA MAKE THE DIV FOR THE ABOVE RESULT SO THAT THE BUTTON DOWN BELOW CAN BE USED EFFIECIENTLY AND IT WILL LOOK NICE
            echo("<button type=\"button\" class=\"btn cancel\" onclick=\"closeForm('rmpay')\">Close</button>");
            echo("<br>");            
        }
        else{
            // echo($conn->error);
            echo("no violations");
        }
    }
    ?>
    </form>
    <?php
    $show = false;
    // <?php if ($show===false){//?//>style="display:none"<?php }// ?//>
    ?>
    <button class='open-button' onclick='openForm("rmpay")'>remove the people from the violations</button><br><br>
    <div class="form-popup" id="rmpay">
        <form action="" method="post" class="form-container">
            <h3>enter the ticket number</h3>

            <label for="ticket_no"><b>ticket no</b></label>
            <input type="text" placeholder="Enter ticket no" name="ticket_no" required>

            <input type="submit" name="submit" id="submit" class="button" value="submit">
            <button type="button" class="btn cancel" onclick="closeForm('rmpay')">Close</button>
        </form>
    </div>
    <?php
    $show1 = false;
    if(isset($_POST['submit'])){
        if(!empty($_POST['ticket_no'])){
            //echo($_POST['ticket_no']);
            $ticket_no = $_POST['ticket_no'];
            $_SESSION['ticket_no'] = $ticket_no;
            $conn = open_conn();
            $sql = "SELECT *
                    FROM ppl_who_violated
                    WHERE traffic_tkt_no = $ticket_no";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                $show1 = true;
                echo("proceed for password verification<br>");
                //echo("n");
            }
        }
    }
    ?>
    <div class="form-popup" <?php if ($show1===false){?>style="display:none"<?php } ?> id="passwordauth2">
        <form action="" method="post" class="form-container">
            <h3>enter your password for further authentication</h3>

            <label for="pwd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" required>

            <input type="submit" name="submit2" id="submit2" class="button" value="submit">
            <button type="button" class="btn cancel" onclick="closeForm('passwordauth2')">Close</button>
        </form>
    </div>
    <?php
    $id = $_SESSION['id'];   
    if(isset($_POST['submit2'])){
        $ticket_no = $_SESSION['ticket_no'];
        if(!empty($_POST['pwd'])){
            $pwd = $_POST['pwd'];
            $conn = open_conn();
            $sql = "SELECT *
                    FROM traffic_police
                    WHERE id = $id";
            $result = $conn->query($sql);
            if($result->num_rows ===1){
                $row = $result->fetch_assoc();
                if(password_verify($pwd, $row['password'])){
                    $sql = "DELETE
                            FROM ppl_who_violated
                            WHERE traffic_tkt_no = $ticket_no";
                    $res = $conn->query($sql);
                    if($res){
                        echo("the table has been updated<br>");
                    }
                    else{
                        echo($conn->error);
                    }
                }
            }
        }
    }
    ?>

    <button id="back">Back</button>
    <script type="text/javascript">
        document.getElementById("back").onclick = function () {
            location.href = "/pplwhoviolated.php";
        };
    </script>
    <script>
        function openForm(field) {
            document.getElementById(field).style.display = "block";
        }

        function closeForm(field) {
            document.getElementById(field).style.display = "none";
        }
    </script>
<!--
    <style>
        .form-popup{
            display:none;
        }
    </style>
-->
</body>
</html>