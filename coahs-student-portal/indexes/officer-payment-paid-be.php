<?php
/*
admin-payment-paid-be.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 25, 2024
Overview: Handles the processing to mark a payment as 'Paid', updating the payment records with the payment date, received by information, and uploading proof of payment.
*/

session_start();
require ('db_conn.php');

if (isset($_POST['confirmMarkPaid'])) {
    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $payment_for_id = validate($_POST['payment_for_id']);
    $account_number = validate($_POST['account_number']);
    $remarks = "Paid";
    $date_paid = validate($_POST['date_paid']);
    $received_by = validate($_POST['received_by']);
    $cn_number = validate($_POST['cn_number']);

    // Check if date is in the correct format (YYYY-MM-DD)
    if (DateTime::createFromFormat('Y-m-d', $date_paid) === false) {
        header("Location: {$_SERVER['HTTP_REFERER']}?failed=Invalid date format");
        exit();
    }

    // File upload handling
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['file']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $folder = "../proof-of-payment/";

        // Allowed file extensions
        $allowed_extensions = array('png', 'jpg', 'jpeg');

        // Validate if the file extension is allowed
        if (!in_array(strtolower($file_ext), $allowed_extensions)) {
            header("Location: {$_SERVER['HTTP_REFERER']}?error=Upload failed, file type is not supported. Please upload PNG, JPG, or JPEG file type only.");
            exit();
        }

        // Define the final file name
        $payment_file = strtolower($account_number) . '_' . $payment_for_id . '.' . $file_ext;

        // Move the uploaded file to the specified folder
        if (move_uploaded_file($file_loc, $folder . $payment_file)) {
            // Prepare the SQL statement
            $sql = "UPDATE payment SET remarks = ?, proof_pic = ?, date_paid = ?, received_by = ?, cn_number = ? WHERE payment_for_id = ? AND account_number = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $remarks, $payment_file, $date_paid, $received_by, $cn_number, $payment_for_id, $account_number);
        } else {
            error_log("File upload error: " . $_FILES['proof_pic']['error']);
            header("Location: {$_SERVER['HTTP_REFERER']}?error=Upload failed, please try again.");
            exit();
        }
    } else {
        // Prepare the SQL statement without the proof_pic field
        $sql = "UPDATE payment SET remarks = ?, date_paid = ?, received_by = ?, cn_number = ? WHERE payment_for_id = ? AND account_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $remarks, $date_paid, $received_by, $cn_number, $payment_for_id, $account_number);
    }

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: {$_SERVER['HTTP_REFERER']}?success=Payment marked as paid successfully");
        exit();
    } else {
        error_log("Database error: " . $stmt->error);
        header("Location: {$_SERVER['HTTP_REFERER']}?failed=Payment failed to mark as paid");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
