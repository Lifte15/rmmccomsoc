<!-- officer-enrolled-add.php and to enrolled the student on that SY and Semester in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 13, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && $_SESSION['department'] === 'ITE') { // Check if the role is set and it's 'Admin'
    $school_year = $_GET['school_year'];
    $semester = $_GET['semester'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Add Enrolee Page | ITE Student Portal</title>
  <link rel="icon" type="image/png" href="favicon.ico" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
              <h1>Enrolling Students</h1>
              <form method="GET">
                <input type="hidden" name="school_year" value="<?php echo isset($_GET['school_year']) ? $_GET['school_year'] : ''; ?>">
                <input type="hidden" name="semester" value="<?php echo isset($_GET['semester']) ? $_GET['semester'] : ''; ?>">
            </div>
            <div class="col-sm-6 text-right">
              <a id="addNewSubjectBtn" class="btn btn-secondary" href="admin-enrolled-student-view.php?school_year=<?php echo isset($_GET['school_year']) ? $_GET['school_year'] : ''; ?>&semester=<?php echo isset($_GET['semester']) ? $_GET['semester'] : ''; ?>"><i 
              class="nav-icon fas fa-solid fa-chevron-left"></i> Back to Enrolled Student</a>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

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
          </form>
          <!-- Students table -->
          <?php
          if (isset($_GET['search'])) {
            $program = $_GET['program'];
            $year_level = $_GET['year_level'];
            $search_input = $_GET['search_input'];
            $column = $_GET['column'];

            $conditions = array();

            if (!empty($program)) {
              $conditions[] = "u.program = '$program'";
            }
            if (!empty($year_level)) {
              $conditions[] = "u.year_level = '$year_level'";
            }
            if (!empty($search_input) && !empty($column)) {
              $conditions[] = "$column LIKE '%$search_input%'";
            }
            $condition_string = implode(" AND ", $conditions);

            if (!empty($condition_string)) {
              $studentsql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level, 
                                    e.account_number AS enrolled
                                FROM user u 
                                LEFT JOIN enrolled e 
                                ON u.account_number = e.account_number 
                                AND e.school_year = '$school_year' 
                                AND e.semester = '$semester' 
                                WHERE u.role = 'Student' 
                                AND e.account_number IS NULL 
                                AND $condition_string 
                                ORDER BY u.program ASC, u.year_level ASC, u.last_name ASC";
            } else {
              $studentsql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level 
                            FROM user u
                            LEFT JOIN enrolled e 
                            ON u.account_number = e.account_number 
                            AND e.school_year = '$school_year' 
                            AND e.semester = '$semester' 
                            WHERE u.role = 'Student' 
                            AND e.account_number IS NULL
                            ORDER BY u.program ASC, u.year_level ASC, u.last_name ASC";
            }
          } else {
            $studentsql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level, 
                                    e.account_number AS enrolled
                            FROM user u 
                            LEFT JOIN enrolled e 
                            ON u.account_number = e.account_number 
                            AND e.school_year = '$school_year' 
                            AND e.semester = '$semester' 
                            WHERE u.role = 'Student' 
                            AND e.account_number IS NULL
                            ORDER BY u.program ASC, u.year_level ASC, u.last_name ASC";
          }
          $result = $conn->query($studentsql);
          ?>
          <table class="table">
            <thead>
              <tr>
                <th class="col-2">Student Number</th>
                <th class="col-2">Last Name</th>
                <th class="col-2">First Name</th>
                <th class="col-2">Middle Name</th>
                <th class="col-1">Program</th>
                <th class="col-1">Year Level</th>
                <th class="col-1 text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                  <tr>
                    <td class="align-middle"><?php echo $row['account_number']; ?></td>
                    <td class="align-middle"><?php echo $row['last_name']; ?></td>
                    <td class="align-middle"><?php echo $row['first_name']; ?></td>
                    <td class="align-middle"><?php echo $row['middle_name']; ?></td>
                    <td class="align-middle"><?php echo $row['program']; ?></td>
                    <td class="align-middle"><?php echo $row['year_level']; ?></td>
                    <?php
                    $current_url = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
                    ?>
                    <td class="align-middle text-center">
                      <form method="POST" action="indexes/admin-enroll.php">
                        <input type="hidden" name="account_number" value="<?php echo $row['account_number']; ?>">
                        <input type="hidden" name="school_year" value="<?php echo isset($_GET['school_year']) ? htmlspecialchars($_GET['school_year']) : ''; ?>">
                        <input type="hidden" name="semester" value="<?php echo isset($_GET['semester']) ? htmlspecialchars($_GET['semester']) : ''; ?>">
                        <input type="hidden" name="program" value="<?php echo isset($_GET['program']) ? htmlspecialchars($_GET['program']) : ''; ?>">
                        <input type="hidden" name="year_level" value="<?php echo isset($_GET['year_level']) ? htmlspecialchars($_GET['year_level']) : ''; ?>">
                        <input type="hidden" name="previous_url" value="<?php echo htmlspecialchars($current_url, ENT_QUOTES, 'UTF-8'); ?>">
                        <button class="btn btn-success btn-sm" type="submit">Enroll</button>
                      </form>
                    </td>
                  </tr>
                <?php }
              } else {
                echo "<tr><td colspan='7'>No Student found.</td></tr>";
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
