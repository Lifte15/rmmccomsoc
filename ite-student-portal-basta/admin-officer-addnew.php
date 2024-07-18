<!-- admin-officer-addnew.php and to add new officer in admin form.
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
    <title>Admin Add New Officer | ITE Student Portal </title>
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
                <h1 class="m-0">Add New Officer</h1>
              </div>
            </div>
          </div>
        </div>
        
        <section class="content">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <div class="card card-primary card-outline bg-white" for="new-subject">
                  <div class="card-header">
                    <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                      New Officer</h3><br>
                    <p class="text-muted">Note: The default password is <strong>"officer123"</strong>.</p>
                    <hr>

                    <?php if (isset($_GET['newOfficerError'])) { ?>
                      <div class="alert alert-danger">
                        <?php echo $_GET['newOfficerError']; ?>
                      </div>
                    <?php } ?>


                    <form action="indexes/admin-add-officer-be.php" method="post">

                      <label for="accountnumber" class="col-sm-4 col-form-label">Account Number</label>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <?php if (isset($_GET['accountnumber'])) { ?>
                            <input type="text" class="form-control" id="accountnumber" name="accountnumber"
                              placeholder="(Required)" value="<?php echo $_GET['accountnumber']; ?>">
                          <?php } else { ?>
                            <input type="text" class="form-control" id="accountnumber" name="accountnumber"
                              placeholder="(Required)">
                          <?php } ?>
                        </div>
                      </div>

                      <label for="position" class="col-sm-4 col-form-label">Position</label>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <?php if (isset($_GET['position'])) { ?>
                            <select class="form-control" id="position" name="position">
                              <option value="" disabled <?php if ($_GET['position'] == '')
                                echo 'selected'; ?>>(Required)
                              </option>
                              <option value="President" <?php if ($_GET['position'] == 'President')
                                echo 'selected'; ?>>
                                President</option>
                              <option value="Vice-President" <?php if ($_GET['position'] == 'Vice-President')
                                echo 'selected'; ?>>Vice-President</option>
                              <option value="Secretary" <?php if ($_GET['position'] == 'Secretary')
                                echo 'selected'; ?>>
                                Secretary</option>
                              <option value="Treasurer" <?php if ($_GET['position'] == 'Treasurer')
                                echo 'selected'; ?>>
                                Treasurer</option>
                              <option value="Auditor" <?php if ($_GET['position'] == 'Auditor')
                                echo 'selected'; ?>>Auditor
                              </option>
                              <option value="Staff" <?php if ($_GET['position'] == 'Staff')
                                echo 'selected'; ?>>Staff</option>
                            </select>
                          <?php } else { ?>
                            <select class="form-control" id="position" name="position">
                              <option value="" selected disabled>(Required)</option>
                              <option value="President">President</option>
                              <option value="Vice-President">Vice-President</option>
                              <option value="Secretary">Secretary</option>
                              <option value="Treasurer">Treasurer</option>
                              <option value="Auditor">Auditor</option>
                              <option value="Staff">Staff</option>
                            </select>
                          <?php } ?>
                        </div>
                      </div>


                      <!-- Last Name input -->
                      <label for="accountnumber" class="col-sm-4 col-form-label">Last Name</label>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <?php if (isset($_GET['lastname'])) { ?>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="(Required)"
                              value="<?php echo $_GET['lastname']; ?>">
                          <?php } else { ?>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="(Required)">
                          <?php } ?>
                        </div>
                      </div>

                      <!-- First Name input -->
                      <label for="accountnumber" class="col-sm-4 col-form-label">First Name</label>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <?php if (isset($_GET['firstname'])) { ?>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="(Required)"
                              value="<?php echo $_GET['firstname']; ?>">
                          <?php } else { ?>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                              placeholder="(Required)">
                          <?php } ?>
                        </div>
                      </div>

                      <!-- Middle Name input -->
                      <label for="accountnumber" class="col-sm-4 col-form-label">Middle Name</label>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <?php if (isset($_GET['middlename'])) { ?>
                            <input type="text" class="form-control" id="middlename" name="middlename" placeholder=""
                              value="<?php echo $_GET['middlename']; ?>">
                          <?php } else { ?>
                            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="">
                          <?php } ?>
                        </div>
                      </div>

                      <label for="position" class="col-sm-4 col-form-label">Gender</label>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <?php if (isset($_GET['gender'])) { ?>
                            <select class="form-control" id="gender" name="gender">
                              <option value="" disabled <?php if ($_GET['gender'] == '')
                                echo 'selected'; ?>>(Required)
                              </option>
                              <option value="Male" <?php if ($_GET['gender'] == 'Male')
                                echo 'selected'; ?>>Male</option>
                              <option value="Female" <?php if ($_GET['gender'] == 'Female')
                                echo 'selected'; ?>>Female</option>
                            </select>
                          <?php } else { ?>
                            <select class="form-control" id="gender" name="gender">
                              <option value="" selected disabled>(Required)</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          <?php } ?>
                        </div>
                      </div>

                      <!-- Phone Number input -->
                      <label for="accountnumber" class="col-sm-4 col-form-label">Phone Number</label>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <?php if (isset($_GET['phonenumber'])) { ?>
                            <input type="text" class="form-control" id="phonenumber" name="phonenumber" placeholder=""
                              value="<?php echo $_GET['phonenumber']; ?>">
                          <?php } else { ?>
                            <input type="text" class="form-control" id="phonenumber" name="phonenumber" placeholder="">
                          <?php } ?>
                        </div>
                      </div>


                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" value="Submit" name="addOfficer" class="btn btn-success">Add</button>
                        <a type="button" name="cancel" class="btn btn-secondary" href="admin-officer.php">Cancel</a>
                      </div>

                    </form>
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