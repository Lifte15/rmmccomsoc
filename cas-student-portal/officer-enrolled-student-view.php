
<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Officer' && $_SESSION['department'] === 'CAS') { 
  if ($_SESSION['position'] === 'Staff') {
    header("Location: officer-announcement.php?school_year=$defaultYear&semester=$defaultSemester");
    exit();
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Officer Enroll Page | CAS Student Portal </title>
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

      <?php include 'layout/officer-fixed-topnav.php'; ?>
      <?php include 'layout/officer-sidebar.php'; ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2 align-items-center">
              <div class="col-sm-6">
                <h1>Enrolled Student</h1>
              </div>
              <div class="col-sm-6 text-right">
                <a id="addNewSubjectBtn" class="btn btn-secondary" href="officer-enrolled-students.php">
                  <i class="nav-icon fas fa-chevron-left"></i> Back to School Year and Semester
                </a>
                <a id="exportDataBtn" class="btn btn-primary"
                  href="indexes/officer-ernolled-student-export.php?school_year=<?php echo $_GET['school_year']; ?>&semester=<?php echo $_GET['semester']; ?>">
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
                    <img src="images/enrolled-student-view.webp" alt="View event avatar"
                      style="width: 150px; height: auto;">
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
                    <a href="officer-enrolled-add.php?school_year=<?php echo $_GET['school_year']; ?>&semester=<?php echo $_GET['semester']; ?>"
                      class="btn btn-success btn-sm">+ Add Student</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Search Form -->
            <form method="GET">
              <div class="form-row">
                <div class="col-md-5 mb-3">
                  <input type="text" name="search_input" class="form-control" placeholder="Search...">
                </div>
                <div class="col-md-2 mb-3">
                  <select name="column" class="form-control">
                    <option value="u.account_number">Student Number</option>
                    <option value="u.last_name">Last Name</option>
                    <option value="u.first_name">First Name</option>
                    <option value="u.middle_name">Middle Name</option>
                  </select>
                </div>
                <div class="col-md-2 mb-3">
                  <select name="year_level" class="form-control">
                    <option value="">Year Level</option>
                    <option value="">All</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                </div>
                <div class="col-md-2 mb-3">
                  <select name="program" class="form-control">
                    <option value="">Program</option>
                    <option value="">All</option>
                    <option value="BAELS">BAELS</option>
                    <option value="BAPsyc">BAPsyc</option>
                    <option value="BACommArts">BACommArts</option>
                    <option value="BSES">BSES</option>
                    <option value="BSMath">BSMath</option>
                    <option value="BSSW">BSSW</option>
                    <option value="BPA">BPA</option>
                    <option value="BPA-Dance">BPA-Dance</option>
                    <option value="BSBio">BSBio</option>
                    <option value="BSESS-FSM">BSESS-FSM</option>
                  </select>
                </div>
                <div class="col-md-1 mb-3">
                  <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                </div>
                <input type="hidden" name="school_year" value="<?php echo $school_year; ?>">
                <input type="hidden" name="semester" value="<?php echo $semester; ?>">
            </form>

            <!-- list of student table -->
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Student Number</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">Middle Name</th>
                    <th class="text-center">Program</th>
                    <th class="text-center">Year Level</th>
                    <th class="text-center">Unenroll</th>
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
                                AND u.department='CAS'
                                $condition_string";

                    $students = mysqli_query($conn, $studentssql);
                  } else {
                    $studentssql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level 
                                FROM user u
                                INNER JOIN enrolled e 
                                ON u.account_number = e.account_number
                                WHERE e.school_year = '$school_year' 
                                AND e.semester = '$semester'
                                AND u.department='CAS'";

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
                          <form method="POST" action="indexes/officer-unenroll.php">
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