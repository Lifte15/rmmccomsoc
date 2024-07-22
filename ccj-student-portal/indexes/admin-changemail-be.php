<?php
/*
admin-changemail-be.php handles the process of changing the email address by admin after verification.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 15, 2024
Overview: This file handles the process of changing the email address by admin after verification.
*/

require('db_conn.php');
session_start();

if (isset($_POST['change_email_password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $requestCode = validate($_POST['request_code']);
    $password = validate($_POST['change_email_password']);
    $currentEmail = $_SESSION['email'];
    $username = $_SESSION['username'];
    $newEmail = $_SESSION['new_email'];

    $stored_password = $_SESSION['password']; 

    $code_input = 'request_code_data=' . $requestCode;

    if (empty($newEmail) || trim($newEmail) === "") {
        header("Location: ../admin-profile-setting.php?requestcodeerror=New email address is empty");
        exit();
    }

    $checkNewEmailQuery = "SELECT * FROM user WHERE username = ? AND new_email = ?";
    $checkNewEmailStmt = mysqli_prepare($conn, $checkNewEmailQuery);
    mysqli_stmt_bind_param($checkNewEmailStmt, "ss", $username, $newEmail);
    mysqli_stmt_execute($checkNewEmailStmt);
    $checkNewEmailresult = mysqli_stmt_get_result($checkNewEmailStmt);

    if (empty($requestCode)) {
        header("Location: ../admin-profile-setting.php?requestcodeerror=Verification Code is required&$code_input");
        exit();
    } elseif (empty($password)) {
        header("Location: ../admin-profile-setting.php?requestcodeerror=Password is required&$code_input");
        exit();
    } elseif (!password_verify($password, $stored_password)) { 
        header("Location: ../admin-profile-setting.php?requestcodeerror=Incorrect Password&$code_input");
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE Email = ? AND verification_code = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $currentEmail, $requestCode);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) { 
            header("Location: ../admin-profile-setting.php?requestcodeerror=Verification Code is incorrect&$code_input");
            exit();
        } else {
            if (mysqli_num_rows($checkNewEmailresult) == 0) {
                header("Location: ../admin-profile-setting.php?requestcodeerror=Email Address is already existing");
                exit();
            }

            $updateSql = "UPDATE user SET Email = ? WHERE username = ?";
            $updateStmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, "ss", $newEmail, $username);
            if (mysqli_stmt_execute($updateStmt)) {
                $updateSql2 = "UPDATE user SET new_email = '' WHERE username = ?";
                $updateStmt2 = mysqli_prepare($conn, $updateSql2);
                mysqli_stmt_bind_param($updateStmt2, "s", $username);
                mysqli_stmt_execute($updateStmt2);

                $_SESSION['email'] = $newEmail;
                $_SESSION['new_email'] = "";
                header("Location: ../admin-profile-setting.php?sencodesuccess=Email updated successfully");
                exit();
            } else {
                header("Location: ../admin-profile-setting.php?requestcodeerror=Failed to update email");
                exit();
            }
        }
    }
} else {
    header("Location: ../admin-profile-setting.php");
    exit();
}
