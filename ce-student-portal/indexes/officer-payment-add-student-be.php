<?php
/*
officer-payment-add-student-be.php handles the addition of a single student to a payment in officer
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
            $payment_for_id = intval($_POST['payment_for_id']);
            $account_number = intval($_POST['account_number']);
            $previous_url = $_POST['previous_url'];

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO payment (payment_for_id, account_number) VALUES (?, ?)");
            $stmt->bind_param("is", $payment_for_id, $account_number);

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
    header("Location: ../login.php");
    exit();
    }
?>
