<?php
/*
officer-event-add-all-students-be.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 18, 2024
Overview: This file allows officer to add all eligible students to an event based on program and year level.
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
    $event_id = validate($_POST['event_id']);
    $program = validate($_POST['program']);
    $year_level = validate($_POST['year_level']);

    // Validate event ID if empty
    if (empty($event_id)) {
        header("Location: ../officer-event-view.php?addAllError=Event ID is required");
        exit();
    }

    // Get the event details to extract the school year and semester
    $sql = "SELECT school_year, semester FROM events WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $school_year = $row['school_year'];
        $semester = $row['semester'];

        $conditions = [];
        if ($program !== 'all') {
            $conditions[] = "u.program = '$program'";
        }
        if ($year_level !== 'all') {
            $conditions[] = "u.year_level = '$year_level'";
        }
        $whereClause = count($conditions) > 0 ? 'AND ' . implode(' AND ', $conditions) : '';

        $studentsql = "SELECT u.account_number
                       FROM user u
                       INNER JOIN enrolled e ON u.account_number = e.account_number
                       LEFT JOIN attendance a ON u.account_number = a.account_number AND a.event_id = ?
                       WHERE e.school_year = ?
                         AND e.semester = ?
                         AND u.role = 'Student'
                         AND a.account_number IS NULL
                         $whereClause";
        $stmt = mysqli_prepare($conn, $studentsql);
        mysqli_stmt_bind_param($stmt, "iss", $event_id, $school_year, $semester);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            $insertSuccess = true;
            while ($row = $result->fetch_assoc()) {
                $account_number = $row['account_number'];
                $insertSql = "INSERT INTO attendance (event_id, account_number) VALUES (?, ?)";
                $stmtInsert = mysqli_prepare($conn, $insertSql);
                mysqli_stmt_bind_param($stmtInsert, "is", $event_id, $account_number);
                if (!mysqli_stmt_execute($stmtInsert)) {
                    $insertSuccess = false;
                    break;
                }
            }
            if ($insertSuccess) {
                header("Location: ../officer-event-view.php?event_id=$event_id&addAllSuccess=All eligible students have been added to the event.");
            } else {
                header("Location: ../officer-event-view.php?event_id=$event_id&addAllError=Failed to add all eligible students.");
            }
        } else {
            header("Location: ../officer-event-view.php?event_id=$event_id&addAllError=No students found to add to the event.");
        }
    } else {
        header("Location: ../officer-event-view.php?addAllError=Event not found.");
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
