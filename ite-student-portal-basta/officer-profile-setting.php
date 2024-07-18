<!-- officer-profile-setting.php and to edit your account profile in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 13, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Officer' && $_SESSION['department'] === 'ITE') { // Check if the role is set and it's 'Officer'
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Officer Profile Settings | ITE Student Portal</title>
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
            <?php include 'layout/officer-sidebar.php'; ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Profile Settings</h1>
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
                        <div class="row">
                            <div class="col-md-3">

                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="row justify-content-center">
                                            <div class="row justify-content-center">
                                                <div class="text-center"> 
                                                    <img class="img-fluid rounded-circle"
                                                        style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;"
                                                        src="profile-pictures/<?php echo $_SESSION['profile_picture']; ?>?<?php echo time(); ?>"
                                                        alt="User profile picture">
                                                </div>
                                            </div>
                                        </div>

                                        <h3 class="profile-username text-center">
                                            <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name']; ?>
                                        </h3>
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
                                                <!-- Displaying Middle name -->
                                                <b>Role</b> <a class="float-right">
                                                    <?php echo $_SESSION['role']; ?>
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <!-- Displaying Middle name -->
                                                <b>Position</b> <a class="float-right">
                                                    <?php echo $_SESSION['position']; ?>
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
                                        </ul>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#settings"
                                                    data-toggle="tab">Settings</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="active tab-pane" id="settings">
                                                <p class="text-muted">Note: Fields marked with an asterisk (*) are required.
                                                </p>









                                                <div class="card card-primary card-outline bg-white"
                                                    for="update-profilepicture">
                                                    <div class="card-header">
                                                        <!--  changing profile picture -->
                                                        <h3 class="card-title text-center"
                                                            style="font-size: 1.25rem; font-weight: bold;">
                                                            Change Profile Picture</h3><br>
                                                        <hr>
                                                        <form style="width: 100%"
                                                            action="indexes/officer-update-profilepicture.php" method="post"
                                                            enctype="multipart/form-data">
                                                            <?php if (isset($_GET['proferror'])) { ?>
                                                                <div class="alert alert-danger">
                                                                    <?php echo $_GET['proferror']; ?>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (isset($_GET['profsuccess'])) { ?>
                                                                <div class="alert alert-success">
                                                                    <?php echo $_GET['profsuccess']; ?>
                                                                </div>
                                                            <?php } ?>

                                                            <div class="row justify-content-center">
                                                                <div class="image">
                                                                    <img class="change-profile-picture img-fluid rounded-circle"
                                                                        style="width: 500px; height: 500px; border-radius: 50%; object-fit: cover;"
                                                                        src="profile-pictures/<?php echo $_SESSION['profile_picture']; ?>?<?php echo time(); ?>"
                                                                        alt="User profile picture">
                                                                </div>
                                                            </div>

                                                            <hr>
                                                            <div class="mb-3">
                                                                <input class="form-control" type="file" id="formFile"
                                                                    name='file'>
                                                            </div>



                                                            <div class="form-group row">
                                                                <div class="offset-sm-2 col-sm-10">
                                                                    <button type="submit" value="Submit"
                                                                        class="btn btn-success"
                                                                        name='upload'>Update</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="card card-primary card-outline bg-white" for="change-password">
                                                    <div class="card-header">
                                                        <!-- changing password -->
                                                        <h3 class="card-title text-center"
                                                            style="font-size: 1.25rem; font-weight: bold;">
                                                            Change Password</h3><br>
                                                        <hr>
                                                        <?php if (isset($_GET['passerror'])) { ?>
                                                            <div class="alert alert-danger">
                                                                <?php echo $_GET['passerror']; ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if (isset($_GET['passsuccess'])) { ?>
                                                            <div class="alert alert-success">
                                                                <?php echo $_GET['passsuccess']; ?>
                                                            </div>
                                                        <?php } ?>
                                                        <form style="width: 100%"
                                                            action="indexes/officer-changepassword-be.php" method="post">
                                                            <div class="mb-3">
                                                                <!-- Current password input -->
                                                                <label for="currentPassword" class="fw-bold">Current
                                                                    Password</label>
                                                                <input type="password" class="form-control"
                                                                    name="currentPassword" placeholder="Current Password"
                                                                    required='required'>
                                                            </div>
                                                            <div class="mb-3">
                                                                <!-- new password input -->
                                                                <label for="newPassword" class="fw-bold">New
                                                                    Password</label>
                                                                <input type="password" class="form-control"
                                                                    name="newPassword" placeholder="New Password"
                                                                    required='required'>
                                                            </div>
                                                            <div class="mb-3">
                                                                <!-- retyping new password input -->
                                                                <label for="retypeNewPassword" class="fw-bold">Retype New
                                                                    Password</label>
                                                                <input type="password" class="form-control"
                                                                    name="retypeNewPassword"
                                                                    placeholder="Retype New Password" required='required'>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="offset-sm-2 col-sm-10">
                                                                    <button type="submit" value="Submit"
                                                                        class="btn btn-success">Update</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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