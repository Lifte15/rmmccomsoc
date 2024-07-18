<?php
/*
admin-event-present-student-bulk-be.php for making students present in bulk using an Excel file
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: This file handles the import of student data from an Excel file, validates the data, and inserts it into the database.
*/


session_start();
require('db_conn.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['save_excel_data'])) {

    function validate($data) {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Get uploaded file information
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    // Define allowed file extensions
    $allowed_ext = ['xls', 'csv', 'xlsx'];

    // Check if file extension is allowed
    if (in_array($file_ext, $allowed_ext)) {
        
        // Get temporary file path
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];

        try {
            // Load Excel file into a Spreadsheet object
            $spreadsheet = IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $event_id = intval($_POST['event_id']); // Get event_id from the POST request
            $updated_count = 0;

            // Iterate through each row of data, skipping the first row if it contains headers
            foreach (array_slice($data, 1) as $row) {

                if (empty($row[0])) {
                    break;
                }

                // Sanitize and extract data from each row
                $code = validate($row[0]);

                // Extract the account number from the string using regex
                preg_match('/ - (\d{10}) - /', $code, $matches);
                if (isset($matches[1])) {
                    $account_number = $matches[1];

                    // Check if the student is already in the attendance table for this event
                    $stmt = $conn->prepare("SELECT * FROM attendance WHERE event_id = ? AND account_number = ?");
                    $stmt->bind_param("is", $event_id, $account_number);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // If the student is already in the attendance table, update their remarks to present
                        $update_stmt = $conn->prepare("UPDATE attendance SET remarks = 'Present' WHERE event_id = ? AND account_number = ?");
                        $update_stmt->bind_param("is", $event_id, $account_number);
                        $update_stmt->execute();
                        $updated_count++;
                    }
                }
            }

            header("Location: ../admin-event-view.php?event_id=$event_id&newStudentSuccess=Attendance updated successfully. $updated_count students marked as present.");
            exit();

        } catch (Exception $e) {
            header("Location: ../admin-event-present-student-bulk.php?event_id=$event_id&newStudentError=" . urlencode($e->getMessage()));
            exit();
        }

    } else {
        header("Location: ../admin-event-present-student-bulk.php?event_id=$event_id&newStudentError=Invalid file format! Please upload an Excel file");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
