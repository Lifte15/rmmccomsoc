<?php
/*
admin-event-view-export.php for exporting event data
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: This file handles exporting event details and student attendance data to an Excel file.
*/


session_start();
include "db_conn.php";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch event details
    $eventsql = "SELECT * FROM events WHERE event_id = '$event_id'";
    $result = $conn->query($eventsql);
    if ($result && $result->num_rows > 0) {
        $event = $result->fetch_assoc();

        // Set filename
        $filename = $event['event_name'] . ' - ' . $event['date'] . ' - ' . $event['school_year'] . ' - ' . $event['semester'] . '.xls';

        // Fetch student details
        $query = "SELECT user.account_number, user.first_name, user.last_name, user.middle_name, user.program, user.year_level, attendance.remarks
                  FROM attendance 
                  JOIN user ON attendance.account_number = user.account_number 
                  WHERE attendance.event_id = '$event_id'
                  ORDER BY user.program ASC, user.year_level ASC, user.last_name ASC";
        $studentresult = $conn->query($query);

        // Set headers for download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Open output stream
        $output = fopen("php://output", "w");

        // Write event details
        fputcsv($output, ['Event Name:', $event['event_name']], "\t");
        fputcsv($output, ['Date:', $event['date']], "\t");
        fputcsv($output, ['School Year:', $event['school_year']], "\t");
        fputcsv($output, ['Semester:', $event['semester']], "\t");
        fputcsv($output, [], "\t");  // Empty line

        // Write column headers
        fputcsv($output, ['Student Number', 'Last Name', 'First Name', 'Middle Name', 'Program', 'Year Level', 'Remarks'], "\t");

        // Write student data
        if ($studentresult && $studentresult->num_rows > 0) {
            while ($studentrow = $studentresult->fetch_assoc()) {
                fputcsv($output, $studentrow, "\t");
            }
        } else {
            fputcsv($output, ['No students found'], "\t");
        }

        // Close output stream
        fclose($output);
        exit();
    } else {
        echo "Event not found.";
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
