<?php
/*
searchforgotpassword-be.php handles the process of sending a password reset verification code to a user's email.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 9, 2024
Overview: This validates the user account, generates a verification code, and sends an email with the code if the account is found.
*/

require ('db_conn.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $last_name, $first_name, $v_code)
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

        $mail->setFrom('itestudentportal@gmail.com', 'Reset Password Code | ITE Student Portal');
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
                    <h1>Hello, $last_name, $first_name!</h1>
                    <h3>This is your reset password code. If you did not request to reset your password, please inform your officer immediately:</h3>
                    <h2>Request Code: $v_code</h2>
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

if (isset($_POST['searchAccount'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $account_number = validate($_POST['account_number']);
    $v_code = rand(100000, 999999);

    if (empty($account_number)) {
        header("Location: ../forgotpassword.php?searchAccountFailed=Please enter a valid account number");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT account_number, email, last_name, first_name FROM user WHERE account_number = ?");
        $stmt->bind_param("s", $account_number);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($account_number_result, $email, $last_name, $first_name);
            $stmt->fetch();

            $update_stmt = $conn->prepare("UPDATE user SET verification_code = ? WHERE account_number = ?");
            $update_stmt->bind_param("ss", $v_code, $account_number);
            $update_stmt->execute();

            if (!empty($email)) {
                if (sendMail($email, $last_name, $first_name, $v_code)) {
                    $_SESSION['verify'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['account_number'] = $account_number;
                    header("Location: ../verifyforgotpassword.php?searchAccountSuccess=A Reset Password Code has been sent to your email address. Please check your email.");
                    exit();
                } else {
                    header("Location: ../forgotpassword.php?searchAccountFailed=Failed to send a verification code to your email. Please contact your officer to reset your password. Thank you");
                    exit();
                }

            } else {
                header("Location: ../forgotpassword.php?searchAccountFailed=The account number exists, but you haven't registered a valid email address. Please contact your officer to reset your password. Thank you");
                exit();
            }
        } else {
            header("Location: ../forgotpassword.php?searchAccountFailed=Account number does not exist, please contact your officer. Thank you");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}



?>