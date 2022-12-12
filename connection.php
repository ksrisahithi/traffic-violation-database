<?php
    // database connection file
    function open_conn(){
        $servername = "localhost";
        $username = "root"; // put your user name for the db server
        $password = "mohammed"; // put your password
        $db = "traffic_violation";
  
        $conn = new mysqli($servername, $username, $password, $db) or die("connection failed %s\n".$conn->error);
        return $conn;
    }
    
    function close_conn($conn){
        $conn->close();
    }
    //echo("<h1>you are at the php file that has the database connection THIS SHOULDNT BE SHOWN AT THE INDEX PAGE THO, nvm it works<h1>");
?>