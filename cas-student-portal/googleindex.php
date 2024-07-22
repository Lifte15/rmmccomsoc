<?php
/*
googleindex.php and to login using your verified email address
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
*/

session_start();

include 'indexes/db_conn.php';
require_once 'googleconfig.php';

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $googleEmail = $google_account_info['email'];

    //checking if email is existing in the database
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND department='CAS'");
    $stmt->bind_param("s", $googleEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['role'];

        // Redirect based on user role
        if ($role == "Admin") {
            $_SESSION['account_number'] = $row['account_number'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['position'] = $row['position'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['middle_name'] = $row['middle_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['new_email'] = $row['new_email'];
            $_SESSION['program'] = $row['program'];
            $_SESSION['phone_number'] = $row['phone_number'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['code'] = $row['code'];
            $_SESSION['department'] = $row['department'];
            header("Location: admin-dashboard.php");
            exit;
        } elseif ($role == "Officer") {
            $_SESSION['account_number'] = $row['account_number'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['position'] = $row['position'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['middle_name'] = $row['middle_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['new_email'] = $row['new_email'];
            $_SESSION['program'] = $row['program'];
            $_SESSION['phone_number'] = $row['phone_number'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['code'] = $row['code'];
            $_SESSION['department'] = $row['department'];
            header("Location: officer-dashboard.php");
            exit;
        } elseif ($role == "Student") {
            $_SESSION['account_number'] = $row['account_number'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['position'] = $row['position'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['middle_name'] = $row['middle_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['new_email'] = $row['new_email'];
            $_SESSION['program'] = $row['program'];
            $_SESSION['phone_number'] = $row['phone_number'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['code'] = $row['code'];
            $_SESSION['department'] = $row['department'];
            header("Location: dashboard.php");
            exit;
        }
    } else {
        header("Location: login.php?login-error=Email Address is not registered");
        exit();
    }

} else {
    header("Location: login.php");
    exit();
}
?>
