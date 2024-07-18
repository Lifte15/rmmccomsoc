<?php
/*
officer-scan-attendance.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: Handles the scanning of student attendance using a QR code or text input during events.
*/

session_start();
require ('db_conn.php');

if (isset($_POST['text'])) {
    $code = $_POST['text'];
    $event_id = $_POST['event_id'];

    preg_match('/ - (\d{10}) - /', $code, $matches);
    if (isset($matches[1])) {
        $account_number = $matches[1];

        // Check if the student is already in the attendance table for this event
        $stmt = $conn->prepare("SELECT account_number FROM attendance WHERE event_id = ? AND account_number = ?");
        $stmt->bind_param("is", $event_id, $account_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If the student is already in the attendance table, update their remarks to present
            $update_stmt = $conn->prepare("UPDATE attendance SET remarks = 'Present' WHERE event_id = ? AND account_number = ?");
            $update_stmt->bind_param("is", $event_id, $account_number);
            $update_stmt->execute();
            $update_stmt->close();

            // Retrieve the first_name and last_name from the user table
            $user_stmt = $conn->prepare("SELECT first_name, last_name FROM user WHERE account_number = ?");
            $user_stmt->bind_param("s", $account_number);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();

            if ($user_result->num_rows > 0) {
                $user = $user_result->fetch_assoc();
                $first_name = $user['first_name'];
                $last_name = $user['last_name'];
            } else {
                $first_name = "";
                $last_name = "";
            }


            header("Location: ../officer-event-present-qrcode.php?event_id=$event_id&last_name=$last_name&first_name=$first_name&scanSuccess=Successfully scanned");
            exit();
        } else {
            // If the student is not found in the attendance table for this event
            // Retrieve the first_name and last_name from the user table
            $user_stmt = $conn->prepare("SELECT first_name, last_name FROM user WHERE account_number = ?");
            $user_stmt->bind_param("s", $account_number);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();

            if ($user_result->num_rows > 0) {
                $user = $user_result->fetch_assoc();
                $first_name = $user['first_name'];
                $last_name = $user['last_name'];
            } else {
                $first_name = "";
                $last_name = "";
            }

            $user_stmt->close();

            header("Location: ../officer-event-present-qrcode.php?event_id=$event_id&last_name=$last_name&first_name=$first_name&studentNotFount=This student is not in this event.");
            exit();
        }

    } else {
        header("Location: ../officer-event-present-qrcode.php?event_id=$event_id&scanError=Invalid code format");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>