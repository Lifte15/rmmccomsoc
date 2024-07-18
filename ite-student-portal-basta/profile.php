<!-- profile.php and to see your profile account in student form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 21, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Student' && $_SESSION['department'] === 'ITE') { // Check if the role is set and it's 'student'
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile | ITE Student Portal</title>
        <link rel="icon" type="image/ico" href="favicon.ico">

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="AdminLTE-3.2.0/dist/css/adminlte.min.css">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <?php include 'layout/officer-fixed-topnav.php'; ?>

            <?php include 'layout/sidebar.php'; ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Profile</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                        <li class="breadcrumb-item active">User Profile</li>
                                    </ol>
                                </div>
                            </div>


                            <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-danger">
                                    <?php echo $_GET['error']; ?>
                                </div>
                            <?php } ?>

                            <?php if (isset($_GET['success'])) { ?>
                                <div class="alert alert-success">
                                    <?php echo $_GET['success']; ?>
                                </div>
                            <?php } ?>
                        </div>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="row justify-content-center">
                                            <div class="text-center">
                                                <img class="profile-picture img-fluid rounded-circle"
                                                    style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;"
                                                    src="profile-pictures/<?php echo $_SESSION['profile_picture']; ?>?<?php echo time(); ?>"
                                                    alt="User profile picture">
                                            </div>
                                        </div>

                                        <!-- Concatinating Full name -->
                                        <h3 class="text-center">
                                            <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name']; ?>
                                        </h3>
                                        <!--  diplaying username starts with @ -->
                                        <p class="text-muted text-center">@<?php echo $_SESSION['username']; ?>
                                        </p>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <!-- Displaying Lastname -->
                                                <b>Last Name</b> <a class="float-right">
                                                    <?php echo $_SESSION['last_name']; ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- Displaying First name -->
                                                <b>First Name</b> <a class="float-right">
                                                    <?php echo $_SESSION['first_name']; ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- Displaying Middle name -->
                                                <b>Middle Name</b> <a class="float-right">
                                                    <?php echo $_SESSION['middle_name']; ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- Displaying Middle name -->
                                                <b>Account Number</b> <a class="float-right">
                                                    <?php echo $_SESSION['account_number']; ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- Displaying gender -->
                                                <b>Gender</b> <a class="float-right">
                                                    <?php echo $_SESSION['gender']; ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- Displaying Phone Number -->
                                                <b>Phone Number</b>
                                                <a class="float-right">
                                                    <?php echo $_SESSION['phone_number']; ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- Displaying email -->
                                                <b>Email Address</b> <a class="float-right">
                                                    <?php echo $_SESSION['email']; ?>
                                                </a>
                                            </li>
                                            <br>
                                            <a href="profile-setting.php" class="btn btn-primary btn-block">Edit my
                                                profile</a>

                                        </ul>
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
        <!-- Bootstrap 4 -->
        <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- <script src="AdminLTE-3.2.0/dist/js/demo.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </body>

    </html>
    <?php
} else {
    header("Location: login.php");
    exit();
}
?>