<?php

session_start();

include "db_conn.php";

if (isset($_POST['account_number'])&& isset($_POST['school_year'])&& isset($_POST['semester'])) {
    $account_number = $_POST['account_number'];
    $school_year = $_POST['school_year'];
    $semester = $_POST['semester'];

    // Fetch user details
    $studentsql = "SELECT * FROM user WHERE account_number = ?";
    $stmt = $conn->prepare($studentsql);
    $stmt->bind_param("s", $account_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastnameremovespace = str_replace(' ', '', $row['last_name']);
        $defaultpassword = $lastnameremovespace . $account_number;
        $defaulthashed_pass = password_hash($defaultpassword, PASSWORD_BCRYPT);

        // Update password in the database
        $update_sql = "UPDATE user SET password = ? WHERE account_number = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $defaulthashed_pass, $account_number);
        if ($update_stmt->execute()) {
            header("Location: ../developer-student-view.php?account_number=$account_number&school_year=$school_year&semester=$semester&resetSuccess=Password reset successfully");
        } else {
            header("Location: ../developer-student-view.php?account_number=$account_number&school_year=$school_year&semester=$semester&resetError=Failed to reset password");
        }
    } else {
        header("Location: ../developer-student-view.php?account_number=$account_number&school_year=$school_year&semester=$semester&resetError=Student not found");
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>