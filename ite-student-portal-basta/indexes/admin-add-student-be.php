<?php
/*
admin-add-student-be.php and rocesses the addition of new students by admin, including input validation and database insertion.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 21, 2024
Overview: This file handles the addition of new students, validating admin input and inserting the student into the database.
*/

session_start();
require('db_conn.php');
require "../vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_POST['addStudent'])) {

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
    $gender = validate($_POST['gender']);
    $yearlevel = validate($_POST['yearlevel']);
    $program = validate($_POST['program']);
    $department = "ITE";

    // Convert the names to proper case
    $lastname = ucwords(strtolower($lastnameNotProper));
    $firstname = ucwords(strtolower($firstnameNotProper));
    $middlename = ucwords(strtolower($middlenameNotProper));

        // Construct user data string
        $user_data = 'accountnumber=' . $accountnumber .
        '&lastname=' . $lastname .
        '&firstname=' . $firstname .
        '&middlename=' . $middlename .
        '&program=' . $program .
        '&yearlevel=' . $yearlevel .
        '&gender=' . $gender .
        '&phonenumber=' . $phonenumber;

    // Validate account number length
    if (!preg_match('/^\d{10}$/', $accountnumber)) {
        $error_message = urlencode("Account Number must be exactly 10 digits");
        header("Location: ../admin-student-addnew.php?newStudentError=$error_message&$user_data");
        exit();
    } // Validate account number if empty
    else if (empty($accountnumber)) {
        header("Location: ../admin-student-addnew.php?newStudentError=Account Number is required&$user_data");
        exit();
    } // Validate last name if empty
    elseif (empty($lastname)) {
        header("Location: ../admin-student-addnew.php?newStudentError=Last Name is required&$user_data");
        exit();
    } // Validate first name if empty
    elseif (empty($firstname)) {
        header("Location: ../admin-student-addnew.php?newStudentError=First Name is required&$user_data");
        exit();
    } // Validate program if empty
    elseif (empty($program)) {
        header("Location: ../admin-student-addnew.php?newStudentError=Program is required&$user_data");
        exit();
    } // Validate year level if empty
    elseif (empty($yearlevel)) {
        header("Location: ../admin-student-addnew.php?newStudentError=Year level is required&$user_data");
        exit();
    } // Validate gender if empty
    elseif (empty($gender)) {
        header("Location: ../admin-student-addnew.php?newStudentError=Gender is required&$user_data");
        exit();
    } else {
        
    // Remove the spaces of the last name
    $lastnameremovespace = str_replace(' ', '', $lastname);

    

    // Set the password and hash it
    $defaultpassword = $lastnameremovespace . $accountnumber;
    $defaulthashed_pass = password_hash($defaultpassword, PASSWORD_BCRYPT);

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
    $filePath = "../qrCodeImages/". $code . ".png";
    $result->saveToFile($filePath);

    $qrcode = $code . ".png";

    // Generate the username
    $username = strtolower($first_letter) . strtolower($lastnameremovespace);

    // Set the role to "Student"
    $role = "Student";

    // Get the username of the admin who enrolled the student
    $enrolled_by = $_SESSION['username'];

    $qrcodeImage = $code . ".png";


        // Check if account number already exists
        $sql_check_existing = "SELECT * FROM user WHERE account_number=?";
        $stmt_check_existing = mysqli_prepare($conn, $sql_check_existing);
        mysqli_stmt_bind_param($stmt_check_existing, "s", $accountnumber);
        mysqli_stmt_execute($stmt_check_existing);
        $result_check_existing = mysqli_stmt_get_result($stmt_check_existing);

        // Validate account number if already exists
        if (mysqli_num_rows($result_check_existing) > 0) {
            header("Location: ../admin-student-addnew.php?newStudentError=Account Number already exists&$user_data");
            exit();
        } else {
            // Insert new student
            $sql_newstudent_query = "INSERT INTO user(account_number, code, password, username, role, last_name, first_name, middle_name, gender, phone_number, enrolled_by, year_level, program, department)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_newstudent_query = mysqli_prepare($conn, $sql_newstudent_query);
            mysqli_stmt_bind_param($stmt_newstudent_query, "ssssssssssssss", $accountnumber, $qrcode, $defaulthashed_pass, $username, $role, $lastname, $firstname, $middlename, $gender, $phonenumber, $enrolled_by, $yearlevel, $program, $department);
            $result_newstudent_query = mysqli_stmt_execute($stmt_newstudent_query);

            // Redirect based on the result of the SQL query
            if ($result_newstudent_query) {
                header("Location: ../admin-students.php?newStudentSuccess=New Student account created successfully");
                exit();
            } else {
                header("Location: ../admin-student-addnew.php?newStudentError=Failed to add new student account&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
