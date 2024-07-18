<!-- officer-event-present-qrcode.php and to present a student in that event by scanning qrcode in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 21, 2024
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
        <title>Officer QR Code Attendance | ITE Student Portal</title>
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
        <script type="text/javascript" src="instascan.min.js"></script>
        <script type="text/javascript" src="vue.min.js"></script>
        <script type="text/javascript" src="adapter.min.js"></script>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <?php include 'layout/officer-fixed-topnav.php'; ?>

            <?php include 'layout/officer-sidebar.php'; ?>

            <div class="content-wrapper">
                <?php
                $eventid = $_GET['event_id'];
                $stmt = $conn->prepare("SELECT event_name FROM events WHERE event_id = ?");
                $stmt->bind_param("i", $eventid);
                $stmt->execute();
                $stmt->bind_result($event_name);
                $stmt->fetch();
                $stmt->close();
                ?>
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2 align-items-center">
                            <div class="col-sm-6">
                                <h1>Scan QR Code for <?php echo htmlspecialchars($event_name); ?></h1>
                            </div>

                            <div class="col-sm-6 text-right">
                                <a id="addNewSubjectBtn" class="btn btn-secondary"
                                    href="officer-event-view.php?event_id=<?php echo $eventid ?>"><i
                                        class="nav-icon fas fa-solid fa-chevron-left"></i> Back to
                                    <?php echo htmlspecialchars($event_name); ?></a>

                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container">
                        <?php if (isset($_GET['scanSuccess'])) { ?>
                            <div class="alert alert-success">
                                <?php echo $_GET['scanSuccess']; ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($_GET['studentNotFount'])) { ?>
                            <div class="alert alert-danger">
                                <?php echo $_GET['studentNotFount']; ?>
                            </div>
                        <?php } ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <video id="preview" width="100%"></video>
                                </div>
                                <div class="col-md-6">
                                    <form name="qrScanForm" action="indexes/officer-scan-attendance.php" method="post"
                                        class="form-horizontal">
                                        <label>SCAN QR CODE</label>
                                        <input type="hidden" name="event_id" class="form-control" value=<?php echo $_GET['event_id'] ?>>
                                        <input type="text" name="text" id="text" readonly="" placeholder="Scan QR Code"
                                            class="form-control">
                                    </form>
                                    <?php
                                    $first_name = isset($_GET['first_name']) && !empty($_GET['first_name']) ? $_GET['first_name'] : "";
                                    $last_name = isset($_GET['last_name']) && !empty($_GET['last_name']) ? $_GET['last_name'] : "";
                                    ?>

                                    <h2>Hello! <?php echo $last_name ?>, <?php echo $first_name ?></h2>
                                </div>
                            </div>
                        </div>

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
                        WHERE attendance.event_id = '$event_id' AND attendance.remarks='Present'";

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
                                                            <?php
                                                            $remarks = $studentrow['remarks'];
                                                            ?>
                                                            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
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
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <p>No Present student found in this event.</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <script>
                        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                        Instascan.Camera.getCameras().then(function (cameras) {
                            if (cameras.length > 0) {
                                scanner.start(cameras[0]);
                            } else {
                                alert('No cameras found');
                            }
                        }).catch(function (e) {
                            console.error(e);
                        });

                        scanner.addListener('scan', function (content) {
                            document.getElementById('text').value = content;
                            document.qrScanForm.submit(); 
                        });
                    </script>
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
            $.widget.bridge('uibutton', $.ui.button);
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