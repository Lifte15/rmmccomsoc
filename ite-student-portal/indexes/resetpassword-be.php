<?php
/*
resetpassword-be.php handles the reset of user passwords based on account number, email, and verification code.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: This verifies the provided reset code and, if valid, resets the user's password to a default format based on their last name and account number.
*/

require ('db_conn.php');
session_start();
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// function sendMail($email, $last_name, $first_name, $v_code)
// {
//     require ("PHPMailer/PHPMailer.php");
//     require ("PHPMailer/SMTP.php");
//     require ("PHPMailer/Exception.php");

//     $mail = new PHPMailer(true);

//     try {
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = 'itestudentportal@gmail.com';
//         $mail->Password = 'gdlu jbkq oeir bybu';
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port = 587;

//         $mail->setFrom('itestudentportal@gmail.com', 'Reset Password Code | ITE Student Portal');
//         $mail->addAddress($email);

//         $mail->isHTML(true);
//         $mail->Subject = 'Hello ITE Student | ITE Student Portal';
//         $mail->Body = "
//         <html>


//         <head>
//                 <style>
//                     body {
//                         font-family: Arial, sans-serif;
//                         background-color: #f4f4f4;
//                         padding: 20px;
//                     }
//                     .container {
//                         max-width: 600px;
//                         margin: 0 auto;
//                         background-color: #fff;
//                         padding: 30px;
//                         border-radius: 10px;
//                         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
//                     }
//                     h1 {
//                         color: #333;
//                     }
//                     p {
//                         color: #666;
//                     }
//                     a {
//                         text-decoration: none;
//                         color: #111;
//                     }
//                     .button {
//                         display: inline-block;
//                         background-color: #111111;
//                         color: #ffffff;
//                         padding: 10px 20px;
//                         text-decoration: none;
//                         border-radius: 5px;
//                     } 
//                     .button:hover {
//                         background-color: #808080; 
//                     }
//                     h3 {
//                         margin: 0; /* Remove margin to eliminate extra spacing */
//                     }
//                 </style>
//             </head>
//             <body>
//                 <div class='container'>
//                     <h1>Hello, $last_name, $first_name!</h1>
//                     <h3>This is your reset password code. If you did not request to reset your password, please inform your officer immediately:</h3>
//                     <h2>Request Code: $v_code</h2>
//                     <hr>
//                     <p>Thank you</p>
//                 </div>
//             </body>
//         </html>";

//         $mail->send();
//         return true;
//     } catch (Exception $e) {
//         return false;
//     }
// }

if (isset($_POST['resetPassword'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $account_number = validate($_POST['account_number']);
    $email = validate($_POST['email']);
    $v_code = validate($_POST['v_code']);

    if (empty($v_code)) {
        header("Location: ../verifyforgotpassword.php?verifyFailed=Reset Password Code is required");
        exit();
    } else {
        $sql = "SELECT last_name FROM user WHERE account_number = ? AND email = ? AND verification_code = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $account_number, $email, $v_code);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($last_name);
                $stmt->fetch();

                $last_name_no_space = str_replace(' ', '', $last_name);
                $defaultpassword = $last_name_no_space . $account_number;
                $defaulthashed_pass = password_hash($defaultpassword, PASSWORD_BCRYPT);

                echo $defaulthashed_pass;

                // Update password in the database
                $update_sql = "UPDATE user SET password = ? WHERE account_number = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $defaulthashed_pass, $account_number);
                if ($update_stmt->execute()) {
                    header("Location: ../login.php?success=Password reset successfully");
                } else {
                    header("Location: ../verifyforgotpassword.php?verifyFailed=Failed to reset your password to default. Please contact your officer. Thank you");
                }

            } else {
                header("Location: ../verifyforgotpassword.php?verifyFailed=Invalid account number, email, or verification code");
            }
            $stmt->close();
        } else {
            header("Location: ../verifyforgotpassword.php?verifyFailed=Database error");
        }

        $conn->close();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>