<?php
/*
officer-announcement-delete-be.php and announcement deletion process in officer
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 2, 2024
Overview: This file handles the deletion of announcements.
*/
session_start();
require ('db_conn.php');

if (isset($_POST['deleteAnnouncement'])) {
    
    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    $announcement_id = validate($_POST['announcement_id']);
    $current_user = $_SESSION['position']; 

    // Check if the user is the owner of the announcement or if they are an admin
    $check_owner_query = "SELECT position FROM announcement WHERE announcement_id = ?";
    $check_owner_stmt = mysqli_prepare($conn, $check_owner_query);
    mysqli_stmt_bind_param($check_owner_stmt, "i", $announcement_id);
    mysqli_stmt_execute($check_owner_stmt);
    mysqli_stmt_bind_result($check_owner_stmt, $owner_id);
    mysqli_stmt_fetch($check_owner_stmt);
    mysqli_stmt_close($check_owner_stmt);

    if ($current_user == $owner_id) {
        $delete_announcement_query = "DELETE FROM announcement WHERE announcement_id = ?";
        $delete_announcement_stmt = mysqli_prepare($conn, $delete_announcement_query);
        mysqli_stmt_bind_param($delete_announcement_stmt, "i", $announcement_id);
        mysqli_stmt_execute($delete_announcement_stmt);
        $affected_rows = mysqli_stmt_affected_rows($delete_announcement_stmt);
        mysqli_stmt_close($delete_announcement_stmt);

        // Redirect based on the result of the SQL query
        if ($affected_rows > 0) {
            header("Location: ../officer-announcement.php?deleteAnnouncementSuccess=Successfully deleted the announcement");
            exit();
        } else {
            header("Location: ../officer-announcement.php?deleteAnnouncementError=Failed to delete the announcement");
            exit();
        }
    } else {
        // User is not authorized to delete the announcement
        header("Location: ../officer-announcement.php?deleteAnnouncementError=You are not allowed to delete this announcement");
        exit();
    }
} else {
    header("Location: ../officer-announcement.php");
    exit();
}
?>
