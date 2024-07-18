<!-- admin-payment-edit.php and to edit payments in admin form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 17, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'  && $_SESSION['department'] === 'CE') { // Check if the role is set and it's 'Admin'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Edit Payment | CE Student Portal </title>
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
                            <h1>Edit Payment Information</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline bg-white" for="new-subject">
                                <div class="card-header">
                                    <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                                        Edit Payment</h3><br>
                                    <hr>

                                    <form action="indexes/admin-payment-edit-be.php" method="post">

                                        <?php
                                        $payment_for_id = $_GET['payment_for_id'];

                                        $query = "SELECT * FROM payment_for WHERE payment_for_id = ?";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("i", $payment_for_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows == 1) {
                                            $paymentfor = $result->fetch_assoc();
                                        } else {
                                            echo "Payment not found.";
                                            exit();
                                        }

                                        $schoolYearSql = "SELECT school_year FROM school_year"; 
                                        $schoolYearResult = $conn->query($schoolYearSql);

                                        $semesterSql = "SELECT semester FROM semester"; 
                                        $semesterResult = $conn->query($semesterSql);
                                        ?>

                                        <?php if (isset($_GET['editPaymentforError'])) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $_GET['editPaymentforError']; ?>
                                            </div>
                                        <?php } ?>

                                        <input type="hidden" name="payment_for_id" value="<?php echo $paymentfor['payment_for_id']; ?>">

                                        <div class="form-group">
                                            <label for="paymentforname">Payment Description</label>
                                            <input type="text" class="form-control" id="paymentfor_name" name="payment_description"
                                                   value="<?php echo $paymentfor['payment_description']; ?>" >
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control" name="date" id="date"
                                                   value="<?php echo $paymentfor['date']; ?>" >
                                        </div>

                                        <div class="form-group">
                                            <label for="school_year">School Year</label>
                                            <select class="form-control" id="school_year" name="school_year" required>
                                                <?php
                                                if ($schoolYearResult && $schoolYearResult->num_rows > 0) {
                                                    while ($schoolYearRow = $schoolYearResult->fetch_assoc()) {
                                                        $selected = ($schoolYearRow['school_year'] == $paymentfor['school_year']) ? 'selected' : '';
                                                        echo "<option value='{$schoolYearRow['school_year']}' $selected>{$schoolYearRow['school_year']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="semester">Semester</label>
                                            <select class="form-control" id="semester" name="semester" required>
                                                <?php
                                                if ($semesterResult && $semesterResult->num_rows > 0) {
                                                    while ($semesterRow = $semesterResult->fetch_assoc()) {
                                                        $selected = ($semesterRow['semester'] == $paymentfor['semester']) ? 'selected' : '';
                                                        echo "<option value='{$semesterRow['semester']}' $selected>{$semesterRow['semester']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                   value="<?php echo $paymentfor['amount']; ?>" >
                                        </div>

                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" value="Submit" name="editpaymentfor"
                                                    class="btn btn-success">Edit</button>
                                            <a type="button" name="cancel" class="btn btn-secondary"
                                            href='admin-payment-view.php?payment_for_id=<?php echo $_GET['payment_for_id']; ?>'>Cancel</a>
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
