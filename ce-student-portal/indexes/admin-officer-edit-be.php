<?php
/*
admin-officer-edit-be.php for editing officer details
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 15, 2024
Overview: This file handles the editing of officer details, validating input, and updating the database.
*/


session_start();
require ('db_conn.php');

if (isset($_POST['editOfficer'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $account_number = validate($_POST['account_number']);
    $code = validate($_POST['code']);
    $position = validate($_POST['position']);
    $lastnameNotProper = validate($_POST['last_name']);
    $firstnameNotProper = validate($_POST['first_name']);
    $middlenameNotProper = validate($_POST['middle_name']);
    $phonenumber = validate($_POST['phone_number']);
    $gender = validate($_POST['gender']);

    // Convert the names to proper case
    $lastname = ucwords(strtolower($lastnameNotProper));
    $firstname = ucwords(strtolower($firstnameNotProper));
    $middlename = ucwords(strtolower($middlenameNotProper));

    // Get the first letter of the first name
    $first_letter = substr($firstname, 0, 1);

    // Generate the username
    $username = strtolower($first_letter) . strtolower($lastname);

    // Get the username of the admin who updated the officer
    $updated_by = $_SESSION['username'];


    // Validate position if empty
    if (empty($position)) {
        header("Location: ../admin-officer-edit.php?account_number=$account_number&editOfficerError=Position is required");
        exit();
    } // Validate last name if empty
    elseif (empty($lastname)) {
        header("Location: ../admin-officer-edit.php?account_number=$account_number&editOfficerError=Last Name is required");
        exit();
    } // Validate first name if empty
    elseif (empty($firstname)) {
        header("Location: ../admin-officer-edit.php?account_number=$account_number&editOfficerError=First Name is required");
        exit();
    } // Validate gender if empty
    elseif (empty($gender)) {
        header("Location: ../admin-officer-edit.php?account_number=$account_number&editOfficerError=Gender is required");
        exit();
    } else {
            // Update officer
            $sql_updateofficer_query = "UPDATE user SET username=?, position=?, last_name=?, first_name=?, middle_name=?, gender=?, phone_number=? WHERE account_number=?";
            $stmt_updateofficer_query = mysqli_prepare($conn, $sql_updateofficer_query);
            mysqli_stmt_bind_param($stmt_updateofficer_query, "ssssssss", $username, $position, $lastname, $firstname, $middlename, $gender, $phonenumber, $account_number);
            $result_updateofficer_query = mysqli_stmt_execute($stmt_updateofficer_query);

            // Redirect based on the result of the SQL query
            if ($result_updateofficer_query) {
                header("Location: ../admin-officer.php?editOfficerSuccess=Officer account updated successfully");
                exit();
            } else {
                // Log detailed error information
                $error_message = "Failed to update officer account: " . mysqli_error($conn);
                error_log($error_message);
                header("Location: ../admin-officer-edit.php?account_number=$account_number&editOfficerError=" . urlencode($error_message) . "");
                exit();
            }
        }
    
} else {
    header("Location: ../login.php");
    exit();
}
?>