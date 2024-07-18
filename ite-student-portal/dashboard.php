<!-- dashboard.php and to see the count of event and payment in student form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Brief overview of the file's contents. -->
<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Student' && $_SESSION['department'] === 'ITE') {
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | ITE Student Portal</title>
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
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="images/ite.png" alt="AdminLTELogo" height="60" width="60">
      </div>

      <?php include 'layout/topnav.php'; ?>
      <?php include 'layout/sidebar.php'; ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
              </div>

            </div>
          </div>
        </div>




        <section class="content">

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
                        <option value="" <?php if (!isset($_GET['semester']))
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
                      <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>


            <div class="row">
              <!-- for number of events -->
              <?php
              $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
              $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';
              $account_number = $_SESSION['account_number'];

              $eventsquery = "SELECT COUNT(*) AS count
                              FROM events
                              JOIN attendance ON events.event_id = attendance.event_id
                              WHERE events.school_year = '$schoolYear'
                                AND events.semester = '$semester'
                                AND attendance.account_number = $account_number";
              $eventsresult = mysqli_query($conn, $eventsquery);

              if ($eventsresult) {
                $eventsrow = mysqli_fetch_assoc($eventsresult);
                $eventscount = $eventsrow['count'];
              } else {
                $eventscount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                  <div class="inner">
                    <h1 style="font-size: 50px;"><strong><?php echo $eventscount; ?></strong></h1>
                    <p>Event/s</p>
                  </div>
                  <div class="icon">
                    <i class="nav-icon fas fa-solid fa-calendar-check"></i>
                  </div>
                  <a href="myattendance.php?school_year=<?php echo urlencode($schoolYear); ?>&semester=<?php echo urlencode($semester); ?>"
                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <!-- for number of payments -->
              <?php

              $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
              $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';
              $account_number = $_SESSION['account_number'];

              $paymentforquery = "SELECT COUNT(*) AS count
                              FROM payment_for
                              JOIN payment ON payment_for.payment_for_id = payment.payment_for_id
                              WHERE payment_for.school_year = '$schoolYear'
                                AND payment_for.semester = '$semester'
                                AND payment.account_number = $account_number ";
              $paymentforresult = mysqli_query($conn, $paymentforquery);

              if ($paymentforresult) {
                $paymentforrow = mysqli_fetch_assoc($paymentforresult);
                $paymentforcount = $paymentforrow['count'];
              } else {
                $paymentforcount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h1 style="font-size: 50px;"><strong><?php echo $paymentforcount; ?></strong></h1>
                    <p>Payment/s</p>
                  </div>
                  <div class="icon">
                    <i class="nav-icon fas fa-solid fa-money-bill-wave"></i>
                  </div>
                  <a href="mypayment.php?school_year=<?php echo urlencode($schoolYear); ?>&semester=<?php echo urlencode($semester); ?>"
                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
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