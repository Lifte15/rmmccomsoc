<?php


session_start();
require('db_conn.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



if (isset($_POST['save_excel_data'])) {

    function validate($data) {
        $data = trim($data); 
        $data = stripslashes($data); 
        $data = htmlspecialchars($data); 
        return $data;
    }

    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $marked_by = $_SESSION['last_name'] . ', ' . $_SESSION['first_name'];
    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $event_id = intval($_POST['event_id']);
            $updated_count = 0;
            $not_present_count = 0; 
            $not_present_students = [];

            $stmt = $conn->prepare("SELECT event_name FROM events WHERE event_id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $event_name = "event_" . $event_id;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $event_name = $row['event_name'];
            }

            foreach (array_slice($data, 1) as $row) {
                if (empty($row[0])) {
                    break;
                }

                $code = validate($row[0]);

                preg_match('/^(.+) - (\d{10}) - (.+)$/', $code, $matches);
                if (isset($matches[1]) && isset($matches[2]) && isset($matches[3])) {
                    $name = $matches[1];
                    $account_number = $matches[2];
                    $program = $matches[3];

                    $stmt = $conn->prepare("SELECT * FROM attendance WHERE event_id = ? AND account_number = ?");
                    $stmt->bind_param("is", $event_id, $account_number);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $update_stmt = $conn->prepare("UPDATE attendance SET remarks = 'Present', remarked_by = ? WHERE event_id = ? AND account_number = ?");
                        $update_stmt->bind_param("sis", $marked_by, $event_id, $account_number);
                        $update_stmt->execute();
                        $updated_count++;
                    } else {
                        $not_present_students[] = [$name, $account_number, $program];
                        $not_present_count++;
                    }
                }
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Event Name');
            $sheet->getStyle('A1')->getFont()->setBold(true); 
            $sheet->setCellValue('B1', $event_name);
            $sheet->setCellValue('A2', 'Date and Time Imported');
            $sheet->getStyle('A2')->getFont()->setBold(true); 
            $sheet->setCellValue('B2', date('Y-m-d H:i:s'));
            $sheet->setCellValue('A3', 'Imported By');
            $sheet->getStyle('A3')->getFont()->setBold(true); 
            $sheet->setCellValue('B3', $marked_by);

            $sheet->setCellValue('A5', 'NOT IN THE EVENT');
            $sheet->getStyle('A5')->getFont()->setBold(true); 
            $sheet->mergeCells('A5:C5'); 
            $sheet->setCellValue('A6', 'Name');
            $sheet->getStyle('A6')->getFont()->setBold(true); 
            $sheet->setCellValue('B6', 'Student Number');
            $sheet->getStyle('B6')->getFont()->setBold(true); 
            $sheet->setCellValue('C6', 'Program');
            $sheet->getStyle('C6')->getFont()->setBold(true); 

            $sheet->fromArray($not_present_students, NULL, 'A7');

            $report_directory = 'import_attendance_report/';
            $filename = $event_name . '_' . $marked_by . '_' . date('Y-m-d_H-i-s') . '.xlsx';
            $filename = str_replace(' ', '_', $filename); 
            $filepath = 'C:/xampp/htdocs/rmmccomsoc/cas-student-portal/' . $report_directory . $filename;

            // Save the Excel file
            $writer = new Xlsx($spreadsheet);
            $writer->save($filepath);

            // Redirect with report URL
            $report_url_path = $report_directory . $filename;
            header("Location: ../officer-event-view.php?event_id=$event_id&present_count=$updated_count&not_present_count=$not_present_count&report_path=" . urlencode($report_url_path));
            exit();

        } catch (Exception $e) {
            header("Location: ../officer-event-present-student-bulk.php?event_id=$event_id&newStudentError=" . urlencode($e->getMessage()));
            exit();
        }

    } else {
        header("Location: ../officer-event-present-student-bulk.php?event_id=$event_id&newStudentError=Invalid file format! Please upload an Excel file");
        exit();
    }
}

 else {
    header("Location: ../login.php");
    exit();
}
?>
