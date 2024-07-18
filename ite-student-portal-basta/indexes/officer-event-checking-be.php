<?php
/*
officer-event-checking-be.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 19, 2024
Overview: This file handles marking a student as present or absent in an event.
*/

session_start();
require ('db_conn.php');

if (isset($_POST['markAsPresent'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $event_id = validate($_POST['event_id']);
    $account_number = validate($_POST['account_number']);
    $remarks = "Present";

    // Prepare the SQL statement
    $sql = "UPDATE attendance SET remarks = ? WHERE event_id = ? AND account_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $remarks, $event_id, $account_number);

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
} elseif (isset($_POST['markAsAbsent'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    $event_id = validate($_POST['event_id']);
    $account_number = validate($_POST['account_number']);
    $remarks = "Absent";

    $sql = "UPDATE attendance SET remarks = ? WHERE event_id = ? AND account_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $remarks, $event_id, $account_number);

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