<?php
 
session_start();
include "db_conn.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['event_id']) && isset($_POST['account_number'], $_POST['previous_url'])) {
            $event_id = intval($_POST['event_id']);
            $account_number = intval($_POST['account_number']);
            $previous_url = $_POST['previous_url'];

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO attendance (event_id, account_number, remarks) VALUES (?, ?, ?)");
            $remarks = "Absent";
            $stmt->bind_param("iis", $event_id, $account_number, $remarks);

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
