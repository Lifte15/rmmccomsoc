<!-- admin-payment.php and to add payment in admin form.
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
    <title>Admin Payment Page | ITE Student Portal </title>
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
            <div class="row mb-2 align-items-center">
              <div class="col-sm-6">
                <h1>Payments</h1>
              </div>
              <div class="col-sm-6 text-right">
                <a id="addNewPaymentBtn" class="btn btn-success" href="admin-payment-addnew.php"><i
                    class="nav-icon fas fa-solid fa-plus"></i> Add Payment</a>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">

            <!-- Search Form -->
            <form method="GET">
              <div class="input-group mb-3">
                <input type="text" name="search_input" class="form-control col-5"
                  placeholder="Search payment description">

                <div class="input-group-prepend col-2">
                  <input type="date" class="form-control" name="date" id="date">
                </div>

                <div class="input-group-prepend col-2">
                  <select name="school_year" class="form-control">
                    <option value="">School Year</option>
                    <option value="">All</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2024-2025">2024-2025</option>
                    <option value="2025-2026">2025-2026</option>
                    <option value="2026-2027">2026-2027</option>
                    <option value="2027-2028">2027-2028</option>
                    <option value="2028-2029">2028-2029</option>
                    <option value="2029-2030">2029-2030</option>
                  </select>
                </div>
                <div class="input-group-prepend col-2">
                  <select name="semester" class="form-control">
                    <option value="">Semester</option>
                    <option value="">All</option>
                    <option value="First Semester">First Semester</option>
                    <option value="Second Semester">Second Semester</option>
                    <option value="Third Semester">Third Semester</option>
                  </select>
                </div>
                <div class="input-group-append col-1">
                  <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                </div>
              </div>
            </form>

            <?php if (isset($_GET['newPaymentSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['newPaymentSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['deletePaymentSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['deletePaymentSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['deletePaymentError'])) { ?>
              <div class="alert alert-danger">
                <?php echo $_GET['deletePaymentError']; ?>
              </div>
            <?php } ?>

            <table class="table">
              <thead>
                <tr>
                  <th class="col-4">Payment Description</th>
                  <th class="col-2">Amount</th>
                  <th class="col-1">Date</th>
                  <th class="col-2 text-center">School Year</th>
                  <th class="col-1 text-center">Semester</th>
                  <th class="col-2 text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_GET['search'])) {
                  $search_input = $_GET['search_input'];
                  $date = $_GET['date'];
                  $school_year = $_GET['school_year'];
                  $semester = $_GET['semester'];

                  $conditions = array();

                  if (!empty($date)) {
                    $conditions[] = "date = '$date'";
                  }

                  if (!empty($school_year)) {
                    $conditions[] = "school_year = '$school_year'";
                  }

                  if (!empty($semester)) {
                    $conditions[] = "semester = '$semester'";
                  }

                  if (!empty($conditions)) {
                    $condition_string = implode(" AND ", $conditions);
                    $eventssql = "SELECT * FROM payment_for WHERE $condition_string AND payment_description LIKE '%$search_input%'";
                  } else {
                    $eventssql = "SELECT * FROM payment_for WHERE payment_description LIKE '%$search_input%'";
                  }
                } else {
                  $eventssql = "SELECT * FROM payment_for";
                }
                $result = $conn->query($eventssql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                      <td class="align-middle">
                        <?php echo $row['payment_description']; ?>
                      </td>
                      <td class="align-middle">₱
                        <?php echo $row['amount']; ?>
                      </td>
                      <td class="align-middle">
                        <?php echo $row['date']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $row['school_year']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $row['semester']; ?>
                      </td>
                      <td class="align-middle text-center">
                        <a href='admin-payment-view.php?payment_for_id=<?php echo $row['payment_for_id']; ?>'
                          class='btn btn-success btn-sm'><i class="nav-icon fas fa-solid fa-hand-pointer"></i> Select</a>
                        <a href='admin-payment-delete.php?payment_for_id=<?php echo $row['payment_for_id']; ?>'
                          class='btn btn-danger btn-sm'><i class="nav-icon fas fa-solid fa-trash"></i> Delete</a>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  echo "<tr><td colspan='4'>No payment found.</td></tr>";
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