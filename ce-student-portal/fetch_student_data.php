<?php
/*
fetch_student_data.php fetching student data.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 27, 2024
*/

include "indexes/db_conn.php";

if (isset($_POST['account_number'])) {
    $account_number = $_POST['account_number'];

        // Fetch student data from the database
    $query = "SELECT * FROM user WHERE account_number = '$account_number'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Prepare data to return as JSON
        $student_data = array(
            'code' => $row['code'],
            'last_name' => $row['last_name'],
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'program' => $row['program'],
            'account_number' => $row['account_number']
        );

        echo json_encode($student_data);
    } else {
        echo json_encode(array('error' => 'No student found.'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request.'));
}
?>
