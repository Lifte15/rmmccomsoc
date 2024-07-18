<?php
/*
semester-action.php sets a specified semester as the default.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 9, 2024
Overview: This script resets the default status of all semesters and updates the specified semester as the default.
*/

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