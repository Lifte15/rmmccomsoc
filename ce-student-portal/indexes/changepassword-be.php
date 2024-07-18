<?php
/*
changepassword-be.php and password change process
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 15, 2024
Overview: This file handles the change of password for accounts, validating input and updating the password in the database.
*/
session_start();

include "db_conn.php";

if (
    isset($_POST['currentPassword']) && isset($_POST['newPassword'])
    && isset($_POST['retypeNewPassword'])
) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $currentPassword = validate($_POST['currentPassword']);
    $newPassword = validate($_POST['newPassword']);
    $retypeNewPassword = validate($_POST['retypeNewPassword']);

    // Get the account index from the session
    $account_number = $_SESSION['account_number'];

    // Validate if the new password is equal to retyped new password
    if ($newPassword !== $retypeNewPassword) {
        header("Location: ../profile-setting.php?passerror=Your new password and Retype password do not match.");
        exit();
    }

    // Query the database to retrieve the stored password
    $sql = "SELECT password FROM user WHERE account_number=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $account_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // If there is a result, compare the current password with the stored password
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        // Validate if input password and stored password is equal
        if (!password_verify($currentPassword, $storedPassword)) {
            header("Location: ../profile-setting.php?passerror=Incorrect current password.");
            exit();
        }
    } else {
        header("Location: ../profile-setting.php?passerror=User not found.");
        exit();
    }

    // Hashed the new input password
    $hashed_new_password = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_sql = "UPDATE user SET password=? WHERE account_number=?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ss", $hashed_new_password, $account_number);
    $update_result = mysqli_stmt_execute($update_stmt);

    // Redirect based on the result of the SQL query
    if ($update_result) {
        $_SESSION['password'] = $hashed_new_password; 
        header("Location: ../profile-setting.php?passsuccess=Password updated successfully.");
        exit();
    } else {
        header("Location: ../profile-setting.php?error=Failed to update password.");
        exit();
    }
} else {
    header("Location: ../profile-setting.php");
    exit();
}
