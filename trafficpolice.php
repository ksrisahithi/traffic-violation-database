<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Police</title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size:12px;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        echo("<h3>TRAFFIC POLICE<br>");
        ob_start();
        include "connection.php";
        ob_end_clean();
        if(!isset($_SESSION['id'])){
            header("Location: trflogin.php");
            die();
        }
        $conn = open_conn();
        $sql = "SELECT * FROM traffic_police";
        $result = $conn->query($sql);
    ?>
    <table cellspacing = "2" cellpadding = "2">
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>DESIGNATION</th>
            <th>ZONE</th>
        </tr>
        <?php
            if($result){
                while($row = $result->fetch_assoc()){
                    echo("<tr>");
                    echo("<td>".$row['id']."</td>");
                    echo("<td>".$row['name']."</td>");
                    echo("<td>".$row['designation']."</td>");
                    echo("<td>".$row['zone_']."</td>");
                }
                $result->free();
            }
        ?>
    </table>

    <button id="back">Back</button><br><br>
    <script type="text/javascript">
        document.getElementById("back").onclick = function () {
            location.href = "/trfperson.php";
        };
    </script>
    <button id="trfreg" class="float-left submit-button" >add traffic person</button><br><br>
    <script type="text/javascript">
        document.getElementById("trfreg").onclick = function () {
            location.href = "/trfregister.php";
        };
    </script>
</body>
</html>