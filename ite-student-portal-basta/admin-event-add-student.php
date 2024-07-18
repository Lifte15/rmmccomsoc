<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Add Student to Events Page | ITE Student Portal </title>
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
<?php
session_start();
include "indexes/db_conn.php";

function validate($data)
{
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'  && $_SESSION['department'] === 'ITE') {
    if (isset($_GET['event_id'])) {
        $event_id = intval($_GET['event_id']);

        $sql = "SELECT school_year, semester FROM events WHERE event_id = $event_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $school_year = $row['school_year'];
            $semester = $row['semester'];
            ?>

            <body class="hold-transition sidebar-mini layout-fixed">
                <div class="wrapper">

                    <?php include 'layout/admin-fixed-topnav.php'; ?>
                    <?php include 'layout/admin-sidebar.php'; ?>
                    <?php
                    $eventid = $_GET['event_id'];
                    $stmt = $conn->prepare("SELECT event_name FROM events WHERE event_id = ?");
                    $stmt->bind_param("i", $eventid);
                    $stmt->execute();
                    $stmt->bind_result($event_name);
                    $stmt->fetch();
                    $stmt->close();
                    ?>
                    <div class="content-wrapper">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-sm-6">
                                        <h1>Adding Students to <?php echo htmlspecialchars($event_name); ?></h1>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <a id="addNewSubjectBtn" class="btn btn-secondary"
                                            href="admin-event-view.php?event_id=<?php echo $event_id; ?>"><i
                                                class="nav-icon fas fa-solid fa-chevron-left"></i> Back to
                                            <?php echo htmlspecialchars($event_name); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main content -->
                        <section class="content">
                            <div class="container-fluid">

                                <!-- Search Form -->
                                <form method="GET">
                                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search_input" class="form-control col-5" placeholder="Search...">
                                        <div class="input-group-prepend col-2">
                                            <select name="column" class="form-control">
                                                <option value="u.account_number">Student Number</option>
                                                <option value="u.last_name">Last Name</option>
                                                <option value="u.first_name">First Name</option>
                                                <option value="u.middle_name">Middle Name</option>
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
                                </form>

                                <div class="col-sm text-right">
                                    <form method="POST" action="indexes/admin-event-add-all-students-be.php">
                                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                        <input type="hidden" name="column"
                                            value="<?php echo isset($_GET['column']) ? $_GET['column'] : ''; ?>">
                                        <input type="hidden" name="search_input"
                                            value="<?php echo isset($_GET['search_input']) ? $_GET['search_input'] : ''; ?>">
                                        <input type="hidden" name="program"
                                            value="<?php echo isset($_GET['program']) ? $_GET['program'] : ''; ?>">
                                        <input type="hidden" name="year_level"
                                            value="<?php echo isset($_GET['year_level']) ? $_GET['year_level'] : ''; ?>">
                                        <button class="btn btn-outline-success" type="submit" name="add_all">Add All</button>
                                    </form>
                                </div>
                            </div>
                    </div>

                    <?php
                    if (isset($_GET['search'])) {
                        $program = $_GET['program'];
                        $year_level = $_GET['year_level'];
                        $search_input = $_GET['search_input'];
                        $column = $_GET['column'];

                        $conditions = array();

                        if (!empty($program)) {
                            $conditions[] = "u.program = '$program'";
                        }
                        if (!empty($year_level)) {
                            $conditions[] = "u.year_level = '$year_level'";
                        }
                        if (!empty($search_input) && !empty($column)) {
                            $conditions[] = "$column LIKE '%$search_input%'";
                        }
                        $condition_string = implode(" AND ", $conditions);

                        if (!empty($condition_string)) {
                            $studentsql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level
                                           FROM user u
                                           INNER JOIN enrolled e 
                                           ON u.account_number = e.account_number
                                           LEFT JOIN attendance a 
                                           ON u.account_number = a.account_number 
                                           AND a.event_id = $event_id
                                           WHERE e.school_year = '$school_year'
                                             AND e.semester = '$semester'
                                             AND u.role = 'Student'
                                             AND a.account_number IS NULL
                                             AND $condition_string 
                                           ORDER BY u.program ASC, u.year_level ASC, u.last_name ASC";
                        } else {
                            $studentsql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level
                                           FROM user u
                                           INNER JOIN enrolled e 
                                           ON u.account_number = e.account_number
                                           LEFT JOIN attendance a 
                                           ON u.account_number = a.account_number 
                                           AND a.event_id = $event_id
                                           WHERE e.school_year = '$school_year'
                                             AND e.semester = '$semester'
                                             AND u.role = 'Student'
                                             AND a.account_number IS NULL
                                           ORDER BY u.program ASC, u.year_level ASC, u.last_name ASC";
                        }
                    } else {
                        $studentsql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level
                                           FROM user u
                                           INNER JOIN enrolled e 
                                           ON u.account_number = e.account_number
                                           LEFT JOIN attendance a 
                                           ON u.account_number = a.account_number 
                                           AND a.event_id = $event_id
                                           WHERE e.school_year = '$school_year'
                                             AND e.semester = '$semester'
                                             AND u.role = 'Student'
                                             AND a.account_number IS NULL
                                           ORDER BY u.program ASC, u.year_level ASC, u.last_name ASC";
                    }
                    $result = $conn->query($studentsql);
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="col-2">Student Number</th>
                                <th class="col-2">Last Name</th>
                                <th class="col-2">First Name</th>
                                <th class="col-2">Middle Name</th>
                                <th class="col-1">Program</th>
                                <th class="col-1">Year Level</th>
                                <th class="col-1 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($result) && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="align-middle"><?php echo $row['account_number']; ?></td>
                                        <td class="align-middle"><?php echo $row['last_name']; ?></td>
                                        <td class="align-middle"><?php echo $row['first_name']; ?></td>
                                        <td class="align-middle"><?php echo $row['middle_name']; ?></td>
                                        <td class="align-middle"><?php echo $row['program']; ?></td>
                                        <td class="align-middle"><?php echo $row['year_level']; ?></td>
                                        <td class="align-middle text-center">
                                            <?php
                                            $current_url = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
                                            ?>
                                            <form method="POST" action="indexes/admin-event-add-student-be.php">
                                                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                                <input type="hidden" name="account_number" value="<?php echo $row['account_number']; ?>">
                                                <input type="hidden" name="previous_url"
                                                    value="<?php echo htmlspecialchars($current_url, ENT_QUOTES, 'UTF-8'); ?>">
                                                <button class="btn btn-success" type="submit" name="enroll_student">Add</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center">No students found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                </section>
                </div>
                <?php include 'layout/fixed-footer.php'; ?>
                </div>

                <!-- jQuery -->
                <script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
                <!-- jQuery UI 1.11.4 -->
                <script src="AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js"></script>
                <!-- Bootstrap 4 -->
                <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- AdminLTE App -->
                <script src="AdminLTE-3.2.0/dist/js/adminlte.js"></script>
            </body>

            </html>

            <?php
        } else {
            echo "Event not found.";
        }
    } else {
        echo "Event ID is not specified.";
    }
} else {
    header("Location: login.php");
    exit();
}
?>