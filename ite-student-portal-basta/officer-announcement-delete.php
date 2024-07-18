<!-- officer-announcement-delete.php and to delete the announcement in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 2, 2024
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
        <title>Officer Announcement Delete | ITE Student Portal</title>
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

            <?php include 'layout/officer-fixed-topnav.php'; ?>
            <?php include 'layout/officer-sidebar.php'; ?>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Delete Announcement</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card card-danger card-outline bg-white" for="new-subject">
                                    <div class="card-header">
                                        <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                                            Are you sure you want to delete this announcement?</h3><br>
                                        <p class="text-muted">Note: You cannot able to retrieve this announcement after
                                            deleting it.</p>

                                        <hr>

                                        <?php if (isset($_GET['newaAnnouncementError'])) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $_GET['newaAnnouncementError']; ?>
                                            </div>
                                        <?php } ?>


                                        <form style="width: 100%" action="indexes/officer-announcement-delete-be.php"
                                            method="post">
                                            <?php
                                            $announcement_id = $_GET['announcement_id'];
                                            $sql = "SELECT a.*, u.position FROM announcement a JOIN user u ON a.position = u.position WHERE a.announcement_id = $announcement_id";
                                            $result = mysqli_query($conn, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $heading = $row['heading'];
                                                    $content = $row['content'];
                                                    $position = $row['position'];
                                                    $posted_on = $row['posted_on'];
                                                    $school_year = $row['school_year'];
                                                    $semester = $row['semester'];
                                                    $formatted_date = date("F j, Y", strtotime($posted_on));
                                                    ?>

                                                    <input type="hidden" class="form-control" id="announcement_id"
                                                        name="announcement_id" value="<?php echo $announcement_id; ?>">
                                                    <!-- Heading input -->
                                                    <label for="Announcement Heading"
                                                        class="col-sm-4 col-form-label">Heading</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="heading" name="heading"
                                                                placeholder="(Required)" value="<?php echo $heading; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Content input -->
                                                    <label for="announcement content"
                                                        class="col-sm-4 col-form-label">Content</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <textarea class="form-control" id="content" name="content"
                                                                placeholder="(Required)"
                                                                rows="15"><?php echo $content; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Posted by input -->
                                                    <label for="Announcement Posted By" class="col-sm-4 col-form-label">Posted
                                                        By</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="posted_by" name="posted_by"
                                                                placeholder="(Required)" value="<?php echo $position; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Posted on input -->
                                                    <label for="Announcement Posted On" class="col-sm-4 col-form-label">Posted
                                                        On</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="created_on_original"
                                                                name="posted_on" placeholder="(Required)"
                                                                value="<?php echo $formatted_date; ?>">
                                                            <input type="hidden" name="posted_on"
                                                                value="<?php echo $created_on; ?>">

                                                        </div>
                                                    </div>

                                                    <!-- School Year on input -->
                                                    <label for="Announcement School Year" class="col-sm-4 col-form-label">School
                                                        Year</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="school_year"
                                                                name="school_year" placeholder="(Required)"
                                                                value="<?php echo $school_year; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Semester on input -->
                                                    <label for="Announcement Semester"
                                                        class="col-sm-4 col-form-label">Semester</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="semester" name="semester"
                                                                placeholder="(Required)" value="<?php echo $semester; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- Submit button -->
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" value="Submit" name="deleteAnnouncement"
                                                            class="btn btn-danger">Delete</button>
                                                        <a type="button" name="cancel" class="btn btn-secondary"
                                                            href="officer-announcement.php">Cancel</a>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                echo "<div class='col-12 text-center row justify-content-center align-items-center' style='height: 50vh;'><h2><strong>No posted announcement</strong></h2></div>";
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