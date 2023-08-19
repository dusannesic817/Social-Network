<?php

    $server = "localhost";
    $database = "network";
    $username = "admin";
    $password = "gerrard817";


    $conn = new mysqli($server,$username,$password,$database);

    if($conn->connect_error){

       // header("location: error.php?m=" .$conn->connect_error);
        die("Connection problem:".$conn->connect_error);
    }

    $conn->set_charset("utf8");

?>