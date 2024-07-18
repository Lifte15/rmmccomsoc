<!-- officer-student.php and to show the list of students registered in webpage in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: May 28, 2024
Brief overview of the file's contents. -->

<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Officer' && $_SESSION['department'] === 'ITE') {
  // Check if the user's position is not 'Staff'
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
    <title>Officer Students | ITE Student Portal</title>
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
                <h1>Students</h1>
              </div>
              <div class="col-sm-6 text-right">
                <a id="addNewStudentBtn" class="btn btn-success" href="officer-student-addnew.php"><i
                    class="nav-icon fas fa-solid fa-plus"></i> Add Student</a>
              </div>
            </div>
          </div>
        </div>
        
        <section class="content">
          <div class="container-fluid">

            <?php if (isset($_GET['newStudentSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['newStudentSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['deleteStudentSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['deleteStudentSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['deleteStudentError'])) { ?>
              <div class="alert alert-danger">
                <?php echo $_GET['deleteStudentError']; ?>
              </div>
            <?php } ?>

            <!-- Search Form -->
            <form method="GET">
              <div class="input-group mb-3">
                <input type="text" name="search_input" class="form-control col-5" placeholder="Search...">

                <div class="input-group-prepend col-2">
                  <select name="column" class="form-control">
                    <option value="account_number">Student Number</option>
                    <option value="username">User Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="first_name">First Name</option>
                    <option value="middle_name">Middle Name</option>
                    <option value="year_level">Year Level</option>
                    <option value="program">Program</option>
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
            </form>

            <?php
            include "indexes/db_conn.php";
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
            ?>

            <table class="table">
              <thead>
                <tr>
                  <th class="col-2">Student Number</th>
                  <th class="col-1">User Name</th>
                  <th class="col-2 text-center">Last Name</th>
                  <th class="col-2 text-center">First Name</th>
                  <th class="col-1 text-center">Middle Name</th>
                  <th class="col-1 text-center">Program</th>
                  <th class="col-1 text-center">Year Level</th>
                  <th class="col-2 text-center">Action</th>
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
                    $conditions[] = "year_level = '$year_level'";
                  }

                  if (!empty($program)) {
                    $conditions[] = "program = '$program'";
                  }

                  $condition_string = implode(" AND ", $conditions);

                  if (!empty($condition_string)) {
                    $studentssql = "SELECT * FROM user WHERE $condition_string AND $column LIKE '%$search_input%' AND role = 'Student' ORDER BY program ASC, year_level ASC, last_name ASC";
                  } else {
                    $studentssql = "SELECT * FROM user WHERE $column LIKE '%$search_input%' AND role = 'Student' ORDER BY program ASC, year_level ASC, last_name ASC";
                  }
                } else {
                  $studentssql = "SELECT * FROM user WHERE role = 'Student' ORDER BY program ASC, year_level ASC, last_name ASC";
                }
                $result = $conn->query($studentssql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                      <td class="align-middle">
                        <?php echo $row['account_number']; ?>
                      </td>
                      <td class="align-middle">
                        <?php echo $row['username']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $row['last_name']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $row['first_name']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $row['middle_name']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $row['program']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $row['year_level']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <a href='officer-student-view.php?account_number=<?php echo $row['account_number']; ?>&school_year=<?php echo $defaultYear; ?>&semester=<?php echo $defaultSemester; ?>'
                          class='btn btn-success btn-sm'><i class="nav-icon fas fa-solid fa-hand-pointer"></i> Select</a>
                        <a href='officer-student-delete.php?account_number=<?php echo $row['account_number']; ?>'
                          class='btn btn-danger btn-sm'><i class="nav-icon fas fa-solid fa-trash"></i> Delete</a>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  echo "<tr><td colspan='7'>No students found.</td></tr>";
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
    <!-- overlayScrollbars -->
    <script src="AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="AdminLTE-3.2.0/dist/js/adminlte.js"></script>
  </body>

  </html>
  <?php
} else {
  header("Location: login.php");
  exit();
}
?>