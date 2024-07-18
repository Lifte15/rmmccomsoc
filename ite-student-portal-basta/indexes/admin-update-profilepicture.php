<?php
/*
admin-update-profilepicture.php and profile picture upload process in admin
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 1, 2024
Overview: This file handles the update of profile pictures for admin accounts, 
    validating input and updating the database with the new profile picture.
*/
session_start();

include "db_conn.php";

if (isset($_POST['upload'])) {

    // Get the account index and account_number from the session
    $account_number = $_SESSION['account_number']; 

    // Define file details
    $file = $account_number; 
    $file_name = $_FILES['file']['name'];   
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
    $file_loc = $_FILES['file']['tmp_name']; 
    $file_size = $_FILES['file']['size'];
    $folder = "../profile-pictures/"; 

    // Allowed file extensions
    $allowed_extensions = array('png', 'jpg', 'jpeg');

    // Validate if the file extension is allowed
    if (!in_array(strtolower($file_ext), $allowed_extensions)) { 
        header("Location: ../admin-profile-setting.php?proferror=Upload failed, file type is not supported. Please upload PNG, JPG, or JPEG file type only.");
        exit();
    }

    // Define the final file name
    $final_file = strtolower($file) . '.' . $file_ext;

    // Move the uploaded file to the specified folder
    if (move_uploaded_file($file_loc, $folder . $final_file)) {

        // Update the profile picture in the database
        $sql = "UPDATE user SET profile_picture=? WHERE account_number=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $final_file, $account_number);
        mysqli_stmt_execute($stmt);

        // Update the profile picture session
        $_SESSION['profile_picture'] = $final_file;

        header("Location: ../admin-profile-setting.php?profsuccess=Your new profile Picture has been updated successfully.");
        exit();
    } else {
        header("Location: ../admin-profile-setting.php?proferror=Upload failed.");
        exit();
    }
} else {
    header("Location: ../admin-profile-setting.php");
    exit();
}
?>