<!-- officer-announcement-addnew.php and to add new announcement in officer form.
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
        <title>Officer Announcement Add New | ITE Student Portal </title>
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
                                <h1 class="m-0">New Announcement</h1>
                            </div>
                        </div>
                    </div>
                </div>
                
                <section class="content">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card card-primary card-outline bg-white" for="new-subject">
                                    <div class="card-header">
                                        <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                                            Announcement Form</h3><br>
                                        <p class="text-muted">Note: Please be reminded that you are not able to edit the
                                            announcement after it has been posted, but you are able to delete it.</p>

                                        <hr>

                                        <?php if (isset($_GET['newaAnnouncementError'])) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $_GET['newaAnnouncementError']; ?>
                                            </div>
                                        <?php } ?>


                                        <form style="width: 100%" action="indexes/officer-add-announcement-be.php"
                                            method="post">

                                            <label for="Announcement Heading"
                                                class="col-sm-4 col-form-label">Heading</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <?php if (isset($_GET['heading'])) { ?>
                                                        <input type="text" class="form-control" id="heading" name="heading"
                                                            placeholder="(Required)" value="<?php echo $_GET['heading']; ?>">
                                                    <?php } else { ?>
                                                        <input type="text" class="form-control" id="heading" name="heading"
                                                            placeholder="(Required)">
                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <label for="announcement content"
                                                class="col-sm-4 col-form-label">Content</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <?php if (isset($_GET['content'])) { ?>
                                                        <textarea class="form-control" id="content" name="content"
                                                            placeholder="(Required)"
                                                            rows="6"><?php echo $_GET['content']; ?></textarea>
                                                    <?php } else { ?>
                                                        <textarea class="form-control" id="content" name="content"
                                                            placeholder="(Required)" rows="6"></textarea>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <label for="school_year" class="col-sm-4 col-form-label">School Year</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <?php
                                                    $schoolYearQuery = "SELECT * FROM school_year";
                                                    $result = mysqli_query($conn, $schoolYearQuery);

                                                    $schoolYears = [];
                                                    $defaultYear = '';

                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $schoolYears[] = $row;
                                                            if ($row['dfault'] == 1) {
                                                                $defaultYear = $row['school_year'];
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    <select class="form-control" id="school_year" name="school_year">
                                                        <option value="" disabled <?php if (!isset($_GET['school_year'])) echo 'selected'; ?>>(Required)</option>
                                                        <?php foreach ($schoolYears as $year) { ?>
                                                            <option value="<?php echo $year['school_year']; ?>" 
                                                                <?php 
                                                                    if (isset($_GET['school_year']) && $_GET['school_year'] == $year['school_year']) {
                                                                        echo 'selected';
                                                                    } elseif (!isset($_GET['school_year']) && $year['dfault'] == 1) {
                                                                        echo 'selected';
                                                                    }
                                                                ?>>
                                                                <?php echo $year['school_year']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <label for="semester" class="col-sm-4 col-form-label">Semester</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <?php
                                                    $query = "SELECT * FROM semester";
                                                    $result = mysqli_query($conn, $query);

                                                    $semesters = []; 
                                                    $defaultsemester = '';

                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $semesters[] = $row;
                                                            if ($row['dfault'] == 1) {
                                                                $defaultsemester = $row['semester'];
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    <select class="form-control" id="semester" name="semester">
                                                        <option value="" disabled <?php if (!isset($_GET['semester'])) echo 'selected'; ?>>(Required)</option>
                                                        <?php foreach ($semesters as $semester) { ?>
                                                            <option value="<?php echo $semester['semester']; ?>" 
                                                                <?php 
                                                                    if (isset($_GET['semester']) && $_GET['semester'] == $semester['semester']) {
                                                                        echo 'selected';
                                                                    } elseif (!isset($_GET['semester']) && $semester['dfault'] == 1) {
                                                                        echo 'selected';
                                                                    }
                                                                ?>>
                                                                <?php echo $semester['semester']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" value="Submit" name="addAnnouncement"
                                                    class="btn btn-success">Post</button>
                                                <a type="button" name="cancel" class="btn btn-secondary"
                                                    href="officer-announcement.php">Cancel</a>
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