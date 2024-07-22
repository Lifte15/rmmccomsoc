<?php
/*
admin-payment-add-student-be.php handles the addition of a single student to a payment in admin
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: This file processes the addition of a single student to a payment record, ensuring the payment for the specified payment ID and student account number is recorded with 'Unpaid' remarks.
*/

session_start();
include "db_conn.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['add_student'])) {
            function validate($data) {
                $data = trim($data); // Remove whitespace from the beginning and end of string
                $data = stripslashes($data); // Remove backslashes
                $data = htmlspecialchars($data); // Convert special characters to HTML entities
                return $data;
            }
            $payment_for_id = validate($_POST['payment_for_id']);
            $account_number = validate($_POST['account_number']);
            $previous_url = $_POST['previous_url'];

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO payment (payment_for_id, account_number, remarks) VALUES (?, ?, ?)");
            $remarks = 'Unpaid';
            $stmt->bind_param("iss", $payment_for_id, $account_number, $remarks);

            // Execute the statement
            if ($stmt->execute()) {
                header("Location: " . $previous_url);
                exit();
            } else {
                header("Location: " . $previous_url);
                exit();
            }

        }
    } else {
    // Redirect back to the event view page or wherever appropriate
    header("Location: login.php");
    exit();
    }
?>
