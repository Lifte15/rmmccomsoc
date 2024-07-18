<?php
/*
admin-add-announcement-be.php and processes the addition of new announcements by admin, including input validation and database insertion.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 2, 2024
Overview: This file handles the addition of new announcements, validating admin input and inserting the announcement into the database.
*/

session_start();
require ('db_conn.php');

if (isset($_POST['addAnnouncement'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $heading = validate($_POST['heading']);
    $content = validate($_POST['content']);
    $school_year = validate($_POST['school_year']);
    $semester = validate($_POST['semester']);

    $postedBy = $_SESSION['position'];

    // Set the default timezone and the current date and time
    date_default_timezone_set('Asia/Manila');
    $time = date("Y-m-d H:i:s");

    // Construct user data string
    $user_data = '&heading=' . $heading .
        '&content=' . $content.
        '&school_year=' . $school_year.
        '&semester=' . $semester;


    if (strlen($heading) > 255) {
        header("Location: ../admin-announcement-addnew.php?newaAnnouncementError=Heading is too long, heading must not more than 255 characters$user_data");
        exit();
    } // Validate heading if empty
     else if (empty($heading)) {
        header("Location: ../admin-announcement-addnew.php?newaAnnouncementError=Heading is required$user_data");
        exit();
    } // Validate content if empty
    else if (empty($content)) {
        header("Location: ../admin-announcement-addnew.php?newaAnnouncementError=Content is required&$user_data");
        exit();
    } elseif (empty($semester)) {
        header("Location: ../admin-announcement-addnew.php?newaAnnouncementError=Semester is required&$user_data");
        exit();
    } elseif (empty($school_year)) {
        header("Location: ../admin-announcement-addnew.php?newaAnnouncementError=School year is required&$user_data");
        exit();
    } else {
        // Insert new announcement
        $sql_newAnnouncement_query = "INSERT INTO announcement(heading, content, position, posted_on, school_year, semester)
        VALUES(?, ?, ?, ?, ?, ?)";
        $stmt_newoAnnouncement_query = mysqli_prepare($conn, $sql_newAnnouncement_query);
        mysqli_stmt_bind_param($stmt_newoAnnouncement_query, "ssssss", $heading, $content, $postedBy, $time, $school_year, $semester);
        $result_newoAnnouncement_query = mysqli_stmt_execute($stmt_newoAnnouncement_query);

        // Redirect based on the result of the SQL query
        if ($result_newoAnnouncement_query) {
            header("Location: ../admin-announcement.php?newAnnouncementSuccess=New announcement has been posted");
            exit();
        } else {
            header("Location: ../admin-announcement.php?newAnnouncementError=Failed to post announcement");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>