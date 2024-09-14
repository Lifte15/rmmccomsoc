<?php

session_start();
require('db_conn.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_POST['save_excel_data'])) {

    function validate($data) {
        if (is_null($data)) {
            return ''; // Return empty string if the data is null
        }
        $data = trim($data); 
        $data = stripslashes($data); 
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Ensure HTML entities are properly handled
        return $data;
    }

    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach (array_slice($data, 4) as $row) {

                if (empty($row[0])) {
                    break;
                }

                $accountnumber = validate($row[0]);

                if (!preg_match('/^\d{10}$/', $accountnumber)) {
                    continue; 
                }
                
                // Ensure data is encoded in UTF-8 before processing
                $lastnameNotProper = $row[1] !== null ? mb_convert_encoding($row[1], 'UTF-8', 'auto') : '';
                $firstnameNotProper = $row[2] !== null ? mb_convert_encoding($row[2], 'UTF-8', 'auto') : '';
                $middlenameNotProper = $row[3] !== null ? mb_convert_encoding($row[3], 'UTF-8', 'auto') : '';
                
                $program = validate($row[4]);
                $yearlevel = validate($row[5]);
                $gender = validate($row[6]);
                $phonenumberdefault = validate($row[7]);
                
                if (!empty($phonenumberdefault) && !preg_match('/^9\d{9}$/', $phonenumberdefault)) {
                    $phonenumber = '';
                } else {
                    $phonenumber = empty($phonenumberdefault) ? '' : "0" . $phonenumberdefault;
                }

                $department = "ITE";

                if (empty($lastnameNotProper) || empty($firstnameNotProper) || empty($program) || empty($yearlevel)) {
                    continue;
                }

                if (!preg_match('/^[a-zA-ZÑñ ]+$/u', $lastnameNotProper) || !preg_match('/^[a-zA-ZÑñ ]+$/u', $firstnameNotProper) || (!empty($middlenameNotProper) && !preg_match('/^[a-zA-ZÑñ ]+$/u', $middlenameNotProper))) {
                    continue;
                }

                if (!in_array(trim($program), ['BSIT', 'BSCS', 'BLIS', 'ACT'])) {
                    continue;
                }

                if (!in_array(trim($yearlevel), ['1', '2', '3', '4'])) {
                    continue;
                }

                if (!empty($gender) && !in_array(trim($gender), ['M', 'F'])) {
                    continue;
                }

                if (!empty($gender)) {
                    $gender = $gender == 'M' ? 'Male' : 'Female';
                } else {
                    $gender = '';  // Set gender to empty if it's not provided
                }

                $lastname = mb_convert_case($lastnameNotProper, MB_CASE_TITLE, "UTF-8");
                $firstname = mb_convert_case($firstnameNotProper, MB_CASE_TITLE, "UTF-8");
                $middlename = mb_convert_case($middlenameNotProper, MB_CASE_TITLE, "UTF-8");
                
                $lastnameremovespace = str_replace(' ', '', $lastname);

                $defaultpassword = $lastnameremovespace . $accountnumber;
                $defaulthashed_pass = password_hash($defaultpassword, PASSWORD_BCRYPT);

                $first_letter = mb_substr($firstname, 0, 1, "UTF-8");
                $first_letter_middlename = $middlename ? mb_substr($middlename, 0, 1, "UTF-8") : '';
                
                $code = strtoupper($lastname . " , " . $firstname . " " . $first_letter_middlename . ". - " . $accountnumber . " - " . $program);

                $qr_code = QrCode::create($code);

                $writer = new PngWriter;
                $result = $writer->write($qr_code);

                $filePath = "../qrCodeImages/". $code . ".png";
                $result->saveToFile($filePath);

                $qrcode = $code . ".png";
                
                $username = strtolower($first_letter) . strtolower($lastnameremovespace);
                
                $role = "Student";
                
                $enrolled_by = $_SESSION['last_name'] . ", " . $_SESSION['first_name'];

                $sql_check_account = "SELECT account_number FROM user WHERE account_number = ?";
                $stmt_check_account = mysqli_prepare($conn, $sql_check_account);
                mysqli_stmt_bind_param($stmt_check_account, "s", $accountnumber);
                mysqli_stmt_execute($stmt_check_account);
                $result_check_account = mysqli_stmt_get_result($stmt_check_account);

                if (mysqli_num_rows($result_check_account) > 0) {
                    $sql_update_student = "UPDATE user SET code = ?, password = ?, username = ?, role = ?, last_name = ?, first_name = ?, middle_name = ?, gender = ?, phone_number = ?, enrolled_by = ?, year_level = ?, program = ?, department = ?
                                            WHERE account_number = ?";
                    $stmt_update_student = mysqli_prepare($conn, $sql_update_student);
                    mysqli_stmt_bind_param($stmt_update_student, "ssssssssssssss", $qrcode, $defaulthashed_pass, $username, $role, $lastname, $firstname, $middlename, $gender, $phonenumber, $enrolled_by, $yearlevel, $program, $department, $accountnumber);
                    $result_update_student = mysqli_stmt_execute($stmt_update_student);

                    if (!$result_update_student) {
                        header("Location: ../officer-student-addnew.php?newStudentError=Failed to update student account");
                        exit();
                    }

                } else {
                    $sql_newstudent_query = "INSERT INTO user (account_number, code, password, username, role, last_name, first_name, middle_name, gender, phone_number, enrolled_by, year_level, program, department)
                                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt_newstudent_query = mysqli_prepare($conn, $sql_newstudent_query);

                    if ($stmt_newstudent_query) {
                        mysqli_stmt_bind_param($stmt_newstudent_query, "ssssssssssssss", $accountnumber, $qrcode, $defaulthashed_pass, $username, $role, $lastname, $firstname, $middlename, $gender, $phonenumber, $enrolled_by, $yearlevel, $program, $department);
                        $result_newstudent_query = mysqli_stmt_execute($stmt_newstudent_query);

                        if (!$result_newstudent_query) {
                            header("Location: ../officer-student-addnew.php?newStudentError=Failed to add new student account");
                            exit();
                        }
                    } else {
                        header("Location: ../officer-student-addnew.php?newStudentError=SQL preparation failed");
                        exit();
                    }
                }
            }

            header("Location: ../officer-students.php?newStudentSuccess=Student accounts created successfully");
            exit();

        } catch (Exception $e) {
            header("Location: ../officer-student-addbulk.php?newStudentError=" . urlencode($e->getMessage()));
            exit();
        }

    } else {
        header("Location: ../officer-student-addbulk.php?newStudentError=Invalid file format! Please upload an Excel file");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
