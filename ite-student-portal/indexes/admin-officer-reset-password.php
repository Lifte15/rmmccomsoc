<?php
/*
admin-officer-reset-password.php for resetting officer passwords
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 15, 2024
Overview: This file handles the resetting of an officer's password to a default value.
*/

session_start();

include "db_conn.php";

if (isset($_GET['account_number'])) {
    $account_number = $_GET['account_number'];

    // Fetch user details
    $studentsql = "SELECT * FROM user WHERE account_number = ?";
    $stmt = $conn->prepare($studentsql);
    $stmt->bind_param("s", $account_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $defaultpassword = "officer123";
        $defaulthashed_pass = password_hash($defaultpassword, PASSWORD_BCRYPT);

        // Update password in the database
        $update_sql = "UPDATE user SET password = ? WHERE account_number = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $defaulthashed_pass, $account_number);
        if ($update_stmt->execute()) {
            header("Location: ../admin-officer.php?account_number=$account_number&resetPasswordSuccess=Password reset successfully");
        } else {
            header("Location: ../admin-officer.php?account_number=$account_number&resetError=Failed to reset password");
        }
    } else {
        header("Location: ../admin-officer.php?account_number=$account_number&resetError=Student not found");
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>