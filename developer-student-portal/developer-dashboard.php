<!-- developer-dashboard.php and to see the data and the population of the student and officer in admin form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Developer' && $_SESSION['department'] === 'DEVELOPER') { // Check if the role is set and it's 'Admin'
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Dev Portal </title>
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
    <style>
      .small-box {
        position: relative;
        overflow: hidden;
      }

      .small-box .icon img {
        width: 50px;
        height: auto;
        transition: transform 0.3s ease;
        /* Smooth transition */
      }

      .small-box .icon img:hover {
        transform: scale(1.2);
        /* Scale the image to 120% */
      }

      .bg-ce {
        background-color: #F74D00 !important;
      }

      .bg-ite {
        background-color: #9A1824 !important;
      }

      .bg-ccj {
        background-color: #3D2F62 !important;
      }

      .bg-cas {
        background-color: #278A2D !important;
      }

      .bg-cte {
        background-color: #02055A !important;
      }

      .bg-cbe {
        background-color: #E9BE00 !important;
      }

      .cas-custom-background {
            background-image: url('cas-student-portal/images/student-portal-background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="images/comsoc.png" alt="AdminLTELogo" height="100" width="100">
      </div>

      <?php include 'layout/developer-fixed-topnav.php'; ?>
      <?php include 'layout/developer-sidebar.php'; ?>

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

              <!-- for number of students of ITE -->
              <?php
              $schoolYear = isset($_GET['school_year']) ? mysqli_real_escape_string($conn, $_GET['school_year']) : '';
              $semester = isset($_GET['semester']) ? mysqli_real_escape_string($conn, $_GET['semester']) : '';

              $ITEStudentquery = "SELECT COUNT(*) AS count FROM user 
                 INNER JOIN enrolled ON user.account_number = enrolled.account_number 
                 WHERE user.role = 'Student' 
                 AND enrolled.school_year = '$schoolYear' 
                 AND enrolled.semester = '$semester'
                 AND user.department='ITE'";
              $ITEStudentresult = mysqli_query($conn, $ITEStudentquery);

              if ($ITEStudentresult) {
                $ITEStudentrow = mysqli_fetch_assoc($ITEStudentresult);
                $ITEStudentcount = $ITEStudentrow['count'];
              } else {
                $ITEStudentcount = 0;
              }
              ?>


              <div class="col-lg-3 col-6">
                <div class="small-box bg-ite">
                  <div class="inner text-white">
                    <h1 style="font-size: 50px;"><strong><?php echo $ITEStudentcount; ?></strong></h1>
                    <p>ITE Student/s</p>
                  </div>
                  <div class="icon" style="position: absolute; top: 5px; right: 5px;">
                    <img src="images/ite.png" alt="CE Icon" style="width: 200px; height: auto;">
                  </div>
                </div>
              </div>


              <!-- for number of students of CE -->
              <?php

              $CEStudentquery = "SELECT COUNT(*) AS count FROM user 
                 INNER JOIN enrolled ON user.account_number = enrolled.account_number 
                 WHERE user.role = 'Student' 
                 AND enrolled.school_year = '$schoolYear' 
                 AND enrolled.semester = '$semester'
                 AND user.department='CE'";
              $CEStudentresult = mysqli_query($conn, $CEStudentquery);

              if ($CEStudentresult) {
                $CEStudentrow = mysqli_fetch_assoc($CEStudentresult);
                $CEStudentcount = $CEStudentrow['count'];
              } else {
                $CEStudentcount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-ce">
                  <div class="inner text-white">
                    <h1 style="font-size: 50px;"><strong><?php echo $CEStudentcount; ?></strong></h1>
                    <p>CE Student/s</p>
                  </div>
                  <div class="icon" style="position: absolute; top: 10px; right: 10px;">
                    <img src="images/CE.png" alt="CE Icon" style="width: 200px; height: auto;">
                  </div>
                </div>
              </div>


              <!-- for number of students of CCJ -->
              <?php

              $CCJStudentquery = "SELECT COUNT(*) AS count FROM user 
                 INNER JOIN enrolled ON user.account_number = enrolled.account_number 
                 WHERE user.role = 'Student' 
                 AND enrolled.school_year = '$schoolYear' 
                 AND enrolled.semester = '$semester'
                 AND user.department='CCJ'";
              $CCJStudentresult = mysqli_query($conn, $CCJStudentquery);

              if ($CCJStudentresult) {
                $CCJStudentrow = mysqli_fetch_assoc($CCJStudentresult);
                $CCJStudentcount = $CCJStudentrow['count'];
              } else {
                $CCJStudentcount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-ccj">
                  <div class="inner text-white">
                    <h1 style="font-size: 50px;"><strong><?php echo $CCJStudentcount; ?></strong></h1>
                    <p>CCJ Student/s</p>
                  </div>
                  <div class="icon" style="position: absolute; top: 10px; right: 10px;">
                    <img src="images/CCJ.png" alt="CE Icon" style="width: 200px; height: auto;">
                  </div>
                </div>
              </div>

              <!-- for number of students of CAS -->
              <?php

              $CASStudentquery = "SELECT COUNT(*) AS count FROM user 
                 INNER JOIN enrolled ON user.account_number = enrolled.account_number 
                 WHERE user.role = 'Student' 
                 AND enrolled.school_year = '$schoolYear' 
                 AND enrolled.semester = '$semester'
                 AND user.department='CAS'";
              $CASStudentresult = mysqli_query($conn, $CASStudentquery);

              if ($CASStudentresult) {
                $CASStudentrow = mysqli_fetch_assoc($CASStudentresult);
                $CASStudentcount = $CASStudentrow['count'];
              } else {
                $CASStudentcount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-cas">
                  <div class="inner text-white">
                    <h1 style="font-size: 50px;"><strong><?php echo $CASStudentcount; ?></strong></h1>
                    <p>CAS Student/s</p>
                  </div>
                  <div class="icon" style="position: absolute; top: 10px; right: 10px;">
                    <img src="images/CAS.png" alt="CE Icon" style="width: 200px; height: auto;">
                  </div>
                </div>
              </div>

              <!-- for number of students of CTE -->
              <?php

              $CTEStudentquery = "SELECT COUNT(*) AS count FROM user 
                 INNER JOIN enrolled ON user.account_number = enrolled.account_number 
                 WHERE user.role = 'Student' 
                 AND enrolled.school_year = '$schoolYear' 
                 AND enrolled.semester = '$semester'
                 AND user.department='CTE'";
              $CTEStudentresult = mysqli_query($conn, $CTEStudentquery);

              if ($CTEStudentresult) {
                $CTEStudentrow = mysqli_fetch_assoc($CTEStudentresult);
                $CTEStudentcount = $CTEStudentrow['count'];
              } else {
                $CTEStudentcount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-cte">
                  <div class="inner text-white">
                    <h1 style="font-size: 50px;"><strong><?php echo $CTEStudentcount; ?></strong></h1>
                    <p>CTE Student/s</p>
                  </div>
                  <div class="icon" style="position: absolute; top: 10px; right: 10px;">
                    <img src="images/CTE.png" alt="CE Icon" style="width: 200px; height: auto;">
                  </div>
                </div>
              </div>


              <!-- for number of students of CBE -->
              <?php

              $CBEStudentquery = "SELECT COUNT(*) AS count FROM user 
                 INNER JOIN enrolled ON user.account_number = enrolled.account_number 
                 WHERE user.role = 'Student' 
                 AND enrolled.school_year = '$schoolYear' 
                 AND enrolled.semester = '$semester'
                 AND user.department='CBE'";
              $CBEStudentresult = mysqli_query($conn, $CBEStudentquery);

              if ($CBEStudentresult) {
                $CBEStudentrow = mysqli_fetch_assoc($CBEStudentresult);
                $CBEStudentcount = $CBEStudentrow['count'];
              } else {
                $CBEStudentcount = 0;
              }
              ?>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-cbe">
                  <div class="inner text-white">
                    <h1 style="font-size: 50px;"><strong><?php echo $CBEStudentcount; ?></strong></h1>
                    <p>CBE Student/s</p>
                  </div>
                  <div class="icon" style="position: absolute; top: 10px; right: 10px;">
                    <img src="images/CBE.png" alt="CE Icon" style="width: 200px; height: auto;">
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


  </body>

  </html>
  <?php
} else {
  header("Location: login.php");
  exit();
}
?>