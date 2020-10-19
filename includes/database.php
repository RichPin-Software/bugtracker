<?php
    $servername = '127.0.0.1';
    $username = 'richpin';
    $password = 'n@tal13R0$_3';
    $database = 'richardpinegar';

    $conn = new mysqli($servername, $username, $password, $database);

    if($conn->connect_errno)
    {
        echo "Error: ".$conn->connect_error;
        exit();
    }