<?php
/*
admin-unenroll.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: Handles the unenrollment of a student from a specific school year and semester combination.
*/

session_start();
include 'db_conn.php';

if (isset($_POST['account_number'], $_POST['school_year'], $_POST['semester'], $_POST['program'], $_POST['year_level'], $_POST['previous_url'])) {

  function validate($data)
  {
    $data = trim($data); // Remove whitespace from the beginning and end of string
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
  }

  $account_number = validate($_POST['account_number']);
  $school_year = validate($_POST['school_year']);
  $semester = validate($_POST['semester']);
  $program = validate($_POST['program']);
  $year_level = validate($_POST['year_level']);
  $previous_url = $_POST['previous_url']; // No need to re-validate as it was already escaped before sending

  $sql = "DELETE FROM enrolled WHERE account_number = '$account_number' AND school_year = '$school_year' AND semester = '$semester'";
  if (mysqli_query($conn, $sql)) {
    // Redirect the user back to the previous page
    header("Location: " . $previous_url);
    exit();
  } else {
    // Redirect the user back to the previous page with error message
    header("Location: " . $previous_url);
    exit();
  }
} else {
  header("Location: login.php");
  exit();
}
?>