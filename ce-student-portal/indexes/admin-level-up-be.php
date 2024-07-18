<?php

session_start();
include 'db_conn.php';

if (isset($_POST['account_number'], $_POST['previous_url'])) {

  function validate($data) {
      $data = trim($data); // Remove whitespace from the beginning and end of string
      $data = stripslashes($data); // Remove backslashes
      $data = htmlspecialchars($data); // Convert special characters to HTML entities
      return $data;
  }

  $account_number = validate($_POST['account_number']);
  $previous_url = $_POST['previous_url'];

  // Update the year_level based on the current value
  $query = "
    UPDATE user 
    SET year_level = CASE 
        WHEN year_level = '1' THEN '2'
        WHEN year_level = '2' THEN '3'
        WHEN year_level = '3' THEN '4'
        WHEN year_level = '4' THEN 'Graduate'
        ELSE 'Graduate'
    END 
    WHERE account_number = '$account_number'
  ";

  if ($conn->query($query) === TRUE) {
    header("Location: " . $previous_url);
    exit();
  } else {
    header("Location: " . $previous_url);
    exit();
  }
} else {

  header("Location: ../login.php");
  exit();
}
?>
