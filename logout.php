<?php
    session_start();
    include 'config/db.php';
    $user_id = $_SESSION['user_id'];
    $sql = mysqli_query($conn, "UPDATE users SET online = '0', token = NULL WHERE id = '$user_id'");
    session_destroy();
    header('Location: index.php');
?>