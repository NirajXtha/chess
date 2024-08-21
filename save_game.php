<?php
    include('config/db.php');

    if($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST['id']) AND isset($_POST['type']) AND isset($_POST['status']) AND isset($_POST['level'])) {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $status = $_POST['status'];
        $level = $_POST['level'];
        $date = date('Y-m-d');
        $query = mysqli_query($conn, "INSERT INTO `profile` (`id`, `status`, `type`, `played_at`, `level`) VALUES('$id', '$status', '$type', '$date', '$level')");

        mysqli_close($conn);
    }
?>