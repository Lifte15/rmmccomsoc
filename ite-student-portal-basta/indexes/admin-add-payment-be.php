<?php
/*
admin-add-payment-be.php and processes the addition of new payments by admin, including input validation and database insertion.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 17, 2024
Overview: This file handles the addition of new payments, validating admin input and inserting the payment into the database.
*/


session_start();
require ('db_conn.php');

if (isset($_POST['addEvent'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $payment_description = validate($_POST['payment_description']);
    $date = validate($_POST['date']);
    $schoolyear = validate($_POST['school_year']);
    $semester = validate($_POST['semester']);
    $amount = validate($_POST['amount']);

    // Construct user data string
    $user_data = 'payment_description=' . $payment_description .
        '&date=' . $date .
        '&school_year=' . $schoolyear .
        '&amount=' . $amount .
        '&semester=' . $semester;


    // Validate event name if empty
    if (empty($payment_description)) {
        header("Location: ../admin-payment-addnew.php?newPaymentError=Payment description is required&$user_data");
        exit();
    } // Validate date if empty
    elseif (empty($date)) {
        header("Location: ../admin-payment-addnew.php?newPaymentError=Date is required&$user_data");
        exit();
    } // Validate school year if empty
    elseif (empty($schoolyear)) {
        header("Location: ../admin-payment-addnew.php?newPaymentError=School year is required&$user_data");
        exit();
    } // Validate semester if empty
    elseif (empty($semester)) {
        header("Location: ../admin-payment-addnew.php?newPaymentError=Semester is required&$user_data");
        exit();
    } elseif (empty($amount)) {
        header("Location: ../admin-payment-addnew.php?newPaymentError=Amount is required&$user_data");
        exit();
    } else {
        // Insert new event
        $sql_newevent_query = "INSERT INTO payment_for(payment_description, date, school_year, semester, amount)
                VALUES(?, ?, ?, ?, ?)";
        $stmt_newevent_query = mysqli_prepare($conn, $sql_newevent_query);
        mysqli_stmt_bind_param($stmt_newevent_query, "sssss", $payment_description, $date, $schoolyear, $semester, $amount);
        $result_newevent_query = mysqli_stmt_execute($stmt_newevent_query);

        // Redirect based on the result of the SQL query
        if ($result_newevent_query) {
            header("Location: ../admin-payment.php?newPaymentSuccess=New payment added successfully");
            exit();
        } else {
            header("Location: ../admin-payment-addnew.php?newPaymentError=Failed to add new event&$user_data");
            exit();
        }
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>