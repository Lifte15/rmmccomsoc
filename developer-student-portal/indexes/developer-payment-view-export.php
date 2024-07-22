<?php
/*
admin-payment-view-export.php
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Overview: Generates an Excel export of student payment details for a specific payment type identified by payment_for_id. Prompts download of an Excel file.
*/

session_start();
include "db_conn.php";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && isset($_GET['payment_for_id'])) {
    $payment_for_id = $_GET['payment_for_id'];

    // Fetch payment details
    $paymentsql = "SELECT * FROM payment_for WHERE payment_for_id = '$payment_for_id'";
    $result = $conn->query($paymentsql);
    if ($result && $result->num_rows > 0) {
        $payment = $result->fetch_assoc();

        // Set filename
        $filename = $payment['payment_description'] . ' - ' . $payment['school_year'] . ' - ' . $payment['semester'] . '.xls';

        // Fetch student details
        $query = "SELECT user.account_number, user.first_name, user.last_name, user.program, user.year_level, payment.date_paid, payment.received_by, payment.remarks 
                        FROM payment 
                        JOIN user ON payment.account_number = user.account_number 
                        WHERE payment.payment_for_id = '$payment_for_id'
                        ORDER BY user.program ASC, user.year_level ASC, user.last_name ASC";
        $studentresult = $conn->query($query);

        // Set headers for download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Open output stream
        $output = fopen("php://output", "w");

        // Write payment details
        fputcsv($output, ['Payment Description:', $payment['payment_description']], "\t");
        fputcsv($output, ['School Year:', $payment['school_year']], "\t");
        fputcsv($output, ['Semester:', $payment['semester']], "\t");
        fputcsv($output, [], "\t");  // Empty line

        // Write column headers
        fputcsv($output, ['Student Number', 'Last Name', 'First Name', 'Program', 'Year Level', 'Date Paid', 'Received By', 'Remarks'], "\t");

        // Write student data
        if ($studentresult && $studentresult->num_rows > 0) {
            while ($studentrow = $studentresult->fetch_assoc()) {
                // Convert date format from '20/06/2024' to 'June 06, 2024'
                if ($studentrow['date_paid'] !== '0000-00-00') {
                    $date_paid_formatted = date('F d, Y', strtotime($studentrow['date_paid']));
                    $studentrow['date_paid'] = $date_paid_formatted;
                } else {
                    $studentrow['date_paid'] = '';
                }
                fputcsv($output, $studentrow, "\t");
            }
        } else {
            fputcsv($output, ['No students found'], "\t");
        }

        // Close output stream
        fclose($output);
        exit();
    } else {
        echo "Event not found.";
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
