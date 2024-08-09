<?php

session_start();
include "db_conn.php";
if (isset($_POST['default_school_year'])) {

    $school_year = mysqli_real_escape_string($conn, $_POST['default_school_year']);

    $resetQuery = "UPDATE school_year SET dfault = 0";
    $conn->query($resetQuery);

    $updateQuery = "UPDATE school_year SET dfault = 1 WHERE school_year = '$school_year'";
    $conn->query($updateQuery);

    header("Location: ../developer-academic-settings.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>