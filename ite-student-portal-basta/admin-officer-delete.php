<!-- admin-officer-delete.php and to delete officer in admin form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 13, 2024
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
        <title>Admin Delete Officer | ITE Student Portal </title>
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
                                <h1 class="m-0">Deleting Officer</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card card-danger card-outline bg-white" for="new-subject">
                                    <div class="card-header">
                                        <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                                            Are you sure you want to delete this officer?</h3><br>
                                        <p class="text-muted">Note: You can no longer retreive this account once deleted.
                                        </p>
                                        <hr>

                                        <?php if (isset($_GET['deleteOfficerError'])) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $_GET['deleteOfficerError']; ?>
                                            </div>
                                        <?php } ?>


                                        <form action="indexes/admin-officer-delete-be.php" method="post">

                                            <?php
                                            $account_number = $_GET['account_number'];
                                            $sql = "SELECT * FROM user WHERE account_number = '$account_number'";
                                            $result = mysqli_query($conn, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $account_number = $row['account_number'];
                                                    $username = $row['username'];
                                                    $position = $row['position'];
                                                    $last_name = $row['last_name'];
                                                    $first_name = $row['first_name'];
                                                    $middle_name = $row['middle_name'];
                                                    $profile_picture = $row['profile_picture'];
                                                    $enrolled_by = $row['enrolled_by'];

                                                    $displayedaccount_number = $account_number;
                                                    $displayedusername = $username;
                                                    $displayedposition = $position;
                                                    $displayedlast_name = $last_name;
                                                    $displayedfirst_name = $first_name;
                                                    $displayedmiddle_name = $middle_name;
                                                    $displayedenrolled_by = $enrolled_by;
                                                    ?>

                                                    <div class="text-center">
                                                        <img class="profile-picture img-fluid rounded-circle" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;"
                                                            src="profile-pictures/<?php echo $profile_picture; ?>?<?php echo time(); ?>"
                                                            alt="User profile picture">
                                                    </div>
                                                    <br>

                                                    <div class="form-group row">
                                                        <label for="Account Number" class="col-sm-3 col-form-label">Account
                                                            Number</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                placeholder="(Required)"
                                                                value="<?php echo $displayedaccount_number; ?>" disabled>
                                                            <input type="hidden" name="account_number"
                                                                value="<?php echo $account_number; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="Username" class="col-sm-3 col-form-label">Username</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                placeholder="(Required)" value="<?php echo $displayedusername; ?>"
                                                                disabled>
                                                            <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="Position" class="col-sm-3 col-form-label">Position</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                placeholder="(Required)" value="<?php echo $displayedposition; ?>"
                                                                disabled>
                                                            <input type="hidden" name="position" value="<?php echo $position; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="Last Name" class="col-sm-3 col-form-label">Last Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                placeholder="(Required)" value="<?php echo $displayedlast_name; ?>"
                                                                disabled>
                                                            <input type="hidden" name="last_name" value="<?php echo $last_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="First Name" class="col-sm-3 col-form-label">First Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                placeholder="(Required)" value="<?php echo $displayedfirst_name; ?>"
                                                                disabled>
                                                            <input type="hidden" name="first_name"
                                                                value="<?php echo $first_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="Middle Name" class="col-sm-3 col-form-label">Middle Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                placeholder="(Required)"
                                                                value="<?php echo $displayedmiddle_name; ?>" disabled>
                                                            <input type="hidden" name="middle_name"
                                                                value="<?php echo $middle_name; ?>">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                echo "<div class='col-12 text-center row justify-content-center align-items-center' style='height: 50vh;'><h2><strong>No posted announcement</strong></h2></div>";
                                            }
                                            ?>

                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" value="Submit" name="deleteOfficer"
                                                    class="btn btn-danger">Delete</button>
                                                <a type="button" name="cancel" class="btn btn-secondary"
                                                    href="admin-officer.php">Cancel</a>
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
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>