<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin' && $_SESSION['department'] === 'SSC') {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Event View | SSC Student Portal </title>
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
                        <div class="row mb-2 align-items-center">
                            <div class="col-sm-6">
                                <h1>Event</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a id="addNewSubjectBtn" class="btn btn-secondary" href="admin-events.php"><i
                                        class="nav-icon fas fa-solid fa-chevron-left"></i> Back to Events</a>
                                <a href="indexes/admin-event-view-export.php?event_id=<?php echo $_GET['event_id']; ?>"
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

                                    <!-- Event information column -->
                                    <div class="col-md">
                                        <div class="table-responsive">
                                            <table class="subject-info">
                                                <?php
                                                if (isset($_GET['event_id'])) {
                                                    $event_id = $_GET['event_id'];
                                                    $eventsql = "SELECT * FROM events WHERE event_id = '$event_id' AND department='SSC'";
                                                    $result = $conn->query($eventsql);

                                                    if ($result && $result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        // Query to count the number of 'Present' remarks
                                                        $countPresentSql = "SELECT COUNT(remarks) AS remark_count FROM attendance WHERE event_id = '$event_id' AND remarks='Present'";
                                                        $countResult = $conn->query($countPresentSql);
                                                        $Present = 0;

                                                        if ($countResult && $countResult->num_rows > 0) {
                                                            $countRow = $countResult->fetch_assoc();
                                                            $Present = $countRow['remark_count'];
                                                        }
                                                        // Query to count the number of 'Absent' remarks
                                                        $countAbsentSql = "SELECT COUNT(remarks) AS remark_count FROM attendance WHERE event_id = '$event_id' AND remarks='Absent'";
                                                        $countAbsentResult = $conn->query($countAbsentSql);
                                                        $Absent = 0;

                                                        if ($countAbsentResult && $countAbsentResult->num_rows > 0) {
                                                            $countAbsentRow = $countAbsentResult->fetch_assoc();
                                                            $Absent = $countAbsentRow['remark_count'];
                                                        }
                                                        ?>
                                                        <table class="subject-info">
                                                            <tr>
                                                                <td class="col-md-3"><strong>Event Name:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['event_name']; ?></td>
                                                            </tr>
                                                            <!-- <tr>
                                                                <td class="col-md-3"><strong>Organization:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['organization']; ?></td>
                                                            </tr> -->
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
                                                            <tr>
                                                                <td class="col-md-3"><strong>Number of Present:</strong></td>
                                                                <td class="col-md-9"><?php echo $Present; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="col-md-3"><strong>Number of Absent:</strong></td>
                                                                <td class="col-md-9"><?php echo $Absent; ?></td>
                                                            </tr>
                                                        </table>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-auto ml-auto">
                                                <a href="admin-event-add-student.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-success btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-plus"></i> Add Student</a>
                                                <a href="admin-event-edit.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-secondary btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-regular fa-pen-to-square"></i> Edit event</a>
                                                <a href="admin-event-delete-student.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-danger btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-minus"></i> Delete Student</a>
                                                <a href="admin-event-present-student-bulk.php?event_id=<?php echo $row['event_id']; ?>"
                                                    class="btn btn-primary btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-check"></i> Mark Bulk Student</a>
                                                <a href="admin-event-present-qrcode.php?event_id=<?php echo $row['event_id']; ?>"
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

                        <!-- Search Form -->
                        <form method="GET">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <input type="text" name="search_input" class="form-control" placeholder="Search...">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <select name="column" class="form-control">
                                        <option value="u.account_number">Student Number</option>
                                        <option value="u.last_name">Last Name</option>
                                        <option value="u.first_name">First Name</option>
                                        <option value="u.middle_name">Middle Name</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <select name="year_level" class="form-control">
                                        <option value="">Year Level</option>
                                        <option value="">All</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <select id="department" name="department" class="form-control"
                                        onchange="updateProgramOptions()">
                                        <option value="">All Department</option>
                                        <option value="ITE">ITE</option>
                                        <option value="CE">CE</option>
                                        <option value="CCJ">CCJ</option>
                                        <option value="CAS">CAS</option>
                                        <option value="CTE">CTE</option>
                                        <option value="CBE">CBE</option>
                                        <option value="COAHS">COAHS</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <select id="program" name="program" class="form-control">
                                        <option value="">All Program</option>
                                        <option value="BSIT">BSIT</option>
                                        <option value="BSCS">BSCS</option>
                                        <option value="BLIS">BLIS</option>
                                        <option value="ACT">ACT</option>
                                        <option value="BSCE">BSCE</option>
                                        <option value="BSCrim">BSCrim</option>
                                        <option value="BAELS">BAELS</option>
                                        <option value="BAPsyc">BAPsyc</option>
                                        <option value="BACommArts">BACommArts</option>
                                        <option value="BSES">BSES</option>
                                        <option value="BSMath">BSMath</option>
                                        <option value="BSSW">BSSW</option>
                                        <option value="BPA">BPA</option>
                                        <option value="BPA-Dance">BPA-Dance</option>
                                        <option value="BSBio">BSBio</option>
                                        <option value="BSESS-FSM">BSESS-FSM</option>
                                        <option value="BEEd">BEEd</option>
                                        <option value="BECEd">BECEd</option>
                                        <option value="BCAEd">BCAEd</option>
                                        <option value="BPEd">BPEd</option>
                                        <option value="BTLEd">BTLEd</option>
                                        <option value="BSEd-English">BSEd-English</option>
                                        <option value="BSEd-Filipino">BSEd-Filipino</option>
                                        <option value="BSEd-Math">BSEd-Math</option>
                                        <option value="BSEd-Science">BSEd-Science</option>
                                        <option value="BSEd-Social Studies">BSEd-Social Studies</option>
                                        <option value="BSA">BSA</option>
                                        <option value="BSMA">BSMA</option>
                                        <option value="BSBA-FM">BSBA-FM</option>
                                        <option value="BSBA-MM">BSBA-MM</option>
                                        <option value="BSBA-OM">BSBA-OM</option>
                                        <option value="BSOA">BSOA</option>
                                        <option value="BSCA">BSCA</option>
                                        <option value="BSREM">BSREM</option>
                                        <option value="BSTM">BSTM</option>
                                        <option value="BSHM">BSHM</option>
                                        <option value="BSN">BSN</option>
                                        <option value="BSP">BSP</option>
                                        <option value="BSM">BSM</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                                </div>
                                <input type="hidden" name="school_year" value="<?php echo $school_year; ?>">
                                <input type="hidden" name="semester" value="<?php echo $semester; ?>">
                            </div>
                        </form>

                        <?php
                        include "indexes/db_conn.php";

                        $event_id = isset($_GET['event_id']) ? $_GET['event_id'] : '';
                        $search_input = isset($_GET['search_input']) ? $_GET['search_input'] : '';
                        $column = isset($_GET['column']) ? $_GET['column'] : '';
                        $year_level = isset($_GET['year_level']) ? $_GET['year_level'] : '';
                        $department = isset($_GET['department']) ? $_GET['department'] : '';
                        $program = isset($_GET['program']) ? $_GET['program'] : '';

                        $query = "SELECT user.account_number, user.username, user.first_name, user.last_name, user.middle_name, user.program, user.department, user.year_level, attendance.remarks, attendance.remarked_by
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
                        if ($department) {
                            $filters[] = "user.department = '$department'";
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
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="col-2">Student Number</th>
                                                        <th class="col-2 text-center">Last Name</th>
                                                        <th class="col-2 text-center">First Name</th>
                                                        <th class="col-1 text-center">Program</th>
                                                        <th class="col-1 text-center">Year Level</th>
                                                        <th class="col-2 text-center">Marked By</th>
                                                        <th class="col-1 text-center">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($studentrow = $studentresult->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td class="align-middle"><?php echo $studentrow['account_number']; ?>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <?php echo $studentrow['last_name']; ?>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <?php echo $studentrow['first_name']; ?>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <?php echo $studentrow['program']; ?>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <?php echo $studentrow['year_level']; ?>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <?php echo $studentrow['remarked_by']; ?>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <form method="POST" action="indexes/admin-event-checking-be.php">
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
                                        </div>
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

        <script>
            const programs = {
                "ITE": [
                    { value: "BSIT", text: "BSIT" },
                    { value: "BSCS", text: "BSCS" },
                    { value: "BLIS", text: "BLIS" },
                    { value: "ACT", text: "ACT" }
                ],
                "CE": [
                    { value: "BSCE", text: "BSCE" }
                ],
                "CCJ": [
                    { value: "BSCrim", text: "BSCrim" }
                ],
                "CAS": [
                    { value: "BAELS", text: "BAELS" },
                    { value: "BAPsyc", text: "BAPsyc" },
                    { value: "BACommArts", text: "BACommArts" },
                    { value: "BSES", text: "BSES" },
                    { value: "BSMath", text: "BSMath" },
                    { value: "BSSW", text: "BSSW" },
                    { value: "BPA", text: "BPA" },
                    { value: "BPA-Dance", text: "BPA-Dance" },
                    { value: "BSBio", text: "BSBio" },
                    { value: "BSESS-FSM", text: "BSESS-FSM" }
                ],
                "CTE": [
                    { value: "BEEd", text: "BEEd" },
                    { value: "BECEd", text: "BECEd" },
                    { value: "BCAEd", text: "BCAEd" },
                    { value: "BPEd", text: "BPEd" },
                    { value: "BTLEd", text: "BTLEd" },
                    { value: "BSEd-English", text: "BSEd-English" },
                    { value: "BSEd-Filipino", text: "BSEd-Filipino" },
                    { value: "BSEd-Math", text: "BSEd-Math" },
                    { value: "BSEd-Science", text: "BSEd-Science" },
                    { value: "BSEd-Social Studies", text: "BSEd-Social Studies" }
                ],
                "CBE": [
                    { value: "BSA", text: "BSA" },
                    { value: "BSMA", text: "BSMA" },
                    { value: "BSBA-FM", text: "BSBA-FM" },
                    { value: "BSBA-MM", text: "BSBA-MM" },
                    { value: "BSBA-OM", text: "BSBA-OM" },
                    { value: "BSOA", text: "BSOA" },
                    { value: "BSCA", text: "BSCA" },
                    { value: "BSREM", text: "BSREM" },
                    { value: "BSTM", text: "BSTM" },
                    { value: "BSHM", text: "BSHM" }
                ],
                "COAHS": [
                    { value: "BSN", text: "BSN" },
                    { value: "BSP", text: "BSP" },
                    { value: "BSM", text: "BSM" }
                ]
            };

            function updateProgramOptions() {
                const departmentSelect = document.getElementById("department");
                const programSelect = document.getElementById("program");

                const selectedDepartment = departmentSelect.value;

                // Clear existing options
                programSelect.innerHTML = '<option value="">All Program</option>';

                if (selectedDepartment in programs) {
                    programs[selectedDepartment].forEach(program => {
                        const option = document.createElement("option");
                        option.value = program.value;
                        option.textContent = program.text;
                        programSelect.appendChild(option);
                    });
                }
            }
        </script>

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