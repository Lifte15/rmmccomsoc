<?php
session_start();
include "indexes/db_conn.php";
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Developer' && $_SESSION['department'] === 'DEVELOPER') {
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Developer Student List | Dev Portal </title>
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

      <?php include 'layout/developer-fixed-topnav.php'; ?>
      <?php include 'layout/developer-sidebar.php'; ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2 align-items-center">
              <div class="col-sm-6">
                <h1>Enrolled Student</h1>
              </div>
              <div class="col-sm-6 text-right">
                <a id="addNewSubjectBtn" class="btn btn-secondary" href="developer-enrolled-students.php">
                  <i class="nav-icon fas fa-chevron-left"></i> Back to School Year and Semester
                </a>
                <a id="exportDataBtn" class="btn btn-primary"
                  href="indexes/developer-ernolled-student-export.php?school_year=<?php echo $_GET['school_year']; ?>&semester=<?php echo $_GET['semester']; ?>">
                  <i class="fas fa-file-export"></i> Export Data to Spreadsheet
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="card card-primary card-outline bg-white" for="update-profilepicture">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-md-auto">
                    <img src="images/enrolled-student-view.webp" alt="View event avatar"
                      style="width: 150px; height: auto;">
                  </div>

                  <div class="col-md">
                    <div class="table-responsive">
                      <table class="subject-info">

                        <?php
                        if (isset($_GET['school_year']) && isset($_GET['semester'])) {
                          $school_year = $_GET['school_year'];
                          $semester = $_GET['semester'];
                        } else {
                          $school_year = "Default School Year";
                          $semester = "Default Semester";
                        }
                        ?>

                        <table class="subject-info">
                          <tr>
                            <td class="col-md-3"><strong>School Year:</strong></td>
                            <td class="col-md-9"><?php echo $school_year; ?></td>
                            </td>
                          </tr>
                          <tr>
                            <td class="col-md-3"><strong>Semester:</strong></td>
                            <td class="col-md-9"><?php echo $semester; ?></td>
                            </td>
                          </tr>
                        </table>
                      </table>
                    </div>
                  </div>

                  <div class="col-md-auto ml-auto">
                    <a href="developer-enrolled-add.php?school_year=<?php echo $_GET['school_year']; ?>&semester=<?php echo $_GET['semester']; ?>"
                      class="btn btn-success btn-sm">+ Add Student</a>
                  </div>
                </div>
              </div>
            </div>

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
                  <select id="department" name="department" class="form-control" onchange="updateProgramOptions()">
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

            <!-- list of student table -->
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Student Number</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">Middle Name</th>
                    <th class="text-center">Program</th>
                    <th class="text-center">Year Level</th>
                    <th class="text-center">College</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($_GET['search'])) {
                    $search_input = $_GET['search_input'];
                    $column = $_GET['column'];
                    $year_level = $_GET['year_level'];
                    $program = $_GET['program'];
                    $department = $_GET['department'];

                    $conditions = array();

                    if (!empty($year_level)) {
                      $conditions[] = "u.year_level = '$year_level'";
                    }

                    if (!empty($program)) {
                      $conditions[] = "u.program = '$program'";
                    }

                    if (!empty($department)) {
                      $conditions[] = "u.department = '$department'";
                    }

                    $condition_string = implode(" AND ", $conditions);

                    if (!empty($condition_string)) {
                      $condition_string = "AND " . $condition_string;
                    }

                    $studentssql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level, u.department 
                    FROM user u
                    INNER JOIN enrolled e 
                    ON u.account_number = e.account_number
                    WHERE $column LIKE '%$search_input%' 
                    AND e.school_year = '$school_year' 
                    AND e.semester = '$semester' 
                    $condition_string
                    ORDER BY u.department ASC, u.program ASC, u.year_level ASC, u.last_name ASC";

                    $students = mysqli_query($conn, $studentssql);

                    if (!$students) {
                      // Display SQL error for debugging
                      echo "SQL Error: " . mysqli_error($conn);
                      exit();
                    }
                  } else {
                    $studentssql = "SELECT u.account_number, u.last_name, u.first_name, u.middle_name, u.program, u.year_level, u.department 
                    FROM user u
                    INNER JOIN enrolled e 
                    ON u.account_number = e.account_number
                    WHERE e.school_year = '$school_year' 
                    AND e.semester = '$semester'
                    ORDER BY u.department ASC, u.program ASC, u.year_level ASC, u.last_name ASC";

                    $students = mysqli_query($conn, $studentssql);

                    if (!$students) {
                      // Display SQL error for debugging
                      echo "SQL Error: " . mysqli_error($conn);
                      exit();
                    }
                  }

                  if (mysqli_num_rows($students) > 0) {
                    while ($row = mysqli_fetch_assoc($students)) {
                      ?>
                      <tr>
                        <td><?php echo $row['account_number']; ?></td>
                        <td class="text-center"><?php echo $row['last_name']; ?></td>
                        <td class="text-center"><?php echo $row['first_name']; ?></td>
                        <td class="text-center"><?php echo $row['middle_name']; ?></td>
                        <td class="text-center"><?php echo $row['program']; ?></td>
                        <td class="text-center"><?php echo $row['year_level']; ?></td>
                        <td class="text-center"><?php echo $row['department']; ?></td>
                        <td class="text-center">
                          <a href='developer-student-view.php?account_number=<?php echo $row['account_number']; ?>&school_year=<?php echo $school_year; ?>&semester=<?php echo $semester; ?>'
                            class='btn btn-success btn-sm'><i class="nav-icon fas fa-hand-pointer"></i> Select</a>
                        </td>
                      </tr>
                      <?php
                    }
                  } else {
                    echo "<tr><td colspan='9' class='text-center'>No students found for the specified School Year and Semester.</td></tr>";
                  }
                  ?>

                </tbody>
              </table>
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
  </body>

  </html>

  <?php
} else {
  header("Location: login.php");
  exit();
}
?>