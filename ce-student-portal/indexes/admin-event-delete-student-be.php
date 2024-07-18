<?php
/*
admin-event-delete-student-be.php for deleting a single student from an event
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 18, 2024
Overview: This file handles the deletion of a single student from a specific event.
*/

session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['event_id']) && isset($_POST['account_number'], $_POST['previous_url'])) {
        $event_id = intval($_POST['event_id']);
        $account_number = intval($_POST['account_number']);
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