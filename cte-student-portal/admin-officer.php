<!-- admin-officer.php and to show the list of officers in admin form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 13, 2024
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
    <title>Admin Offers | CTE Student Portal</title>
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
            <div class="row mb-2 align-items-center">
              <div class="col-sm-6">
                <h1>Officer</h1>
              </div>
              <div class="col-sm-6 text-right">
                <a id="addNewOfficerBtn" class="btn btn-success" href="admin-officer-addnew.php"><i
                    class="nav-icon fas fa-solid fa-plus"></i> Add New Officer</a>
              </div>
            </div>

            <?php if (isset($_GET['resetPasswordSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['resetPasswordSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['resetPasswordFailed'])) { ?>
              <div class="alert alert-danger">
                <?php echo $_GET['resetPasswordFailed']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['newOfficerSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['newOfficerSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['deleteOfficerSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['deleteOfficerSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['editOfficerSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['editOfficerSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['deleteOfficerError'])) { ?>
              <div class="alert alert-danger">
                <?php echo $_GET['deleteOfficerError']; ?>
              </div>
            <?php } ?>

            <div class="row">

              <?php
              $sql = "SELECT * FROM user WHERE role = 'Officer' AND department='CTE'";
              $result = mysqli_query($conn, $sql);

              if (!$result) {
                echo "Error: " . mysqli_error($conn);
                exit();
              }
              ?>

              <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $username = $row['username'];
                  $account_number = $row['account_number'];
                  $position = $row['position'];
                  $last_name = $row['last_name'];
                  $first_name = $row['first_name'];
                  $profile_picture = $row['profile_picture'];
                  $phone_number = $row['phone_number'];
                  ?>
                  <div class="col-md-3">
                    <div class="card">
                      <br>
                      <div class="text-center"> 
                        <img class="profile-picture img-fluid"
                          style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;"
                          src="profile-pictures/<?php echo $profile_picture; ?>?<?php echo time(); ?>"
                          alt="User profile picture">
                      </div>
                      <div class="card-body">
                        <h1 class="text-center" style="font-size: 24px;"><strong><?php echo $username; ?></strong></h1>
                        <hr>
                        Account Number: <?php echo $account_number; ?><br>
                        Position: <?php echo $position; ?><br>
                        Last Name: <?php echo $last_name; ?><br>
                        First Name: <?php echo $first_name; ?><br>
                        Phone Number: <?php echo $phone_number; ?><br>
                        <br>
                        <div class="card-footer d-flex justify-content-center">
                          <a href='admin-officer-edit.php?account_number=<?php echo $row['account_number']; ?>'
                            class='btn btn-success btn-sm mx-2'>
                            <i class="nav-icon fas fa-solid fa-user-pen"></i> Edit
                          </a>
                          <a href='indexes/admin-officer-reset-password.php?account_number=<?php echo $row['account_number']; ?>'
                            class='btn btn-primary btn-sm mx-2'>
                            <i class="nav-icon fas fa-solid fa-rotate-right"></i> Reset Password
                          </a>
                          <a href='admin-officer-delete.php?account_number=<?php echo $row['account_number']; ?>'
                            class='btn btn-danger btn-sm mx-2'>
                            <i class="nav-icon fas fa-solid fa-trash"></i> Delete
                          </a>
                        </div>

                      </div>
                    </div>
                  </div>
                  <?php
                }
              } else {
                echo "<div class='col-12 text-center row justify-content-center align-items-center' style='height: 50vh;'><h2><strong>No officers found</strong></h2></div>";
              }
              ?>
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