<?php


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
                    $marked_by = $_SESSION['last_name'] . ', ' . $_SESSION['first_name'];

                    // Check if the student is already in the attendance table for this event
                    $stmt = $conn->prepare("SELECT * FROM attendance WHERE event_id = ? AND account_number = ?");
                    $stmt->bind_param("is", $event_id, $account_number);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // If the student is already in the attendance table, update their remarks to present
                        $update_stmt = $conn->prepare("UPDATE attendance SET remarks = 'Present', remarked_by = ? WHERE event_id = ? AND account_number = ?");
                        $update_stmt->bind_param("sis", $marked_by, $event_id, $account_number);
                        $update_stmt->execute();
                        $updated_count++;
                    }
                }
            }

            header("Location: ../officer-event-view.php?event_id=$event_id&newStudentSuccess=Attendance updated successfully. $updated_count students marked as present.");
            exit();

        } catch (Exception $e) {
            header("Location: ../officer-event-present-student-bulk.php?event_id=$event_id&newStudentError=" . urlencode($e->getMessage()));
            exit();
        }

    } else {
        header("Location: ../officer-event-present-student-bulk.php?event_id=$event_id&newStudentError=Invalid file format! Please upload an Excel file");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
