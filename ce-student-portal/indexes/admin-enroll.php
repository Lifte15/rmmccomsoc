<?php
/*
admin-enroll.php handles the process of enrolling a single student.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 9, 2024
Overview: This file allows administrators to enroll a single student in a specific school year, semester, program, and year level.
*/

session_start();
include 'db_conn.php';

if (isset($_POST['account_number'], $_POST['school_year'], $_POST['semester'], $_POST['program'], $_POST['year_level'], $_POST['previous_url'])) {

  function validate($data) {
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
  $previous_url = $_POST['previous_url'];

  $query = "INSERT INTO enrolled (account_number, school_year, semester) 
            VALUES ('$account_number', '$school_year', '$semester')";
  if ($conn->query($query) === TRUE) {
    header("Location: " . $previous_url);
    exit();
  } else {
    header("Location: " . $previous_url);
    exit();
  }
} else {

  header("Location: ../login.php");
  exit();
}
?>
