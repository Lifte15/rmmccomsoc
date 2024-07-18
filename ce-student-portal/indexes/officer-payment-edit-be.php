<?php
/*
officer-payment-edit-be.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 19, 2024
Overview: Handles backend processing for editing payment details, including payment description, date, school year, semester, and amount.
*/

session_start();
require ('db_conn.php');

if (isset($_POST['editpaymentfor'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $payment_for_id = validate($_POST['payment_for_id']);
    $payment_description = validate($_POST['payment_description']);
    $date = validate($_POST['date']);
    $schoolyear = validate($_POST['school_year']);
    $semester = validate($_POST['semester']);
    $amount = validate($_POST['amount']);


    // Validate event name if empty
    if (empty($payment_description)) {
        header("Location: ../officer-payment-edit.php?payment_for_id=$payment_for_id&editPaymentforError=Payment description is required");
        exit();
    } // Validate date if empty
    elseif (empty($date)) {
        header("Location: ../officer-payment-edit.php?payment_for_id=$payment_for_id&editPaymentforError=Date is required");
        exit();
    } // Validate school year if empty
    elseif (empty($schoolyear)) {
        header("Location: ../officer-payment-edit.php?payment_for_id=$payment_for_id&editPaymentforError=School year is required");
        exit();
    } // Validate semester if empty
    elseif (empty($semester)) {
        header("Location: ../officer-payment-edit.php?payment_for_id=$payment_for_id&editPaymentforError=Semester is required");
        exit();
    } elseif (empty($amount)) {
        header("Location: ../officer-payment-edit.php?payment_for_id=$payment_for_id&editPaymentforError=Amount is required");
        exit();
    } else {
        $sql_update_event = "UPDATE payment_for SET payment_description = ?, date = ?, school_year = ?, semester = ?, amount = ? WHERE payment_for_id = ?";
        $stmt_update_event = mysqli_prepare($conn, $sql_update_event);
        mysqli_stmt_bind_param($stmt_update_event, "sssssi", $payment_description, $date, $schoolyear, $semester, $amount, $payment_for_id);
        $result_update_event = mysqli_stmt_execute($stmt_update_event);

        // Redirect based on the result of the SQL query
        if ($result_update_event) {
            header("Location: ../officer-payment-view.php?payment_for_id=$payment_for_id&updatePaymentforSuccess=Updating payment information successfully");
            exit();
        } else {
            header("Location: ../officer-payment-edit.php?payment_for_id=$payment_for_id&editPaymentforError=Failed to update event");
            exit();
        }
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>