<?php
/*
officer-student-delete-be.php and student deletion process in officer
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: May 28, 2024
Overview: This file handles the deletion of student.
*/
session_start();
require ('db_conn.php');

if (isset($_POST['deleteStudent'])) {

    // Function to validate and sanitize user input
    function validate($data) {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate inputs
    $account_number = validate($_POST['account_number']);
    $username = validate($_POST['username']);
    $program = validate($_POST['program']);
    $year_level = validate($_POST['year_level']);
    $last_name = validate($_POST['last_name']);
    $first_name = validate($_POST['first_name']);
    $middle_name = validate($_POST['middle_name']);

    // Initialize transaction
    mysqli_begin_transaction($conn);

    try {
        // Prepare and execute deletion from attendance table
        $delete_attendance_query = "DELETE FROM attendance WHERE account_number = ?";
        $delete_attendance_stmt = mysqli_prepare($conn, $delete_attendance_query);
        mysqli_stmt_bind_param($delete_attendance_stmt, "s", $account_number);
        mysqli_stmt_execute($delete_attendance_stmt);

        // Prepare and execute deletion from enrolled table
        $delete_enrolled_query = "DELETE FROM enrolled WHERE account_number = ?";
        $delete_enrolled_stmt = mysqli_prepare($conn, $delete_enrolled_query);
        mysqli_stmt_bind_param($delete_enrolled_stmt, "s", $account_number);
        mysqli_stmt_execute($delete_enrolled_stmt);

        // Prepare and execute deletion from payment table
        $delete_payment_query = "DELETE FROM payment WHERE account_number = ?";
        $delete_payment_stmt = mysqli_prepare($conn, $delete_payment_query);
        mysqli_stmt_bind_param($delete_payment_stmt, "s", $account_number);
        mysqli_stmt_execute($delete_payment_stmt);

        // Prepare and execute deletion from user table
        $delete_user_query = "DELETE FROM user WHERE account_number = ? AND username = ? AND program = ? AND year_level = ? AND last_name = ? AND first_name = ? AND middle_name = ?";
        $delete_user_stmt = mysqli_prepare($conn, $delete_user_query);
        mysqli_stmt_bind_param($delete_user_stmt, "sssssss", $account_number, $username, $program, $year_level, $last_name, $first_name, $middle_name);
        mysqli_stmt_execute($delete_user_stmt);

        // Commit transaction
        mysqli_commit($conn);

        // Redirect to success page
        header("Location: ../officer-students.php?deleteStudentSuccess=Successfully deleted the student");
        exit();

    } catch (Exception $e) {
        // Rollback transaction in case of an error
        mysqli_rollback($conn);
        // Redirect to error page
        header("Location: ../officer-students.php?deleteStudentError=Failed to delete the student");
        exit();
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>
