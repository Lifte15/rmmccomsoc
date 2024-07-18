<?php
/*
admin-payment-unpaid-be.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: Handles the processing to mark a payment as 'Unpaid', updating the payment records with the appropriate remarks and clearing payment date and received by information.
*/

session_start();
require('db_conn.php');

if (isset($_POST['confirmMarkUnpaid'])) {
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    $payment_for_id = validate($_POST['payment_for_id']);
    $account_number = validate($_POST['account_number']);
    $remarks = "Unpaid";
    $date_paid = "";
    $received_by = "";
    $proof_pic = "";
    $cn_number = "";

    // Prepare the SQL statement
    $sql = "UPDATE payment SET remarks = ?, proof_pic = ?, date_paid = ?, received_by = ?, cn_number = ? WHERE payment_for_id = ? AND account_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $remarks, $payment_file, $date_paid, $received_by, $cn_number, $payment_for_id, $account_number);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the same URL
        header("Location: {$_SERVER['HTTP_REFERER']}?success=Payment marked as paid successfully");
        exit();
    } else {
        // Redirect to the same URL
        header("Location: {$_SERVER['HTTP_REFERER']}?failed=Payment failed to marked as paid");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
