<!-- admin-payment-delete.php and to delete payments in admin form.
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
        <title>Admin Delete Payment | ITE Student Portal</title>
        <link rel="icon" type="image/png" href="favicon.ico" />

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet"
            href="AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
                                <h1 class="m-0">Delete Payment</h1>
                            </div>

                            <div class="col-sm-6 text-right">
                                <a id="addNewPaymentBtn" class="btn btn-secondary" href="admin-payment.php"><i
                                        class="nav-icon fas fa-solid fa-chevron-left"></i> Back to Payment</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <section class="content">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="card card-danger card-outline bg-white" for="new-subject">
                                    <div class="card-header">
                                        <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                                            Are you sure you want to delete this payment?</h3><br>
                                        <p class="text-muted">Note: All data cannot able to retrieve this event after
                                            deleting it including the payments of the students. </p>

                                        <hr>

                                        <?php if (isset($_GET['deleteEventError'])) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $_GET['deleteEventError']; ?>
                                            </div>
                                        <?php } ?>


                                        <form style="width: 100%" action="indexes/admin-payment-delete-be.php" method="post">
                                            <?php
                                            $payment_for_id = $_GET['payment_for_id'];
                                            $sql = "SELECT * FROM payment_for WHERE payment_for_id = $payment_for_id";
                                            $result = mysqli_query($conn, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $payment_for_id = $row['payment_for_id'];
                                                    $payment_description = $row['payment_description'];
                                                    $date = $row['date'];
                                                    $school_year = $row['school_year'];
                                                    $semester = $row['semester'];
                                                    $amount = $row['amount'];
                                                    $formatted_date = date("F j, Y", strtotime($date));
                                                    ?>


                                                    <input type="hidden" name="payment_for_id"
                                                        value="<?php echo $payment_for_id; ?>">

                                                    <!-- Payment Description -->
                                                    <label for="payment_description" class="col-sm-4 col-form-label">Payment
                                                        Description</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="payment_description"
                                                                name="payment_description" placeholder="(Required)"
                                                                value="<?php echo $payment_description; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Date of Payment Posted -->
                                                    <label for="date of payment" class="col-sm-4 col-form-label">Date of Payment
                                                        Posted</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="posted_by"
                                                                name="datedisplay" placeholder="(Required)"
                                                                value="<?php echo $formatted_date; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- School Year -->
                                                    <label for="schoolyear" class="col-sm-4 col-form-label">School
                                                        Year</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                name="schoolyear" placeholder="(Required)"
                                                                value="<?php echo $school_year; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Semester -->
                                                    <label for="semester" class="col-sm-4 col-form-label">Semester</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                name="semester" placeholder="(Required)"
                                                                value="<?php echo $semester; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Amount -->
                                                    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="amount" name="amount"
                                                                placeholder="(Required)" value="<?php echo $amount; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Submit button -->
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" value="Submit" name="deletePayment"
                                                            class="btn btn-danger">Delete</button>
                                                        <a type="button" name="cancel" class="btn btn-secondary"
                                                            href="admin-payment.php">Cancel</a>
                                                    </div>

                                                    <?php
                                                }
                                            } else {
                                                echo "<div class='col-12 text-center row justify-content-center align-items-center' style='height: 50vh;'><h2><strong>Payment not found</strong></h2></div>";
                                            }
                                            ?>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include 'layout/fixed-footer.php'; ?>
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