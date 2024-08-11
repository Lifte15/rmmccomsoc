<?php
/*
school_year-action.php sets a specified school year as the default.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 9, 2024
Overview: This script resets the default status of all school years and updates the specified school year as the default.
*/

session_start();
include "db_conn.php";
if (isset($_POST['default_school_year'])) {

    $school_year = mysqli_real_escape_string($conn, $_POST['default_school_year']);

    $resetQuery = "UPDATE school_year SET dfault = 0";
    $conn->query($resetQuery);

    $updateQuery = "UPDATE school_year SET dfault = 1 WHERE school_year = '$school_year'";
    $conn->query($updateQuery);

    header("Location: ../admin-academic-settings.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>