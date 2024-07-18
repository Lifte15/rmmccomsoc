<?php
/*
admin-change-email-request-code.php handles the email change request process for admin, including sending a verification code.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 15, 2024
Overview: This file handles the email change request process, including validation, database update, and sending verification codes.
*/

require('db_conn.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//this function use for sending verification button and verification code
function sendMail($newEmail, $verificationCode, $username)
{
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'itestudentportal@gmail.com';
        $mail->Password = 'gdlu jbkq oeir bybu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('itestudentportal@gmail.com', 'Change Email Address Request Code | ITE Student Portal');
        $mail->addAddress($newEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Change Email Address Request Code | ITE Student Portal';
        $mail->Body =  "
        <html>
        <head>
            <style>
                /* Add your CSS styles here */
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
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Hello, $username!</h1>
                <h3>Your request code to change your email address has been generated. Below is your request code.</h3>
                <h3> Request Code: $verificationCode</h3>
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
if (isset($_POST['send_code'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $newEmail = validate($_POST['new_email']);
    $currentEmail = $_SESSION['email'];
    $username = $_SESSION['username'];

    $user_data = 'new_email_data=' . $newEmail;

    if ($newEmail == $currentEmail) {
        header("Location: ../admin-profile-setting.php?sencodeerror=You cannot use your current email address as your new email address&$user_data");
        exit();
    }

    $checkEmailQuery = "SELECT * FROM user WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $checkEmailQuery);
    mysqli_stmt_bind_param($stmt, "s", $newEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../admin-profile-setting.php?sencodeerror=Email address is already taken. Please try again with a different email address&$user_data");
        exit();
    }

    $verificationCode = rand(100000, 999999);

    $updateQuery = "UPDATE user SET new_email = ?, verification_code = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "sss", $newEmail, $verificationCode, $currentEmail);
    $updateResult = mysqli_stmt_execute($stmt);

    if ($updateResult && sendMail($newEmail, $verificationCode, $username)) {
        $_SESSION['new_email'] = $newEmail;
        header("Location: ../admin-profile-setting.php?sencodesuccess=Your request code has been sent to your new email address&$user_data");
        exit();
    } else {
        header("Location: ../admin-profile-setting.php?sencodeerror=Unknown error occurred");
        exit();
    }
} else {
    header("Location: ../admin-profile-setting.php");
    exit();
}
?>