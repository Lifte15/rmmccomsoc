<!-- admin-dashboard.php and to see the data and the population of the student and officer in admin form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && $_SESSION['department'] === 'CTE') { // Check if the role is set and it's 'Admin'
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | CTE Student Portal </title>
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
      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="images/ite.png" alt="AdminLTELogo" height="60" width="60">
      </div>

      <?php include 'layout/admin-fixed-topnav.php'; ?>
      <?php include 'layout/admin-sidebar.php'; ?>

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


            <!-- For number of officers -->
            <div class="row">
              <?php
              $officerquery = "SELECT COUNT(*) AS count FROM user WHERE role = 'Officer' AND department='CTE'";
              $officerresult = mysqli_query($conn, $officerquery);

              $rofficerow = mysqli_fetch_assoc($officerresult);
              $officercount = $rofficerow['count'];
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h1 style="font-size: 50px;"><strong><?php echo $officercount; ?></strong></h1>
                    <p>Officer/s</p>
                  </div>
                  <div class="icon">
                    <i class="nav-icon fas fa-solid fa-user-tie"></i>
                  </div>
                  <a href="admin-officer.php" class="small-box-footer">More info <i
                      class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>




              <!-- for number of students -->
              <?php
              $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
              $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';

              $studentquery = "SELECT COUNT(*) AS count FROM user 
                 INNER JOIN enrolled ON user.account_number = enrolled.account_number 
                 WHERE user.role = 'Student' 
                 AND enrolled.school_year = '$schoolYear' 
                 AND enrolled.semester = '$semester'
                 AND user.department = 'CTE'";
              $studentresult = mysqli_query($conn, $studentquery);

              if ($studentresult) {
                $studentrow = mysqli_fetch_assoc($studentresult);
                $studentcount = $studentrow['count'];
              } else {
                $studentcount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h1 style="font-size: 50px;"><strong><?php echo $studentcount; ?></strong></h1>
                    <p>Student/s</p>
                  </div>
                  <div class="icon">
                    <i class="nav-icon fas fa-solid fa-users"></i>
                  </div>
                  <a href="admin-enrolled-student-view.php?school_year=<?php echo urlencode($schoolYear); ?>&semester=<?php echo urlencode($semester); ?>"
                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>




              <!-- for number of events -->
              <?php

              $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
              $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';

              $eventsquery = "SELECT COUNT(*) AS count FROM events 
                 WHERE events.school_year = '$schoolYear' 
                 AND events.semester = '$semester'
                 AND events.department='CTE'";
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
                  <a href="admin-events.php?search_input=&date=&school_year=<?php echo urlencode($schoolYear); ?>&semester=<?php echo urlencode($semester); ?>&search="
                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <!-- for number of payments -->
              <?php

              $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
              $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';

              $paymentforquery = "SELECT COUNT(*) AS count FROM payment_for
                 WHERE payment_for.school_year = '$schoolYear' 
                 AND payment_for.semester = '$semester'
                 AND payment_for.department = 'CTE'";
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
                  <a href="admin-payment.php?search_input=&date=&school_year=<?php echo urlencode($schoolYear); ?>&semester=<?php echo urlencode($semester); ?>&search="
                    class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>





              <!-- Program Population -->
              <div class="col-lg-6 col-6">
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Program Population</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <canvas id="donutChart"
                      style="min-height: 250px; height: 500px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>

              <!-- Year Level Population -->
              <div class="col-lg-6 col-6">
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Year Level Polulation</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <canvas id="yearLevelChart"
                      style="min-height: 250px; height: 500; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>




            </div>


        </section>
      </div>
      <?php include 'layout/fixed-footer.php'; ?>

      <aside class="control-sidebar control-sidebar-dark">
      </aside>
    </div>
    <script src="AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>



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

    <!-- for program population -->
    <?php
  
    $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
    $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';

    // BEEd
    $BEEdProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BEEd' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BEEdProgramresult = mysqli_query($conn, $BEEdProgramquery);

    if ($BEEdProgramresult) {
      $BEEdProgramrow = mysqli_fetch_assoc($BEEdProgramresult);
      $BEEdProgramCount = $BEEdProgramrow['count'];
    } else {
      $BEEdProgramCount = 0;
    }

    // BECEd
    $BECEdProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BECEd' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BECEdProgramresult = mysqli_query($conn, $BECEdProgramquery);

    if ($BECEdProgramresult) {
      $BECEdProgramrow = mysqli_fetch_assoc($BECEdProgramresult);
      $BECEdProgramCount = $BECEdProgramrow['count'];
    } else {
      $BECEdProgramCount = 0;
    }

    // BCAEd
    $BCAEdProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BCAEd' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BCAEdProgramresult = mysqli_query($conn, $BCAEdProgramquery);

    if ($BCAEdProgramresult) {
      $BCAEdProgramrow = mysqli_fetch_assoc($BCAEdProgramresult);
      $BCAEdProgramCount = $BCAEdProgramrow['count'];
    } else {
      $BCAEdProgramCount = 0;
    }

    // BPEd
    $BPEdProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BPEd' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BPEdProgramresult = mysqli_query($conn, $BPEdProgramquery);

    if ($BPEdProgramresult) {
      $BPEdProgramrow = mysqli_fetch_assoc($BPEdProgramresult);
      $BPEdProgramCount = $BPEdProgramrow['count'];
    } else {
      $BPEdProgramCount = 0;
    }

    // BTLEd
    $BTLEdProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BTLEd' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BTLEdProgramresult = mysqli_query($conn, $BTLEdProgramquery);

    if ($BTLEdProgramresult) {
      $BTLEdProgramrow = mysqli_fetch_assoc($BTLEdProgramresult);
      $BTLEdProgramCount = $BTLEdProgramrow['count'];
    } else {
      $BTLEdProgramCount = 0;
    }

    // BSEd_English
    $BSEd_EnglishProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BSEd-English' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BSEd_EnglishProgramresult = mysqli_query($conn, $BSEd_EnglishProgramquery);

    if ($BSEd_EnglishProgramresult) {
      $BSEd_EnglishProgramrow = mysqli_fetch_assoc($BSEd_EnglishProgramresult);
      $BSEd_EnglishProgramCount = $BSEd_EnglishProgramrow['count'];
    } else {
      $BSEd_EnglishProgramCount = 0;
    }

    // BSEd_Filipino
    $BSEd_FilipinoProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BSEd-Filipino' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BSEd_FilipinoProgramresult = mysqli_query($conn, $BSEd_FilipinoProgramquery);

    if ($BSEd_FilipinoProgramresult) {
      $BSEd_FilipinoProgramrow = mysqli_fetch_assoc($BSEd_FilipinoProgramresult);
      $BSEd_FilipinoProgramCount = $BSEd_FilipinoProgramrow['count'];
    } else {
      $BSEd_FilipinoProgramCount = 0;
    }

    // BSEd_Math
    $BSEd_MathProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BSEd-Math' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BSEd_MathProgramresult = mysqli_query($conn, $BSEd_MathProgramquery);

    if ($BSEd_MathProgramresult) {
      $BSEd_MathProgramrow = mysqli_fetch_assoc($BSEd_MathProgramresult);
      $BSEd_MathProgramCount = $BSEd_MathProgramrow['count'];
    } else {
      $BSEd_MathProgramCount = 0;
    }

    // BSEd_Science
    $BSEd_ScienceProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BSEd-Science' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BSEd_ScienceProgramresult = mysqli_query($conn, $BSEd_ScienceProgramquery);

    if ($BSEd_ScienceProgramresult) {
      $BSEd_ScienceProgramrow = mysqli_fetch_assoc($BSEd_ScienceProgramresult);
      $BSEd_ScienceProgramCount = $BSEd_ScienceProgramrow['count'];
    } else {
      $BSEd_ScienceProgramCount = 0;
    }

    // BSEd_Social_Studies
    $BSEd_Social_StudiesProgramquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.program = 'BSEd-Social Studies' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'";
    $BSEd_Social_StudiesProgramresult = mysqli_query($conn, $BSEd_Social_StudiesProgramquery);

    if ($BSEd_Social_StudiesProgramresult) {
      $BSEd_Social_StudiesProgramrow = mysqli_fetch_assoc($BSEd_Social_StudiesProgramresult);
      $BSEd_Social_StudiesProgramCount = $BSEd_Social_StudiesProgramrow['count'];
    } else {
      $BSEd_Social_StudiesProgramCount = 0;
    }
    ?>

    <!-- for program population -->
    <script>
      $(function () {

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var BEEdProgramCount = <?php echo $BEEdProgramCount; ?>;
        var BECEdProgramCount = <?php echo $BECEdProgramCount; ?>;
        var BCAEdProgramCount = <?php echo $BCAEdProgramCount; ?>;
        var BPEdProgramCount = <?php echo $BPEdProgramCount; ?>;
        var BTLEdProgramCount = <?php echo $BTLEdProgramCount; ?>;
        var BSEd_EnglishProgramCount = <?php echo $BSEd_EnglishProgramCount; ?>;
        var BSEd_FilipinoProgramCount = <?php echo $BSEd_FilipinoProgramCount; ?>;
        var BSEd_MathProgramCount = <?php echo $BSEd_MathProgramCount; ?>;
        var BSEd_ScienceProgramCount = <?php echo $BSEd_ScienceProgramCount; ?>;
        var BSEd_Social_StudiesProgramCount = <?php echo $BSEd_Social_StudiesProgramCount; ?>;
        var donutData = {
          labels: [
            'BEEd',
            'BECEd',
            'BCAEd',
            'BPEd',
            'BTLEd',
            'BSEd-English',
            'BSEd-Filipino',
            'BSEd-Math',
            'BSEd-Science',
            'BSEd-Social Studies',
          ],
          datasets: [
            {
              data: [BEEdProgramCount, BECEdProgramCount, BCAEdProgramCount, BPEdProgramCount, BTLEdProgramCount, BSEd_EnglishProgramCount,
              BSEd_FilipinoProgramCount, BSEd_MathProgramCount, BSEd_ScienceProgramCount, BSEd_Social_StudiesProgramCount
              ],
              backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#167288', '#8CDAEC', '#B45248', '#D48C84', '#A89A49', '#D6CFA2', '#3CB464', '#9BDDB1', '#643C6A', '#36394'],
            }
          ]
        }
        var donutOptions = {
          maintainAspectRatio: false,
          responsive: true,
        }
        new Chart(donutChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions
        })
      })
    </script>

    <!-- For Year Level Population -->
    <?php

    $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
    $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';

    // 1st year
    $FirstYearquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.year_level = '1' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'
                     AND u.department='CTE'";
    $FirstYearresult = mysqli_query($conn, $FirstYearquery);

    if ($FirstYearresult) {
      $FirstYearrow = mysqli_fetch_assoc($FirstYearresult);
      $FirstYearCount = $FirstYearrow['count'];
    } else {
      $FirstYearCount = 0;
    }

    // 2nd year
    $SecondYearquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.year_level = '2' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'
                     AND u.department='CTE'";
    $SecondYearresult = mysqli_query($conn, $SecondYearquery);

    if ($SecondYearresult) {
      $SecondYearrow = mysqli_fetch_assoc($SecondYearresult);
      $SecondYearCount = $SecondYearrow['count'];
    } else {
      $SecondYearCount = 0;
    }

    // 3rd year
    $ThirdYearquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.year_level = '3' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'
                     AND u.department='CTE'";
    $ThirdYearresult = mysqli_query($conn, $ThirdYearquery);

    if ($ThirdYearresult) {
      $ThirdYearrow = mysqli_fetch_assoc($ThirdYearresult);
      $ThirdYearCount = $ThirdYearrow['count'];
    } else {
      $ThirdYearCount = 0;
    }

    // 4th year
    $FourthYearquery = "SELECT COUNT(DISTINCT u.account_number) AS count 
                     FROM user u
                     INNER JOIN enrolled e ON u.account_number = e.account_number 
                     WHERE u.role = 'Student' 
                     AND u.year_level = '4' 
                     AND e.school_year = '$schoolYear' 
                     AND e.semester = '$semester'
                     AND u.department='CTE'";
    $FourthYearresult = mysqli_query($conn, $FourthYearquery);

    if ($FourthYearresult) {
      $FourthYearrow = mysqli_fetch_assoc($FourthYearresult);
      $FourthYearCount = $FourthYearrow['count'];
    } else {
      $FourthYearCount = 0;
    }
    ?>

    <!-- for year level population -->
    <script>
      $(function () {

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var yearLevelChartCanvas = $('#yearLevelChart').get(0).getContext('2d')
        var FirstYearCount = <?php echo $FirstYearCount; ?>;
        var SecondYearCount = <?php echo $SecondYearCount; ?>;
        var ThirdYearCount = <?php echo $ThirdYearCount; ?>;
        var FourthYearCount = <?php echo $FourthYearCount; ?>;
        var donutData = {
          labels: [
            '1st Year',
            '2nd Year',
            '3rd Year',
            '4th Year',
          ],
          datasets: [
            {
              data: [FirstYearCount, SecondYearCount, ThirdYearCount, FourthYearCount],
              backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
            }
          ]
        }
        var donutOptions = {
          maintainAspectRatio: false,
          responsive: true,
        }
        new Chart(yearLevelChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions
        })
      })
    </script>
  </body>

  </html>
  <?php
} else {
  header("Location: login.php");
  exit();
}
?>