<!-- admin-announcement.php announcement in admin form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 12, 2024
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
    <title>Admin Announcement Page | ITE Student Portal </title>
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
        <section class="content-header">
          <div class="container-fluid">

            <!-- Search Form -->
            <form method="GET" action="">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group row">
                    <label for="school_year" class="col-sm-4 col-form-label">School Year</label>
                    <div class="col-sm-8">
                      <?php
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
                      <select class="form-control" id="school_year" name="school_year">
                        <option value="All" <?php if (isset($_GET['school_year']) && $_GET['school_year'] == 'All')
                          echo 'selected'; ?>>All</option>
                        <?php foreach ($schoolYears as $year) { ?>
                          <option value="<?php echo $year['school_year']; ?>" <?php
                             if (isset($_GET['school_year']) && $_GET['school_year'] == $year['school_year']) {
                               echo 'selected';
                             } elseif (!isset($_GET['school_year']) && $year['dfault'] == 1) {
                               echo 'selected';
                             }
                             ?>>
                            <?php echo $year['school_year']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group row">
                    <label for="semester" class="col-sm-4 col-form-label">Semester</label>
                    <div class="col-sm-8">
                      <?php
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
                      ?>
                      <select class="form-control" id="semester" name="semester">
                        <option value="All" <?php if (!isset($_GET['semester']) || $_GET['semester'] == 'All')
                          echo 'selected'; ?>>All</option>
                        <?php foreach ($semesters as $semester) { ?>
                          <option value="<?php echo $semester['semester']; ?>" <?php
                             if (isset($_GET['semester']) && $_GET['semester'] == $semester['semester']) {
                               echo 'selected';
                             } elseif (!isset($_GET['semester']) && $semester['dfault'] == 1) {
                               echo 'selected';
                             }
                             ?>>
                            <?php echo $semester['semester']; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-outline-secondary">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <div class="row mb-2 align-items-center">
              <div class="col-sm-6">
                <h1>Announcements</h1>
              </div>
              <div class="col-sm-6 text-right">
                <a id="addNewOfficerBtn" class="btn btn-success" href="admin-announcement-addnew.php"><i
                    class="nav-icon fas fa-solid fa-plus"></i> Add New Announcements</a>
              </div>
            </div>

            <?php if (isset($_GET['deleteAnnouncementSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['deleteAnnouncementSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['deleteAnnouncementError'])) { ?>
              <div class="alert alert-danger">
                <?php echo $_GET['deleteAnnouncementError']; ?>
              </div>
            <?php } ?>

          </div>

          <?php
          $school_year_filter = isset($_GET['school_year']) && $_GET['school_year'] != 'All' ? $_GET['school_year'] : '';
          $semester_filter = isset($_GET['semester']) && $_GET['semester'] != 'All' ? $_GET['semester'] : '';

          $sql = "SELECT * FROM announcement";
          if ($school_year_filter || $semester_filter) {
            $sql .= " WHERE";
            if ($school_year_filter) {
              $sql .= " school_year = '$school_year_filter'";
              if ($semester_filter) {
                $sql .= " AND semester = '$semester_filter'";
              }
            } elseif ($semester_filter) {
              $sql .= " semester = '$semester_filter'";
            }
          }
          $sql .= " ORDER BY announcement_id DESC";

          $result = mysqli_query($conn, $sql);

          if (!$result) {
            echo "Error: " . mysqli_error($conn);
            exit();
          }
          ?>

          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $announcement_id = $row['announcement_id'];
              $heading = $row['heading'];
              $content = $row['content'];
              $posted_by = $row['position'];

              $sqlPostedBy = "SELECT position FROM user WHERE position = '$posted_by'";
              $resultPostedBy = mysqli_query($conn, $sqlPostedBy);
              $position = '';
              if ($resultPostedBy && mysqli_num_rows($resultPostedBy) > 0) {
                $userRow = mysqli_fetch_assoc($resultPostedBy);
                $position = $userRow['position'];
              }

              $posted_on = $row['posted_on'];
              $paragraphs = explode("\n", $content);
              $formatted_date = date("F j, Y", strtotime($posted_on));

              ?>
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-12">
                    <div class="card card-primary card-outline bg-white" for="new-subject">
                      <div class="card-header">
                        <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                          <?php echo $posted_by; ?>
                        </h3><br>
                        <p class="card-title text-center">
                          <?php echo $formatted_date; ?>
                        </p><br>
                        <hr>
                        <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                          <?php echo $heading; ?>
                        </h3><br>
                        <div class="card-body">
                          <?php
                          foreach ($paragraphs as $paragraph) {
                            echo "<p class='card-text'>$paragraph</p>";
                          }
                          ?>
                          </p><br>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                          <a href='admin-announcement-delete.php?announcement_id=<?php echo $row['announcement_id']; ?>'
                            class='btn btn-danger btn-sm'><i class="nav-icon fas fa-solid fa-trash"></i> Delete</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            echo "<div class='col-12 text-center row justify-content-center align-items-center' style='height: 50vh;'><h2><strong>No posted announcement</strong></h2></div>";
          }
          ?>
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