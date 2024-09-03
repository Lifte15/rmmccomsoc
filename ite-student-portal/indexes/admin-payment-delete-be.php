<?php
session_start();
require('db_conn.php');

if (isset($_POST['deletePayment'])) {

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

    $query = "SELECT school_year, semester FROM events WHERE payment_for_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $payment_for_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $schoolyear, $semester);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Delete the payment
    $delete_event_query = "DELETE FROM payment WHERE payment_for_id = ?";
    $delete_event_stmt = mysqli_prepare($conn, $delete_event_query);
    mysqli_stmt_bind_param($delete_event_stmt, "s", $payment_for_id);
    mysqli_stmt_execute($delete_event_stmt);

    // Delete the payment_for
    $delete_event_query = "DELETE FROM payment_for WHERE payment_for_id = ?";
    $delete_event_stmt = mysqli_prepare($conn, $delete_event_query);
    mysqli_stmt_bind_param($delete_event_stmt, "s", $payment_for_id);
    mysqli_stmt_execute($delete_event_stmt);
    $affected_rows = mysqli_stmt_affected_rows($delete_event_stmt);

    // // Redirect based on the result of the SQL query
    if ($affected_rows > 0) {
        header("Location: ../admin-payment.php?deletePaymentSuccess=Successfully deleted the payment&search_input=&date=&school_year=$schoolyear&semester=$semester&search=");
        exit();
    } else {
        header("Location: ../admin-payment.php?deletePaymentError=Failed to delete the payment&search_input=&date=&school_year=$schoolyear&semester=$semester&search=");
        exit();
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>
