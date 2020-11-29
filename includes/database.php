<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Database credentials
 *
 */
    $servername = ''; // enter server ip address (example: 127.0.0.1)
    $username = ''; // enter database usernmame (example: myUsername)
    $password = ''; // enter database password (example: 1234_!@$pw)
    $database = ''; // enter name of database (example: myDatabase)

    $conn = new mysqli($servername, $username, $password, $database);

    if($conn->connect_errno)
    {
        echo "Error: ".$conn->connect_error;
        exit();
    }