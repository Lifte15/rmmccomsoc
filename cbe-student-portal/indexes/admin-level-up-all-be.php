<?php
/*
admin-event-add-all-students-be.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 18, 2024
Overview: This file allows admin to add all eligible students to an event based on program and year level.
*/

session_start();
require('db_conn.php');

if (isset($_POST['add_all'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate inputs
    $program = validate($_POST['program']);
    $year_level = validate($_POST['year_level']);
    $previous_url = $_POST['previous_url'];


    // Construct the conditions for the query
    $conditions = ["role = 'Student'"];
    if ($program !== 'all') {
        $conditions[] = "program = '$program'";
    }
    if ($year_level !== 'all') {
        $conditions[] = "year_level = '$year_level'";
    }
    $whereClause = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';

    // Update the year_level of all eligible students
    $updateSql = "
        UPDATE user
        SET year_level = CASE 
            WHEN year_level = '1' THEN '2'
            WHEN year_level = '2' THEN '3'
            WHEN year_level = '3' THEN '4'
            WHEN year_level = '4' THEN 'Graduate'
            ELSE 'Graduate'
        END
        $whereClause
    ";

    if ($conn->query($updateSql) === TRUE) {
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
