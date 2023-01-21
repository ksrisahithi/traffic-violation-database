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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/title.css">
    <link rel="stylesheet" href="css/rmpplwhoviolated.css">
    <title>Remove violations that are paid</title>
</head>
<body>
    <script>
        function openForm(field) {
            document.getElementById(field).style.display = "block";
        }
        function closeForm(field) {
            document.getElementById(field).style.display = "none";
        }
    </script>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>Remove violations that are paid</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="trfperson.php" class="nav-btn">Back</a>
        </div>
    </header>
    
    <div id="btn-container">
        <form action="rmpplwhoviolated.php" method="POST">
            <input class="btn" type = "submit" name = "viewpay" value = "view people who paid the fine"/><br>
            <small>*can only view the people who have paid the violation fine but not yet removed from the list.</small>
        </form>
        <div id="view-pay">
            <h3>the people who are eligble to be removed from the violation list</h3>
            <table id="vio-table">
                <tr>
                    <th>Traffic Ticket No</th>
                    <th>Name</th>
                    <th>Register No</th>
                    <th>Violation Committed</th>
                </tr>
            </table>
            <div id="close-btn" onclick="closeForm('view-pay')">Close</div>
        </div>
        <p id="no-view-pay"></p>
        <div class='btn' onclick='openForm("rmpay")'>remove the people from the violations</div>
        <div class="form-popup" id="rmpay">
            <form action="" method="post" class="form-container">
                <h3>enter the ticket number</h3>

                <label for="ticket_no"><b>ticket no</b></label>
                <input type="text" placeholder="Enter ticket no" name="ticket_no" required>

                <input type="submit" name="submit" id="submit" class="button" value="submit">
                <button type="button" class="cancel" onclick="closeForm('rmpay')">Close</button>
            </form>
        </div>
        <div id="passwordauth2">
            <form action="" method="post" class="form-container">
                <h3>enter your password for further authentication</h3>

                <label for="pwd"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pwd" required>

                <input type="submit" name="submit2" id="submit2" class="button" value="submit">
                <button type="button" class="cancel" onclick="closeForm('passwordauth2')">Close</button>
            </form>
        </div>
        <p id="delete-notice"></p>
    </div>
    
    <?php
        if(isset($_POST['viewpay'])){
            $conn = open_conn();

            $sql = "SELECT traffic_tkt_no, legal_name, ppl_who_violated.reg_no, violation_name
                    FROM ppl_who_violated, user, vehicle_details, violation
                    WHERE ppl_who_violated.pay_status = 1
                    AND vehicle_details.aadhar_no = user.aadhar_no
                    AND ppl_who_violated.violation_id = violation.violation_id
                    AND ppl_who_violated.reg_no = vehicle_details.reg_no";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                echo("<script>openForm('view-pay')</script>");
                while($row = $result->fetch_assoc()){
                    echo("<script>
                        let row = document.getElementById('vio-table').insertRow(-1);
                        row.insertCell(0).innerHTML = '".$row['traffic_tkt_no']."';
                        row.insertCell(1).innerHTML = '".$row['legal_name']."';
                        row.insertCell(2).innerHTML = '".$row['reg_no']."';
                        row.insertCell(3).innerHTML = '".$row['violation_name']."';
                    </script>");
                }
            }
            else{
                echo("<script>document.getElementById('no-view-pay').innerHTML = 'There are no violations that are paid.'</script>");
            }
        }

    $show1 = false;
    if(isset($_POST['submit'])){
        if(!empty($_POST['ticket_no'])){
            $ticket_no = $_POST['ticket_no'];
            $_SESSION['ticket_no'] = $ticket_no;
            $conn = open_conn();
            $sql = "SELECT *
                    FROM ppl_who_violated
                    WHERE traffic_tkt_no = $ticket_no
                    AND pay_status = 1";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                $show1 = true;
                echo("<script>openForm('passwordauth2')</script>");
            }
        }
    }

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
                            WHERE traffic_tkt_no = $ticket_no
                            AND pay_status = 1 ";
                    $res = $conn->query($sql);
                    if($res){
                        echo("<script>document.getElementById('delete-notice').innerHTML = 'the table has been updated.'</script>");
                    }
                    else{
                        echo($conn->error);
                    }
                }
            }
        }
    }
    ?>
</body>
</html>