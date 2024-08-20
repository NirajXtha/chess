<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chess";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    date_default_timezone_set('Asia/Kathmandu');

    function tokenGenerator(){
        $token = bin2hex(random_bytes(16));
        return $token;
    }
?>