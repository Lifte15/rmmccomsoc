<?php
session_start();
require('db_conn.php');

if (isset($_POST['deleteEvent'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $event_id = validate($_POST['event_id']);

    $query = "SELECT school_year, semester FROM events WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $schoolyear, $semester);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Delete attendance records related to the event
    $delete_attendance_query = "DELETE FROM attendance WHERE event_id = ?";
    $delete_attendance_stmt = mysqli_prepare($conn, $delete_attendance_query);
    mysqli_stmt_bind_param($delete_attendance_stmt, "s", $event_id);
    mysqli_stmt_execute($delete_attendance_stmt);

    // Delete the event
    $delete_event_query = "DELETE FROM events WHERE event_id = ?";
    $delete_event_stmt = mysqli_prepare($conn, $delete_event_query);
    mysqli_stmt_bind_param($delete_event_stmt, "s", $event_id);
    mysqli_stmt_execute($delete_event_stmt);
    $affected_rows = mysqli_stmt_affected_rows($delete_event_stmt);

    // Redirect based on the result of the SQL query
    if ($affected_rows > 0) {
        header("Location: ../officer-events.php?deleteEventSuccess=Successfully deleted the event&search_input=&date=&school_year=$schoolyear&semester=$semester&search=");
        exit();
    } else {
        header("Location: ../officer-events.php?deleteEventError=Failed to delete the event&search_input=&date=&school_year=$schoolyear&semester=$semester&search=");
        exit();
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>
