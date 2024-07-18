<!-- admin-enrolled-student-view.php and to see the student enrolled in that SY and Semester in admin form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 17, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && $_SESSION['department'] === 'ITE') { // Check if the role is set and it's 'Admin'
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Enroll Page | ITE Student Portal </title>
  <link rel="icon" type="image/png" href="favicon.ico" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include 'layout/admin-fixed-topnav.php'; ?>
    <?php include 'layout/admin-sidebar.php'; ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
              <h1>Enrolled Student</h1>
            </div>
            <div class="col-sm-6 text-right">
              <a id="addNewSubjectBtn" class="btn btn-secondary" href="admin-enrolled-students.php">
                <i class="nav-icon fas fa-solid fa-chevron-left"></i> Back to School Year and Semester
              </a>
              <a id="exportDataBtn" class="btn btn-primary"
                href="indexes/admin-ernolled-student-export.php?school_year=<?php echo $_GET['school_year']; ?>&semester=<?php echo $_GET['semester']; ?>">
                <i class="fas fa-file-export"></i> Export Data to Spreadsheet
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card card-primary card-outline bg-white" for="update-profilepicture">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-md-auto">
                  <img src="images/enrolled-student-view.webp" alt="View event avatar" style="width: 150px; height: auto;">
                </div>

                <div class="col-md">
                  <div class="table-responsive">
                    <table class="subject-info">

                      <?php
                      if (isset($_GET['school_year']) && isset($_GET['semester'])) {
                        $school_year = $_GET['school_year'];
                        $semester = $_GET['semester'];
                      } else {
                        $school_year = "Default School Year";
                        $semester = "Default Semester";
                      }
                      ?>

                      <table class="subject-info">
                        <tr>
                          <td class="col-md-3"><strong>School Year:</strong></td>
                          <td class="col-md-9"><?php echo $school_year; ?></td>
                          </td>
                        </tr>
                        <tr>
                          <td class="col-md-3"><strong>Semester:</strong></td>
                          <td class="col-md-9"><?php echo $semester; ?></td>
                          </td>
                        </tr>
                      </table>
                    </table>
                  </div>
                </div>

                <div class="col-md-auto ml-auto">
                  <a href="admin-enrolled-add.php?school_year=<?php echo $_GET['school_year']; ?>&semester=<?php echo $_GET['semester']; ?>"
                    class="btn btn-success btn-sm">+ Add Student</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Search Form -->
          <form method="GET">
            <div class="input-group mb-3">
              <input type="text" name="search_input" class="form-control col-5" placeholder="Search...">
              <div class="input-group-prepend col-2">
                <select name="column" class="form-control">
                  <option value="u.account_number">Student Number</option>
                  <option value="u.last_name">Last Name</option>
                  <option value="u.first_name">First Name</option>
                  <option value="u.middle_name">Middle Name</option>
                </select>
              </div>
              <div class="input-group-prepend col-2">
                <select name="year_level" class="form-control">
                  <option value="">Year Level</option>
                  <option value="">All</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
              </div>
              <div class="input-group-prepend col-2">
                <select name="program" class="form-control">
                  <option value="">Program</option>
                  <option value="">All</option>
                  <option value="BSIT">BSIT</option>
                  <option value="BSCS">BSCS</option>
                  <option value="BLIS">BLIS</option>
                  <option value="ACT">ACT</option>
                </select>
              </div>
              <div class="input-group-append col-1">
                <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
              </div>
            </div>
            <input type="hidden" name="school_year" value="<?php echo $school_year; ?>">
            <input type="hidden" name="semester" value="<?php echo $semester; ?>">
          </form>

          <!-- list of student table -->
          <table class="table">
            <thead>
              <tr>
                <th class="col-2">Student Number</th>
                <th class="col-2 text-center">Last Name</th>
                <th class="col-2 text-center">First Name</th>
                <th class="col-2 text-center">Middle Name</th>
                <th class="col-1 text-center">Program</th>
                <th class="col-1 text-center">Year Level</th>
                <th class="col-1 text-center">Unenroll</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (isset($_GET['search'])) {
                $search_input = $_GET['search_input'];
                $column = $_GET['column'];
                $year_level = $_GET['year_level'];
                $program = $_GET['program'];

                $conditions = array();

                if (!empty($year_level)) {
                  $conditions[] = "u.year_level = '$year_level'";
                }

                if (!empty($program)) {
                  $conditions[] = "u.program = '$program'";
                }

                $condition_string = implode(" AND ", $conditions);

                if (!empty($condition_string)) {
                  $condition_string = "AND " . $condition_string;
                }

                $studentssql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level 
                                FROM user u
                                INNER JOIN enrolled e 
                                ON u.account_number = e.account_number
                                WHERE $column LIKE '%$search_input%' 
                                AND e.school_year = '$school_year' 
                                AND e.semester = '$semester' 
                                $condition_string";

                $students = mysqli_query($conn, $studentssql);
              } else {
                $studentssql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level 
                                FROM user u
                                INNER JOIN enrolled e 
                                ON u.account_number = e.account_number
                                WHERE e.school_year = '$school_year' 
                                AND e.semester = '$semester'";

                $students = mysqli_query($conn, $studentssql);
              }

              if (mysqli_num_rows($students) > 0) {
                while ($row = mysqli_fetch_assoc($students)) {
                  ?>
                  <tr>
                    <td><?php echo $row['account_number']; ?></td>
                    <td class="text-center"><?php echo $row['last_name']; ?></td>
                    <td class="text-center"><?php echo $row['first_name']; ?></td>
                    <td class="text-center"><?php echo $row['middle_name']; ?></td>
                    <td class="text-center"><?php echo $row['program']; ?></td>
                    <td class="text-center"><?php echo $row['year_level']; ?></td>
                    <td class="text-center">
                    <?php
                        $current_url = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
                        ?>
                        <form method="POST" action="indexes/admin-unenroll.php">
                          <input type="hidden" name="account_number" value="<?php echo $row['account_number']; ?>">
                          <input type="hidden" name="school_year"
                            value="<?php echo isset($_GET['school_year']) ? htmlspecialchars($_GET['school_year']) : ''; ?>">
                          <input type="hidden" name="semester"
                            value="<?php echo isset($_GET['semester']) ? htmlspecialchars($_GET['semester']) : ''; ?>">
                          <input type="hidden" name="program"
                            value="<?php echo isset($_GET['program']) ? htmlspecialchars($_GET['program']) : ''; ?>">
                          <input type="hidden" name="year_level"
                            value="<?php echo isset($_GET['year_level']) ? htmlspecialchars($_GET['year_level']) : ''; ?>">
                          <input type="hidden" name="previous_url"
                            value="<?php echo htmlspecialchars($current_url, ENT_QUOTES, 'UTF-8'); ?>">
                          <button class="btn btn-danger btn-sm" type="submit">Unenroll</button>
                        </form>
                    </td>
                  </tr>
                  <?php
                }
              } else {
                echo "<tr><td colspan='8' class='text-center'>No students found for the specified School Year and Semester.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
    <?php include 'layout/fixed-footer.php'; ?>

    <aside class="control-sidebar control-sidebar-dark">
      </aside>
  </div>

<!-- jQuery -->
<script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="AdminLTE-3.2.0/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="AdminLTE-3.2.0/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="AdminLTE-3.2.0/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="AdminLTE-3.2.0/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="AdminLTE-3.2.0/plugins/moment/moment.min.js"></script>
    <script src="AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js"></script>
  </body>

</html>

<?php
} else {
  header("Location: login.php");
  exit();
}
?>