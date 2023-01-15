<?php
    ob_start();
    session_start();
    require "connection.php";
    include "formvalidations.php";
    ob_end_clean();
    if(!isset($_SESSION['aadhar_no'])){
        header("Location: userlogin.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER Dashboard</title>
</head>
<body>
    <button id = "view" class="float-left submit-button">view all the traffic violations</button><br><br>
    <script type="text/javascript">
        document.getElementById("view").onclick = function(){
            location.href = "/violation.php";
        }
    </script>
    <?php
    $aadhar_no = $_SESSION['aadhar_no'];
    $showDivFlag=false;
    echo("hi ".$_SESSION['legal_name']."<br>");
    echo($aadhar_no);
    $conn = open_conn();
    $sql = "SELECT aadhar_no from vehicle_details v JOIN ppl_who_violated p on p.reg_no = v.reg_no and p.pay_status = 0 WHERE aadhar_no = $aadhar_no;";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        echo("<br>you have been booked for the violations<br>");
        echo("click here to pay the fine<br>");
        $showDivFlag=true;
    }
    else{
        echo("<br>you have not been booked for violations");
    }
    ?><br>
    
    <button class='open-button' <?php if ($showDivFlag===false){?>style="display:none"<?php } ?> onclick='openForm("passwordauth")'>view my violations</button><br><br>

    <div class="form-popup" <?php if ($showDivFlag===false){?>style="display:none"<?php } ?> id="passwordauth">
        <form action="" method="post" class="form-container">
            <h3>enter your password for authentication</h3>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <input type="submit" name="submit" id="submit" class="button" value="submit">
            <button type="button" class="btn cancel" onclick="closeForm('passwordauth')">Close</button>
        </form>
    </div>

    <!--password authentication for the user to view their violations
        and also their violations are displayed, gotta work on this some more-->
    <?php
    if(isset($_POST['submit'])){
        if(!empty($_POST['password'])){
            $password = $_POST['password'];
            $conn = open_conn();
            $sql = "SELECT * FROM user WHERE aadhar_no = $aadhar_no";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['passwd'])){
                    echo("you are authenticated<br>");
                    echo("these are the violations that you have committed<br>");
                    echo("in the order ticket no|| violation id|| violation name|| fine<br>");
                    $sql = "SELECT p.traffic_tkt_no, p.violation_id, violation_name, fine 
                    from violation v, ppl_who_violated p 
                    where v.violation_id = p.violation_id 
                    and p.reg_no = (select reg_no 
                                    from vehicle_details d 
                                    WHERE d.aadhar_no = $aadhar_no)
                    and p.pay_status = 0;";
                    $res = $conn->query($sql);
                    if($res->num_rows > 0){
                        while($row = $res->fetch_assoc()){
                            echo("<tr>
                                <td>".$row['traffic_tkt_no']."</td>
                                <td>".$row['violation_id']."</td>
                                <td>".$row['violation_name']."</td>
                                <td>".$row['fine']."</td>
                                </tr><br>");                                
                        }
                        echo("<br>");
                        //echo("the total fine that has to be paid is: "$row['SUM(fine)']);
                    }
                }
                else{
                    echo("reenter the password");
                }
            }
            else{
                echo("the details that you have entered are not valid");
            }            
        }
    }
    ?>
    <button class='open-button' <?php if ($showDivFlag===false){?>style="display:none"<?php } ?> onclick='openForm("finepay")'>pay fine</button><br><br>
    <div class="form-popup" <?php if ($showDivFlag===false){?>style="display:none"<?php } ?> id="finepay">
        <form action="" method="post" class="form-container">
            <h3>enter the ticket number of the violation</h3>

            <label for="ticket_no"><b>ticket no:</b></label>
            <input type="text" placeholder="Enter the ticket number" name="ticket_no" required>

            <input type="submit" name="submit1" id="submit1" class="button" value="submit">
            <button type="button" class="btn cancel" onclick="closeForm('finepay')">Close</button>
        </form>
    </div>
    <?php
    $procPay = false;
    if(isset($_POST['submit1'])){
        if(id_validation($_POST['ticket_no'])){
            $ticket_no = $_POST['ticket_no'];
            $_SESSION['ticket_no'] = $ticket_no;
        }
        echo($ticket_no);
        $conn = open_conn();
        $sql = "SELECT * FROM ppl_who_violated WHERE traffic_tkt_no = $ticket_no";
        $result = $conn->query($sql);
        if($result->num_rows === 1){
            echo("the query works fine");
            $row = $result->fetch_assoc();
            if($row['pay_status'] == false && (strtotime(date('Y-m-d')) <= strtotime($row['due']))){
                echo("is there something happening that i dont know");
                $procPay = true;
                $sql = "SELECT ppl_who_violated.violation_id, violation_name, fine
                        FROM violation, ppl_who_violated 
                        WHERE ppl_who_violated.violation_id = violation.violation_id
                        AND ppl_who_violated.traffic_tkt_no = $ticket_no";
                $res = $conn->query($sql);
                if($res->num_rows === 1){
                    $r = $res->fetch_assoc();
                    $fine = $r['fine'];
                    $violation = $r['violation_name'];

                    echo("<br>you have to pay ".$fine."- your violation ".$violation.". your ticket no: ".$ticket_no."<br>");
                }
            }
            else{
                echo("testing");
            }
        }
        else{
            echo($conn->error);
        }
    }
    ?>
    <button class='open-button' <?php if ($procPay===false){?>style="display:none"<?php } ?> onclick='openForm("passwordauth2")'>proceed to pay</button><br><br>
    <div class="form-popup" <?php if ($procPay===false){?>style="display:none"<?php } ?> id="passwordauth2">
        <form action="" method="post" class="form-container">
            <h3>enter your password for further authentication</h3>

            <label for="pwd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" required>

            <input type="submit" name="submit2" id="submit2" class="button" value="submit">
            <button type="button" class="btn cancel" onclick="closeForm('passwordauth2')">Close</button>
        </form>
    </div>
    <?php
    if(isset($_POST['submit2'])){
        $password = $_POST['pwd'];
        $ticket_no = $_SESSION['ticket_no'];
        $conn = open_conn();
        $sql = "SELECT * FROM user WHERE aadhar_no = $aadhar_no";
        $result = $conn->query($sql);
        if($result->num_rows === 1){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['passwd'])){
                echo("you are authenticated<br>");
                echo("you have successfully paid the fine bro<br>");
                $sql = "UPDATE ppl_who_violated
                        SET pay_status = 1
                        WHERE traffic_tkt_no = $ticket_no";
                $res = $conn->query($sql);
                if($res){
                    echo("the table have been successfully updated!!<br>");
                }
            }
            else{
                echo("reenter the password");
            }
        }
    }
    ?>
    <a href = "trflogout.php">logout</a>
    <script>
        function openForm(field) {
            document.getElementById(field).style.display = "block";
        }

        function closeForm(field) {
            document.getElementById(field).style.display = "none";
        }
    </script>
    <style>
        .form-popup{
            display:none;
        }
    </style>
</body>
</html>