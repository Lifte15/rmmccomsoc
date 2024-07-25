<?php


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
    $marked_by = $_SESSION['last_name'] . ', ' . $_SESSION['first_name'];

    // Prepare the SQL statement
    $sql = "UPDATE attendance SET remarks = ?, remarked_by = ? WHERE event_id = ? AND account_number = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $remarks, $marked_by, $event_id, $account_number);

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

    $marked_by = "";


    $event_id = validate($_POST['event_id']);
    $account_number = validate($_POST['account_number']);
    $remarks = "Absent";

    $sql = "UPDATE attendance SET remarks = ?, remarked_by = ? WHERE event_id = ? AND account_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $remarks, $marked_by, $event_id, $account_number);

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