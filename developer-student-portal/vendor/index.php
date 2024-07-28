<?php
session_start();

  include "../indexes/db_conn.php";
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


if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && $_SESSION['department'] === 'DEVELOPER') {
    header("Location: ../admin-dashboard.php?school_year=$defaultYear&semester=$defaultSemester");
    exit();
}elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'Officer' && $_SESSION['department'] === 'DEVELOPER') {
    header("Location: ../officer-dashboard.php?school_year=$defaultYear&semester=$defaultSemester");
    exit();
}elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'Student' && $_SESSION['department'] === 'DEVELOPER') {
    header("Location: ../dashboard.php?school_year=$defaultYear&semester=$defaultSemester");
    exit();
}else{
    header("Location: ../login.php");
    exit();
}
?>