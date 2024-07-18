<!-- officer-event-view.php and to see the information of that event in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 20, 2024
Brief overview of the file's contents. -->

<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Officer' && $_SESSION['department'] === 'ITE') { // Check if the role is set and it's 'Admin'
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Officer Event View | ITE Student Portal</title>
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
                        <div class="row mb-2 align-items-center">
                            <div class="col-sm-6">
                                <h1>Event</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a id="addNewSubjectBtn" class="btn btn-secondary" href="officer-events.php"><i
                                        class="nav-icon fas fa-solid fa-chevron-left"></i> Back to Events</a>
                                <a href="indexes/officer-event-view-export.php?event_id=<?php echo $_GET['event_id']; ?>"
                                    class="btn btn-primary">
                                    <i class="nav-icon fas fa-file-export"></i> Export to Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <section class="content">
                    <div class="container-fluid">
                        <?php if (isset($_GET['updateEventSuccess'])) { ?>
                            <div class="alert alert-success">
                                <?php echo $_GET['updateEventSuccess']; ?>
                            </div>
                        <?php } ?>

                        <div class="card card-primary card-outline bg-white" for="update-profilepicture">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-auto">
                                        <img src="images/calendar_avatar.webp" alt="View event avatar"
                                            style="width: 150px; height: auto;">
                                    </div>

                                    <div class="col-md">
                                        <div class="table-responsive">
                                            <table class="subject-info">
                                                <?php
                                                if (isset($_GET['event_id'])) {
                                                    $event_id = $_GET['event_id'];
                                                    $eventsql = "SELECT * FROM events WHERE event_id = '$event_id'";
                                                    $result = $conn->query($eventsql);

                                                    if ($result && $result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        ?>
                                                        <table class="subject-info">
                                                            <tr>
                                                                <td class="col-md-3"><strong>Event Name:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['event_name']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-3"><strong>Date:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['date']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-3"><strong>School Year:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['school_year']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-3"><strong>Semester:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['semester']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-3"><strong>Points:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['points']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-auto ml-auto">
                                                <a href="officer-event-add-student.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-success btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-plus"></i> Add Student</a>
                                                <a href="officer-event-edit.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-secondary btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-regular fa-pen-to-square"></i> Edit event</a>
                                                <a href="officer-event-delete-student.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-danger btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-minus"></i> Delete Student</a>
                                                <a href="officer-event-present-student-bulk.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-primary btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-check"></i> Mark Bulk Student</a>
                                                <a href="officer-event-present-qrcode.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-warning btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-qrcode"></i> Scan QR Code</a>
                                            </div>
                                            <?php
                                                    } else {
                                                        echo "Event may not be existing.";
                                                    }
                                                }
                                                ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <form method="GET">
                            <input type="hidden" name="event_id"
                                value="<?php echo isset($_GET['event_id']) ? $_GET['event_id'] : ''; ?>">
                            <div class="input-group mb-3">
                                <input type="text" name="search_input" class="form-control col-5" placeholder="Search...">
                                <div class="input-group-prepend col-2">
                                    <select name="column" class="form-control">
                                        <option value="account_number">Student Number</option>
                                        <option value="username">User Name</option>
                                        <option value="last_name">Last Name</option>
                                        <option value="first_name">First Name</option>
                                        <option value="middle_name">Middle Name</option>
                                        <option value="year_level">Year Level</option>
                                        <option value="program">Program</option>
                                    </select>
                                </div>
                                <div class="input-group-prepend col-2">
                                    <select name="year_level" class="form-control">
                                        <option value="">Year Level</option>
                                        <option value="">All</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div class="input-group-prepend col-2">
                                    <select name="program" class="form-control">
                                        <option value="">Program</option>
                                        <option value="">All</option>
                                        <option value="BSIT">BSIT</option>
                                        <option value="BSCS">BSCS</option>
                                        <option value="BLIS">BLIS</option>
                                        <option value="ACT">ACT</option>
                                    </select>
                                </div>
                                <div class="input-group-append col-1">
                                    <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                                </div>
                            </div>
                        </form>

                        <?php
                        include "indexes/db_conn.php";

                        $event_id = isset($_GET['event_id']) ? $_GET['event_id'] : '';
                        $search_input = isset($_GET['search_input']) ? $_GET['search_input'] : '';
                        $column = isset($_GET['column']) ? $_GET['column'] : '';
                        $year_level = isset($_GET['year_level']) ? $_GET['year_level'] : '';
                        $program = isset($_GET['program']) ? $_GET['program'] : '';

                        $query = "SELECT user.account_number, user.username, user.first_name, user.last_name, user.middle_name, user.program, user.year_level, attendance.remarks
                        FROM attendance 
                        JOIN user ON attendance.account_number = user.account_number 
                        WHERE attendance.event_id = '$event_id'";

                        $filters = [];
                        if ($search_input && $column) {
                            $filters[] = "user.$column LIKE '%$search_input%'";
                        }
                        if ($year_level) {
                            $filters[] = "user.year_level = '$year_level'";
                        }
                        if ($program) {
                            $filters[] = "user.program = '$program'";
                        }

                        if (!empty($filters)) {
                            $query .= " AND " . implode(" AND ", $filters);
                        }

                        $query .= ' ORDER BY user.program ASC, user.year_level ASC, user.last_name ASC';
                        $studentresult = $conn->query($query);
                        ?>

                        <div class="card card-primary card-outline bg-white mt-4">
                            <div class="card-body">
                                <div class="tab-pane active" id="all">
                                    <?php if ($studentresult && $studentresult->num_rows > 0) { ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-2">Student Number</th>
                                                    <th class="col-1">User Name</th>
                                                    <th class="col-2 text-center">Last Name</th>
                                                    <th class="col-2 text-center">First Name</th>
                                                    <th class="col-1 text-center">Program</th>
                                                    <th class="col-1 text-center">Year Level</th>
                                                    <th class="col-1 text-center">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($studentrow = $studentresult->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td class="align-middle"><?php echo $studentrow['account_number']; ?></td>
                                                        <td class="align-middle"><?php echo $studentrow['username']; ?></td>
                                                        <td class="align-middle text-center"><?php echo $studentrow['last_name']; ?>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <?php echo $studentrow['first_name']; ?>
                                                        </td>
                                                        <td class="align-middle text-center"><?php echo $studentrow['program']; ?>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <?php echo $studentrow['year_level']; ?>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <form method="POST" action="indexes/officer-event-checking-be.php">
                                                                <?php
                                                                $event_id = $_GET['event_id'];
                                                                $account_number = $studentrow['account_number'];
                                                                $remarks = $studentrow['remarks'];
                                                                ?>
                                                                <input type="hidden" name="event_id"
                                                                    value="<?php echo $event_id; ?>">
                                                                <input type="hidden" name="account_number"
                                                                    value="<?php echo $account_number; ?>">
                                                                <?php
                                                                if ($remarks == 'Present') {
                                                                    ?>
                                                                    <button class="btn btn-success" type="submit"
                                                                        name="markAsAbsent">Present</button>
                                                                    <?php
                                                                } elseif ($remarks == 'Absent') {
                                                                    ?>
                                                                    <button class="btn btn-danger" type="submit"
                                                                        name="markAsPresent">Absent</button>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <p>No students found.</p>
                                    <?php } ?>
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