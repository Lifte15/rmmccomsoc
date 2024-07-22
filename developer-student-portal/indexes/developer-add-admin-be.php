<?php
/*
developer-add-admin-be.php and processes the addition of new admin by developer, including input validation and database insertion.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 8, 2024
Overview: This file handles the addition of new admins, validating developer input and inserting the admin into the database.
*/


session_start();
require ('db_conn.php');

if (isset($_POST['addOfficer'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $accountnumber = validate($_POST['accountnumber']);
    $lastnameNotProper = validate($_POST['lastname']);
    $firstnameNotProper = validate($_POST['firstname']);
    $middlenameNotProper = validate($_POST['middlename']);
    $phonenumber = validate($_POST['phonenumber']);
    $department = validate($_POST['department']);
    $position = "Admin";

    // Convert the names to proper case
    $lastname = ucwords(strtolower($lastnameNotProper));
    $firstname = ucwords(strtolower($firstnameNotProper));
    $middlename = ucwords(strtolower($middlenameNotProper));

    // Set the password and hashed it
    $defaultpassword = "admin123";
    $defaulthashed_pass = password_hash($defaultpassword, PASSWORD_BCRYPT);

    // Get the first letter of the first name
    $first_letter = substr($firstname, 0, 1);

    // Generate the username
    $username = strtolower($first_letter) . strtolower($lastname);

    // Set the role to "admin" and the code to random 5 digits
    $role = "Admin";
    $code = mt_rand(10000, 99999);

    // Get the username of the developer who enrolled the admin
    $enrolled_by = $_SESSION['username'];

    // Construct user data string
    $user_data = 'accountnumber=' . $accountnumber .
        '&department=' . $department .
        '&lastname=' . $lastname .
        '&firstname=' . $firstname .
        '&middlename=' . $middlename .
        '&phonenumber=' . $phonenumber;


    // Validate account number length
    if (strlen($accountnumber) > 11) {
        $error_message = urlencode("Account Number must be 11 characters or less");
        header("Location: ../developer-admin-addnew.php?newOfficerError=$error_message");
        exit();
    } // Validate account number if empty
    else if (empty($accountnumber)) {
        header("Location: ../developer-admin-addnew.php?newOfficerError=Account Number is required$user_data");
        exit();
    } // Validate position if empty
    elseif (empty($department)) {
        header("Location: ../developer-admin-addnew.php?newOfficerError=Department is required&$user_data");
        exit();
    } // Validate last name if empty
    elseif (empty($lastname)) {
        header("Location: ../developer-admin-addnew.php?newOfficerError=Last Name is required&$user_data");
        exit();
    } // Validate first name if empty
    elseif (empty($firstname)) {
        header("Location: ../developer-admin-addnew.php?newOfficerError=First Name is required&$user_data");
        exit();
    } else {
        // Check if account number already exists
        $sql_check_existing = "SELECT * FROM user WHERE account_number=?";
        $stmt_check_existing = mysqli_prepare($conn, $sql_check_existing);
        mysqli_stmt_bind_param($stmt_check_existing, "s", $accountnumber, );
        mysqli_stmt_execute($stmt_check_existing);
        $result_check_existing = mysqli_stmt_get_result($stmt_check_existing);

        // Validate account number if already exists
        if (mysqli_num_rows($result_check_existing) > 0) {
            header("Location: ../developer-admin-addnew.php?newOfficerError=Account Number already exists&$user_data");
            exit();
        } else {
            $is_verified = '1';
            // Insert new admin
            $sql_newadmin_query = "INSERT INTO user(account_number, code, password, username, role, position, last_name, first_name, middle_name, phone_number, enrolled_by, is_verified, department)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_newadmin_query = mysqli_prepare($conn, $sql_newadmin_query);
            mysqli_stmt_bind_param($stmt_newadmin_query, "sssssssssssis", $accountnumber, $code, $defaulthashed_pass, $username, $role, $position, $lastname, $firstname, $middlename, $phonenumber, $enrolled_by, $is_verified, $department);
            $result_newadmin_query = mysqli_stmt_execute($stmt_newadmin_query);

            // Redirect based on the result of the SQL query
            if ($result_newadmin_query) {
                header("Location: ../developer-admin.php?newOfficerSuccess=New Admin account created successfully");
                exit();
            } else {
                // Log detailed error information
                $error_message = "Failed to add new admin account: " . mysqli_error($conn);
                error_log($error_message);
                header("Location: ../developer-admin-addnew.php?newOfficerError=" . urlencode($error_message) . "&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>