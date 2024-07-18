<?php
/*
sendverificationcode.php handles the process of generating and sending a verification code to a user's email for account verification.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 9, 2024
Overview: This script validates the user account, generates a verification code, updates the user record, and sends an email with the code if the account is found.
*/

require ('db_conn.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $v_code, $last_name, $first_name, $middle_name, $program, $year_level, $username)
{
    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'itestudentportal@gmail.com';
        $mail->Password = 'gdlu jbkq oeir bybu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('itestudentportal@gmail.com', 'Account Verification Code | ITE Student Portal');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Hello ITE Student | ITE Student Portal';
        $mail->Body = "
        <html>

    
        <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #333;
                    }
                    p {
                        color: #666;
                    }
                    a {
                        text-decoration: none;
                        color: #111;
                    }
                    .button {
                        display: inline-block;
                        background-color: #111111;
                        color: #ffffff;
                        padding: 10px 20px;
                        text-decoration: none;
                        border-radius: 5px;
                    } 
                    .button:hover {
                        background-color: #808080; 
                    }
                    h3 {
                        margin: 0; /* Remove margin to eliminate extra spacing */
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Hello, $username!</h1>
                    <h3>Last Name:  $last_name</h3>
                    <h3>First Name: $first_name</h3>
                    <h3>Middle Name: $middle_name</h3>
                    <h3>Program: $program</h3>
                    <h3>Year Level: $year_level</h3>
                    <hr>
                    <h3>To finalize your ITE Student Portal account, please verify your account using the following verification code:</h3>
                    <h2>Verification Code: $v_code</h2>
                    <hr>
                    <p>Thank you</p>
                </div>
            </body>
        </html>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['sendCode'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $account_number = validate($_POST['account_number']);

    $user_data = 'email=' . $email;

    if (empty($email)) {
        header("Location: ../verify-email.php?codeSentFailed=Email address is required&$user_data");
        exit();
    } else {
        $sql_email_check = "SELECT account_number FROM user WHERE email = ?";
        $stmt_email_check = mysqli_prepare($conn, $sql_email_check);
        mysqli_stmt_bind_param($stmt_email_check, "s", $email);
        mysqli_stmt_execute($stmt_email_check);
        $result_email_check = mysqli_stmt_get_result($stmt_email_check);

        $email_exists_in_other_account = false;

        while ($row_email_check = mysqli_fetch_assoc($result_email_check)) {
            if ($row_email_check['account_number'] != $account_number) {
                $email_exists_in_other_account = true;
                break;
            }
        }

        if ($email_exists_in_other_account) {
            header("Location: ../verify-email.php?codeSentFailed=Email address is already used by another account&$user_data");
            exit();
        }

        // Fetch the user details
        $sql_select = "SELECT last_name, first_name, middle_name, program, year_level, username FROM user WHERE account_number = ?";
        $stmt_select = mysqli_prepare($conn, $sql_select);
        mysqli_stmt_bind_param($stmt_select, "s", $account_number);
        mysqli_stmt_execute($stmt_select);
        $result_select = mysqli_stmt_get_result($stmt_select);

        if ($row = mysqli_fetch_assoc($result_select)) {
            $last_name = $row['last_name'];
            $first_name = $row['first_name'];
            $middle_name = $row['middle_name'];
            $program = $row['program'];
            $year_level = $row['year_level'];
            $username = $row['username'];

            $v_code = rand(100000, 999999);

            $sql_update = "UPDATE user SET verification_code = ?, email = ? WHERE account_number = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "iss", $v_code, $email, $account_number);
            $result_update = mysqli_stmt_execute($stmt_update);

            if ($result_update && sendMail($_POST['email'], $v_code, $last_name, $first_name, $middle_name, $program, $year_level, $username)) {
                header("Location: ../verify-email.php?codeSentSuccess=Your Verification Code has been sent to your email.&$user_data");
                exit();
            } else {
                header("Location: ../verify-email.php?codeSentFailed=Verification Code failed to be sent to your email.&$user_data");
                exit();
            }
        } else {
            header("Location: ../verify-email.php?codeSentFailed=Account number not found&$user_data");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}