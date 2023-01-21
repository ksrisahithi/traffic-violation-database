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
    <link rel="stylesheet" href="css/title.css">
    <link rel="stylesheet" href="css/user.css">
    <script src="https://kit.fontawesome.com/2182b01a00.js" crossorigin="anonymous"></script>
    <title>USER Dashboard</title>
</head>
<body>
    <script>
        function openForm(field) {
            document.getElementById(field).style.display = "block";
        }

        function closeForm(field) {
            document.getElementById(field).style.display = "none";
        }
        function cancelPay() {
            document.getElementById('payFineBtn').setAttribute('onclick', "openForm('finepay')");
            closeForm('vioDetails');
            closeForm('flexHor');
        }
        function cancelView() {
            document.getElementById('viewMyViolations').setAttribute('onclick', "openForm('passwordauth')");
            closeForm('viewVioDetails');
        }
    </script>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>User Dashboard</h1>
        </div>
        <div class="whitespace"></div>
        <div class="dets">
            <p><span class="thin">Name : </span><span class="thick"><?php echo($_SESSION['legal_name']);?></span></p>
            <p><span class="thin">Aadhar : </span><span class="thick"><?php echo($_SESSION['aadhar_no']);?></span></p>
        </div>
        <div id="links">
            <a href="trflogout.php" class="nav-btn">logout</a>
        </div>
    </header>
    <?php
        $aadhar_no = $_SESSION['aadhar_no'];
        $showDivFlag=false;
    ?>
    <div id="userDetails">
        <div id="userMsg">
            <i class="fa-solid fa-circle-exclamation fa-xl" id="icon"></i>
            <p id="uMsg"></p>
        </div>
        <div id="payFineBtn" class="btn" onclick='openForm("finepay")'>Pay fine</div>
        <div class="form-popup" id="finepay">
            <form action="" method="post" class="form-container">
                <h3>Enter the Ticket Number of the Violation</h3>
                <br>
                <label for="ticket_no"><b>Ticket No: </b></label>
                <input type="text" placeholder="Enter the ticket number" class="input-box" name="ticket_no" required>

                <input type="submit" name="submit1" id="submit1" class="button" value="submit"><br><br>
                <div class="grayBtn" onclick="closeForm('finepay')">Close</div>
            </form>
        </div>
        <div id="vioDetails"></div>
        <div id="flexHor">
            <div id="proceedToPayBtn" class="grayBtn" onclick='openForm("passwordauth2")'>Proceed to pay</div>
            <div id="cancelPay" onclick="cancelPay()" class="grayBtn">Cancel</div>
        </div>
        <div class="form-popup" id="passwordauth2">
            <form action="" method="post" class="form-container">
                <h3>Enter your password for further authentication</h3><br>

                <label for="pwd"><b>Password: </b></label>
                <input type="password" placeholder="Enter Password" class="input-box" name="pwd" required>

                <input type="submit" name="submit2" id="submit2" class="button" value="submit"><br><br>
                <div class="grayBtn" onclick="closeForm('passwordauth2')">Close</div>
            </form>
        </div>
        <div id="viewMyViolations" class="btn" onclick='openForm("passwordauth")'>View my violations</div>
        <div class="form-popup" id="passwordauth">
            <form action="" method="post" class="form-container">
                <h3>Enter your password for authentication</h3>
                <br>
                <label for="password"><b>Password: </b></label>
                <input type="password" placeholder="Enter Password" class="input-box" name="password" required>

                <input type="submit" name="submit" id="submit" class="button" value="submit"><br><br>
                <div class="grayBtn" onclick="closeForm('passwordauth')">Close</div>
            </form>
        </div>
        <div id="viewVioDetails">
            <h3>These are the violations that you have committed.</h3>
            <table id="vvdTable">
                <tr>
                    <th>Ticket No</th>
                    <th>Violation ID</th>
                    <th>Violation Name</th>
                    <th>Fine</th>
                </tr>
            </table>
            <p>The total fine that has to be paid is: Rs.<span id="fineSum"></span>/-</p><br>
            <div class="grayBtn" onclick="cancelView()">Close</div>
            
        </div>
        <div id="payMessages"></div>
        <div id = "viewViolations" class="btn">View all the traffic violations</div>
        <script type="text/javascript">
            document.getElementById("viewViolations").onclick = function(){
                location.href = "violation.php";
            }
        </script>
    </div>
    
    <?php
        $conn = open_conn();
        $sql = "SELECT aadhar_no from vehicle_details v JOIN ppl_who_violated p on p.reg_no = v.reg_no and p.pay_status = 0 WHERE aadhar_no = $aadhar_no;";
        $result = $conn->query($sql);
        if($result){
            echo("<script>document.getElementById('uMsg').innerHTML = 'You have been booked for the violations<br>Click below to pay the fine'</script>");
            $showDivFlag=true;
        }
        else{
            echo("<script>document.getElementById('uMsg').innerHTML = 'You have not been booked for any violations';closeForm('viewMyViolations');closeForm('passwordauth');</script>");
        }


        if(isset($_POST['submit'])){
            if(!empty($_POST['password'])){
                $password = $_POST['password'];
                $conn = open_conn();
                $sql = "SELECT * FROM user WHERE aadhar_no = $aadhar_no";
                $result = $conn->query($sql);
                if($result->num_rows === 1){
                    $row = $result->fetch_assoc();
                    if(password_verify($password, $row['passwd'])){
                        echo("<script>document.getElementById('viewMyViolations').removeAttribute('onclick')</script>");
                        $sql = "SELECT p.traffic_tkt_no, p.violation_id, violation_name, fine 
                        from violation v, ppl_who_violated p 
                        where v.violation_id = p.violation_id 
                        and p.reg_no = (select reg_no 
                                        from vehicle_details d 
                                        WHERE d.aadhar_no = $aadhar_no)
                        and p.pay_status = 0;";
                        $res = $conn->query($sql);
                        if($res->num_rows > 0){
                            echo("<script>openForm('viewVioDetails')</script>");
                            $fineSum = 0;
                            while($row = $res->fetch_assoc()){
                                $fineSum += $row['fine'];
                                echo("
                                    <script>
                                        let row = document.getElementById('vvdTable').insertRow(-1);
                                        row.insertCell(0).innerHTML = '".$row['traffic_tkt_no']."';
                                        row.insertCell(1).innerHTML = '".$row['violation_id']."';
                                        row.insertCell(2).innerHTML = '".$row['violation_name']."';
                                        row.insertCell(3).innerHTML = '".$row['fine']."';
                                    </script>
                                ");
                            }
                            echo("<br>");
                            echo("<script>document.getElementById('fineSum').innerText = '".$fineSum."'</script>");
                        }
                    }
                    else{
                        echo("<script>alert('Password not matched.')</script>");
                    }
                }
                else{
                    echo("the details that you have entered are not valid");
                }            
            }
        }

        if ($showDivFlag===false) {
            echo("<script>closeForm('payFineBtn');closeForm('finepay');</script>");
            echo("<script>document.getElementById('userMsg').style.border = 'none';document.getElementById('icon').style.display = 'none';</script>");
        }

        $procPay = false;
        if(isset($_POST['submit1'])){
            if(id_validation($_POST['ticket_no'])){
                $ticket_no = $_POST['ticket_no'];
                $_SESSION['ticket_no'] = $ticket_no;
            }
            echo("<script>document.getElementById('payFineBtn').removeAttribute('onclick');</script>");
            $conn = open_conn();
            $sql = "SELECT * FROM ppl_who_violated WHERE traffic_tkt_no = $ticket_no";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                if($row['pay_status'] == false && (strtotime(date('Y-m-d')) <= strtotime($row['due']))){
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

                        $msg = "You have to pay ".$fine."/- Your violation ".$violation.". Your ticket no: ".$ticket_no;
                        echo("<script>document.getElementById('vioDetails').innerHTML = '".$msg."'</script>");
                    }
                }
                else{
                    echo("<script>document.getElementById('payMessages').innerHTML = 'The fine with ticket no:".$ticket_no." is already paid'</script>");
                }
            }
            else{
                echo("<script>alert('Invalid ticket number.');cancelPay()</script>");
            }
        }

        if ($procPay===false) {
            echo("<script>closeForm('flexHor');closeForm('passwordauth2')</script>");
        }
    
        if(isset($_POST['submit2'])){
            $password = $_POST['pwd'];
            $ticket_no = $_SESSION['ticket_no'];
            $conn = open_conn();
            $sql = "SELECT * FROM user WHERE aadhar_no = $aadhar_no";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['passwd'])){
                    $sql = "UPDATE ppl_who_violated
                            SET pay_status = 1
                            WHERE traffic_tkt_no = $ticket_no";
                    $res = $conn->query($sql);
                    if($res){
                        echo("<script>document.getElementById('payMessages').innerHTML = 'You have successfully paid the fine.'</script>");
                    }
                }
                else{
                    echo("reenter the password");
                }
            }
        }
    ?>
</body>
</html>