<?php


session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['event_id']) && isset($_POST['account_number'], $_POST['previous_url'])) {
        function validate($data) {
            $data = trim($data); // Remove whitespace from the beginning and end of string
            $data = stripslashes($data); // Remove backslashes
            $data = htmlspecialchars($data); // Convert special characters to HTML entities
            return $data;
        }
        $event_id = validate($_POST['event_id']);
        $account_number = validate($_POST['account_number']);
        $previous_url = $_POST['previous_url'];

        // Prepare and bind
        $stmt = $conn->prepare("DELETE FROM attendance WHERE account_number = ? AND event_id = ?");
        $stmt->bind_param("si", $account_number, $event_id);

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