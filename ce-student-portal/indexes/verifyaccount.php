<?php
/*
verifyaccount.php handles the verification process of a user's account by checking the verification code.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 21, 2024
Overview: This validates the user input, checks the verification code against the database, updates the user record upon successful verification.
*/

require('db_conn.php');

if (isset($_POST['verify'])) {
    $account_number = $_POST['account_number'];
    $email = $_POST['email'];
    $v_code = $_POST['v_code'];

    $user_data = 'email=' . $email;
    
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    $account_number = $_POST['account_number'];
    $v_code = validate($_POST['v_code']);

    if (empty($v_code)) {
        header("Location: ../createdsuccessfully.php?error=Verification code is missing.");
        exit();
    }

    $query = "SELECT account_number, verification_code FROM `user` WHERE `account_number` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $account_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) { 
        $row = mysqli_fetch_assoc($result);
        if ($row['verification_code'] == $v_code) {
            if ($row['is_verified'] == 0) { 
                $update = "UPDATE user SET is_verified='1'WHERE account_number = ?";
                $stmt = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($stmt, "s", $account_number);
                if (mysqli_stmt_execute($stmt)) { 
                    header("Location: ../login.php?success=Email verification successful.");
                    exit();
                } else {
                    header("Location: ../verify-email.php?verifyFailed=Unknown error occurred.&$user_data");
                    exit();
                }
            } else {
                header("Location: ../verify-email.php?success=Email Address was already registered");
                exit();
            }
        } else {
            header("Location: ../verify-email.php?verifyFailed=Verification code is incorrect.&$user_data");
            exit();
        }
    } else {
        header("Location: ../verify-email.php?verifyFailed=Email Address not found or incorrect.&$user_data");
        exit();
    }
} else {
    header("Location: ../verify-email.php?verifyFailed=Email or verification code is missing.&$user_data");
    exit();
}