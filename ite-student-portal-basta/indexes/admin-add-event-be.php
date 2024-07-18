<?php
/*
admin-add-event-be.php and processes the addition of new events by admin, including input validation and database insertion.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 11, 2024
Overview: This file handles the addition of new events, validating admin input and inserting the event into the database.
*/


session_start();
require ('db_conn.php');

if (isset($_POST['addEvent'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $eventname = validate($_POST['eventname']);
    $date = validate($_POST['date']);
    $schoolyear = validate($_POST['school_year']);
    $semester = validate($_POST['semester']);
    $points = validate($_POST['points']);

    // Construct user data string
    $user_data = 'eventname=' . $eventname .
    '&date=' . $date .
    '&school_year=' . $schoolyear .
    '&points=' . $points .
    '&semester=' . $semester;


    // Validate event name if empty
    if (empty($eventname)) {
        header("Location: ../admin-event-addnew.php?newEventError=Event name is required&$user_data");
        exit();
    } // Validate date if empty
    elseif (empty($date)) {
        header("Location: ../admin-event-addnew.php?newEventError=Date is required&$user_data");
        exit();
    } // Validate school year if empty
    elseif (empty($schoolyear)) {
        header("Location: ../admin-event-addnew.php?newEventError=School year is required&$user_data");
        exit();
    } // Validate semester if empty
    elseif (empty($semester)) {
        header("Location: ../admin-event-addnew.php?newEventError=Semester is required&$user_data");
        exit();
    } 
    elseif (empty($points)) {
        header("Location: ../admin-event-addnew.php?newEventError=Points is required&$user_data");
        exit();
    } else {
        // Check if event name already exists
        $sql_check_existing = "SELECT * FROM events WHERE event_name=?";
        $stmt_check_existing = mysqli_prepare($conn, $sql_check_existing);
        mysqli_stmt_bind_param($stmt_check_existing, "s", $eventname,);
        mysqli_stmt_execute($stmt_check_existing);
        $result_check_existing = mysqli_stmt_get_result($stmt_check_existing);

        // Validate event name if already exists
        if (mysqli_num_rows($result_check_existing) > 0) {
            header("Location: ../admin-event-addnew.php?newEventError=Event name already exists&$user_data");
            exit();
        } else {
            // Insert new event
            $sql_newevent_query = "INSERT INTO events(event_name, date, school_year, semester, points)
                VALUES(?, ?, ?, ?, ?)";
            $stmt_newevent_query = mysqli_prepare($conn, $sql_newevent_query);
            mysqli_stmt_bind_param($stmt_newevent_query, "ssssi", $eventname, $date, $schoolyear, $semester, $points);
            $result_newevent_query = mysqli_stmt_execute($stmt_newevent_query);

            // Redirect based on the result of the SQL query
            if ($result_newevent_query) {
                header("Location: ../admin-events.php?newEventSuccess=New event added successfully");
                exit();
            } else {
                header("Location: ../admin-event-addnew.php?newEventError=Failed to add new event&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>