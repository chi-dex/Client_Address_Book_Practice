<?php
    $server = "localhost";
    $username ="root";
    $password = "";
    $db = "db_clientaddressbook";

    $conn = mysqli_connect( $server, $username, $password, $db);

    //check
    if(!$conn){
        echo die("connection failed: ".mysqli_connect_error());
    }

?>