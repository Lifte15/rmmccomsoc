<?php
session_start();

include "db_conn.php"; // include the database script to establish a connection with the database

// check if the fields in the form are set
if (isset($_POST['login'])) {

    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data); // Remove whitespace from the beginning and end of string
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize and validate 
    $role = validate($_POST['role']);
    $accountnumber = validate($_POST['accountnumber']);
    $password = validate($_POST['password']);

    // Construct user data string
    $user_data = 'role=' . $role . '&accountnumber=' . $accountnumber;

    // Validate account number if empty
    if (empty($accountnumber)) {
        header("Location: ../login.php?login-error=Account is required&$user_data");
        exit();
    } // Validate password if empty
    elseif (empty($password)) {
        header("Location: ../login.php?login-error=Password is required&$user_data");
        exit();
    } else {

        $query = "SELECT * FROM semester";
        $result = mysqli_query($conn, $query);
        $semesters = [];
        $defaultSemester = '';
      
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $semesters[] = $row;
            if ($row['dfault'] == 1) {
              $defaultSemester = $row['semester'];
            }
          }
        }
      
        $schoolYearQuery = "SELECT * FROM school_year";
        $result = mysqli_query($conn, $schoolYearQuery);
        $schoolYears = [];
        $defaultYear = '';
      
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $schoolYears[] = $row;
            if ($row['dfault'] == 1) {
              $defaultYear = $row['school_year'];
            }
          }
        }

        // Select account based on account number and role
        $sql = "SELECT * FROM user WHERE account_number=? AND role=? AND department='CE'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $accountnumber, $role);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Validate account if exists
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // Validate if input password and stored password is equal
            if (password_verify($password, $row['password'])) {

                if ($row['is_verified'] == 0) {
                    // Account is not verified
                    $_SESSION['verify'] = true;
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['account_number'] = $row['account_number'];
                    header("Location: ../verify-email.php");
                    exit;
                }

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

                // Redirect based on user role
                if ($role == "Admin") {
                    header("Location: ../admin-dashboard.php?school_year=$defaultYear&semester=$defaultSemester");
                    exit;
                } elseif ($role == "Officer") {
                    if ($row['position'] == "Staff") {
                        header("Location: ../officer-announcement.php?school_year=$defaultYear&semester=$defaultSemester");
                        exit;
                    } else {
                        header("Location: ../officer-dashboard.php?school_year=$defaultYear&semester=$defaultSemester");
                        exit;
                    }
                } elseif ($role == "Student") {
                    header("Location: ../dashboard.php?school_year=$defaultYear&semester=$defaultSemester");
                    exit;
                }
            } else {
                header("Location: ../login.php?login-error=Incorrect User name or Password&$user_data");
                exit;
            }
        } else {
            header("Location: ../login.php?login-error=User not found, please contact your officer.&$user_data");
            exit;
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
