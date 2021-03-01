<?php

    $serverName = "localhost";
    $username = "root";
    $password = "";
    $name = "disc";

    $dbConn = mysqli_connect($serverName, $username, $password, $name);
    
    if(!$dbConn){
        die('Nem sikerült csatlakozni az adatbázishoz: ' . mysql_error());
    }

    header("Content-Type:text/html;charset=utf-8");
    mysqli_query($dbConn, "set names utf8");


?>