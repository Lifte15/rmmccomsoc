<?php
/*
admin-student-edit-be.php and student update process in admin
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: May 28, 2024
Overview: This file handles the updating of student information, validating admin input and updating the student in the database.
*/
session_start();
require ('db_conn.php');
require "../vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_POST['editStudent'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate
    $accountnumber = validate($_POST['account_number']);
    $lastnameNotProper = validate($_POST['last_name']);
    $firstnameNotProper = validate($_POST['first_name']);
    $middlenameNotProper = validate($_POST['middle_name']);
    $email = validate($_POST['email']);
    $phonenumber = validate($_POST['phone_number']);
    $gender = validate($_POST['gender']);
    $yearlevel = validate($_POST['year_level']);
    $program = validate($_POST['program']);

    // Convert the names to proper case
    $lastname = ucwords(strtolower($lastnameNotProper));
    $firstname = ucwords(strtolower($firstnameNotProper));
    $middlename = ucwords(strtolower($middlenameNotProper));

    // Remove the spaces of the last name
    $lastnameremovespace = str_replace(' ', '', $lastname);


    // Get the first letter of the first name
    $first_letter = substr($firstname, 0, 1);

    // Get the first letter of the middle name
    $first_letter_middlename = substr($middlename, 0, 1);

    // Generate the code
    $code = strtoupper($lastname . " , " . $firstname . " " . $first_letter_middlename . ". - " . $accountnumber . " - " . $program);

    // Generate the QR code
    $qr_code = QrCode::create($code);

    $writer = new PngWriter;
    $result = $writer->write($qr_code);

    // Define the file path for the QR code
    $filePath = "../qrCodeImages/" . $code . ".png";
    $result->saveToFile($filePath);

    $qrcode = $code . ".png";

    // Generate the username
    $username = strtolower($first_letter) . strtolower($lastnameremovespace);

    // Set the role to "Student"
    $role = "Student";

    // Construct user data string
    $user_data = 'accountnumber=' . $accountnumber .
        '&lastname=' . $lastname .
        '&firstname=' . $firstname .
        '&middlename=' . $middlename .
        '&program=' . $program .
        '&yearlevel=' . $yearlevel .
        '&gender=' . $gender .
        '&phonenumber=' . $phonenumber;

    if (empty($accountnumber)) {
        header("Location: ../admin-student-edit.php?account_number=$accountnumber&editStudentError=Account Number is required&$user_data");
        exit();
    } // Validate last name if empty
    elseif (empty($lastname)) {
        header("Location: ../admin-student-edit.php?account_number=$accountnumber&editStudentError=Last Name is required&$user_data");
        exit();
    } // Validate first name if empty
    elseif (empty($firstname)) {
        header("Location: ../admin-student-edit.php?account_number=$accountnumber&editStudentError=First Name is required&$user_data");
        exit();
    } // Validate program if empty
    elseif (empty($program)) {
        header("Location: ../admin-student-edit.php?account_number=$accountnumber&editStudentError=Program is required&$user_data");
        exit();
    } // Validate year level if empty
    elseif (empty($yearlevel)) {
        header("Location: ../admin-student-edit.php?account_number=$accountnumber&editStudentError=Year level is required&$user_data");
        exit();
    } // Validate gender if empty
    elseif (empty($gender)) {
        header("Location: ../admin-student-edit.php?account_number=$accountnumber&editStudentError=Gender is required&$user_data");
        exit();
    } else {

        // Update existing student
        $sql_updatestudent_query = "UPDATE user SET code=?, username=?, last_name=?, first_name=?, middle_name=?, gender=?, phone_number=?, year_level=?, program=? WHERE account_number=?";
        $stmt_updatestudent_query = mysqli_prepare($conn, $sql_updatestudent_query);
        mysqli_stmt_bind_param($stmt_updatestudent_query, "ssssssssss", $qrcode, $username, $lastname, $firstname, $middlename, $gender, $phonenumber, $yearlevel, $program, $accountnumber);
        $result_updatestudent_query = mysqli_stmt_execute($stmt_updatestudent_query);

        // Redirect based on the result of the SQL query
        if ($result_updatestudent_query) {
            header("Location: ../admin-student-view.php?account_number=$accountnumber&editStudentSuccess=Student updated successfully");
            exit();
        } else {
            header("Location: ../admin-student-view.php?account_number=$accountnumber&editStudentError=Failed to update student account&$user_data");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>