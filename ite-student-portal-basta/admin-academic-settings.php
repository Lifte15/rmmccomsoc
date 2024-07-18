<!-- admin-academic-settings.php and to set the SY and Semester in admin form.
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
    <title>Admin Academic Setting Page | ITE Student Portal</title>
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
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Academic Settings</h1>
              </div>
            </div>
          </div>
        </div>
        <!-- Main content -->
        <section class="content">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card card-primary card-outline bg-white" for="schoolyear">
                  <div class="card-header">
                    <div class="card-header d-flex justify-content-center align-items-center">
                      <h2 class="card-title" style="font-size: 2rem; font-weight: bold;">School Year</h2>
                    </div>

                    <?php if (isset($_GET['newaAnnouncementError'])) { ?>
                      <div class="alert alert-danger">
                        <?php echo $_GET['newaAnnouncementError']; ?>
                      </div>
                    <?php } ?>

                    <table class="table">
                      <thead>
                        <tr>
                          <th class="col-2">School Year</th>
                          <th class="col-1" >Default</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $studentssql = "SELECT * FROM school_year";
                        $result = $conn->query($studentssql);
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            $default_class = $row['dfault'] ? 'btn-success' : 'btn-primary';
                            $default_text = $row['dfault'] ? 'Default' : 'Set as Default';
                            ?>
                            <tr>
                              <td class="align-middle">
                                <?php echo $row['school_year']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <form method="post" action="indexes/school_year-action.php">
                                  <button type="submit" name="default_school_year" value="<?php echo $row['school_year']; ?>"
                                    class="btn <?php echo $default_class; ?> btn-sm"><?php echo $default_text; ?></button>
                                </form>
                              </td>
                            </tr>
                            <?php
                          }
                        } else {
                          echo "<tr><td colspan='2'>No School Year found.</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>




              <div class="col-md-6">
                <div class="card card-primary card-outline bg-white" for="semester">
                  <div class="card-header">
                    <div class="card-header d-flex justify-content-center align-items-center">
                      <h2 class="card-title" style="font-size: 2rem; font-weight: bold;">Semester</h2>
                    </div>
                    <?php if (isset($_GET['newaAnnouncementError'])) { ?>
                      <div class="alert alert-danger">
                        <?php echo $_GET['newaAnnouncementError']; ?>
                      </div>
                    <?php } ?>

                    <table class="table">
                      <thead>
                        <tr>
                          <th class="col-2">Semester</th>
                          <th class="col-1">Default</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $studentssql = "SELECT * FROM semester";
                        $result = $conn->query($studentssql);
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            $default_class = $row['dfault'] ? 'btn-success' : 'btn-primary';
                            $default_text = $row['dfault'] ? 'Default' : 'Set as Default';
                            ?>
                            <tr>
                              <td class="align-middle">
                                <?php echo $row['semester']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <form method="post" action="indexes/semester-action.php">
                                  <button type="submit" name="default_semester" value="<?php echo $row['semester']; ?>"
                                    class="btn <?php echo $default_class; ?> btn-sm"><?php echo $default_text; ?></button>
                                </form>
                              </td>
                            </tr>
                            <?php
                          }
                        } else {
                          echo "<tr><td colspan='7'>No semester found.</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
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