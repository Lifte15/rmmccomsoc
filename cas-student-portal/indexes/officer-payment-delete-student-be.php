<?php


session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['payment_for_id']) && isset($_POST['account_number'], $_POST['previous_url'])) {
        $payment_for_id = intval($_POST['payment_for_id']);
        $account_number = intval($_POST['account_number']);
        $previous_url = $_POST['previous_url'];

        // Prepare and bind
        $stmt = $conn->prepare("DELETE FROM payment WHERE account_number = ? AND payment_for_id = ?");
        $stmt->bind_param("si", $account_number, $payment_for_id);

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
    // Redirect back to the payment view page or wherever appropriate
    header("Location: ../login.php");
    exit();
}
?>