<?php


session_start();
include "db_conn.php";
if (isset($_POST['default_semester'])) {

    $semester = mysqli_real_escape_string($conn, $_POST['default_semester']);

    $resetQuery = "UPDATE semester SET dfault = 0";
    $conn->query($resetQuery);

    $updateQuery = "UPDATE semester SET dfault = 1 WHERE semester = '$semester'";
    $conn->query($updateQuery);

    header("Location: ../admin-academic-settings.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>