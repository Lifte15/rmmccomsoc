<!-- officer-student-view.php and to show that individual student registered in webpage in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: May 28, 2024
Brief overview of the file's contents. -->

<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Officer' && $_SESSION['department'] === 'ITE') {
  if ($_SESSION['position'] === 'Staff') {
    header("Location: officer-announcement.php?school_year=$defaultYear&semester=$defaultSemester");
    exit();
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Officer Student View | ITE Student Portal</title>
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

      <?php include 'layout/officer-fixed-topnav.php'; ?>
      <?php include 'layout/officer-sidebar.php'; ?>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2 align-items-center">
              <div class="col-sm-6">
                <h1>Student Profile</h1>
              </div>
              <div class="col-sm-6 text-right">
                <a id="addNewSubjectBtn" class="btn btn-secondary" href="officer-students.php">
                  <i class="nav-icon fas fa-solid fa-chevron-left"></i> Back to Student
                </a>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">
            <?php if (isset($_GET['resetSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['resetSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['resetError'])) { ?>
              <div class="alert alert-danger">
                <?php echo $_GET['resetError']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['editStudentSuccess'])) { ?>
              <div class="alert alert-success">
                <?php echo $_GET['editStudentSuccess']; ?>
              </div>
            <?php } ?>

            <?php if (isset($_GET['editStudentError'])) { ?>
              <div class="alert alert-danger">
                <?php echo $_GET['editStudentError']; ?>
              </div>
            <?php } ?>

            <div class="card card-primary card-outline bg-white" for="update-profilepicture">
              <div class="card-header">
                <div class="row align-items-center">
                  <?php
                  if (isset($_GET['account_number'])) {
                    $account_number = $_GET['account_number'];
                    $studentsql = "SELECT * FROM user WHERE account_number = '$account_number'";
                    $result = $conn->query($studentsql);

                    if ($result && $result->num_rows > 0) {
                      $row = $result->fetch_assoc();
                      ?>
                      <!-- Image column -->
                      <div class="col-md-auto">
                        <img src="profile-pictures/<?php echo $row['profile_picture']; ?>" alt="Student Profile Picture"
                          style="height: 10rem; width: 10rem; border-radius: 50%; object-fit: cover;">
                      </div>

                      <!-- Subject information column -->
                      <div class="col-md">
                        <div class="table-responsive">
                          <table class="subject-info">
                            <tr>
                              <td class="col-md-2"><strong>Student Number:</strong></td>
                              <td class="col-md-3"><?php echo $row['account_number']; ?></td>
                              <td class="col-md-2"><strong>Program:</strong></td>
                              <td class="col-md-3"><?php echo $row['program']; ?></td>
                            </tr>
                            <tr>
                              <td class="col-md-2"><strong>Username:</strong></td>
                              <td class="col-md-3"><?php echo $row['username']; ?></td>
                              <td class="col-md-2"><strong>Year Level:</strong></td>
                              <td class="col-md-3"><?php echo $row['year_level']; ?></td>
                            </tr>
                            <tr>
                              <td class="col-md-2"><strong>Last Name:</strong></td>
                              <td class="col-md-3"><?php echo $row['last_name']; ?></td>
                              <td class="col-md-2"><strong>QR Code:</strong></td>
                              <td class="col-md-3">
                                <?php
                                echo str_replace('.png', '', $row['code']);
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <td class="col-md-2"><strong>First Name:</strong></td>
                              <td class="col-md-3"><?php echo $row['first_name']; ?></td>
                              <td class="col-md-2"><strong>Email:</strong></td>
                              <td class="col-md-3"><?php echo $row['email']; ?></td>
                            </tr>
                            <tr>
                              <td class="col-md-2"><strong>Middle Name:</strong></td>
                              <td class="col-md-3"><?php echo $row['middle_name']; ?></td>
                              <td class="col-md-2"><strong>Phone Number:</strong></td>
                              <td class="col-md-3"><?php echo $row['phone_number']; ?></td>
                            </tr>
                            <tr>
                              <td class="col-md-2"><strong>Gender:</strong></td>
                              <td class="col-md-3"><?php echo $row['gender']; ?></td>
                              <td class="col-md-2"><strong>Enrolled By:</strong></td>
                              <td class="col-md-3"><?php echo $row['enrolled_by']; ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-auto ml-auto">
                        <a id="editStudentButton" class="btn btn-primary btn-sm d-block mb-2"
                          href="officer-student-edit.php?account_number=<?php echo $row['account_number']; ?>">
                          <i class="fa-solid fa-pen-to-square"></i> Edit this Student
                        </a>

                        <a id="viewQRCodeBtn" class="btn btn-success btn-sm d-block mb-2"
                          data-account-number="<?php echo $row['account_number']; ?>">
                          <i class="fa-solid fa-pen-to-square"></i> View QR Code
                        </a>

                        <!-- Modal Structure -->
                        <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog"
                          aria-labelledby="qrCodeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="qrCodeModalLabel">Student QR Code</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="container">
                                  <div class="row justify-content-center">
                                    <div class="col-md-12">
                                      <div class="card-wrapper">
                                        <div class="card card-danger card-outline bg-white background-card custom-height"
                                          for="schoolyear">
                                          <div class="card-body">
                                            <img id="qrCodeImage" src="" alt="QR Code" class="qr-code">
                                            <div class="info-table">
                                              <table>
                                                <tr>
                                                  <td>NAME</td>
                                                </tr>
                                                <tr>
                                                  <th id="studentName"></th>
                                                </tr>
                                                <tr>
                                                  <td>PROGRAM</td>
                                                </tr>
                                                <tr>
                                                  <th id="studentProgram"></th>
                                                </tr>
                                                <tr>
                                                  <td>STUDENT NO.</td>
                                                </tr>
                                                <tr>
                                                  <th id="studentNumber"></th>
                                                </tr>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <form method="post" action="indexes/officer-students-reset-password.php" class="d-inline">
                          <input type="hidden" name="account_number" value="<?php echo $row['account_number']; ?>">
                          <button type="submit" class="btn btn-danger btn-sm d-block">
                            <i class="nav-icon fas fa-solid fa-arrows-rotate"></i> Reset Password
                          </button>
                        </form>
                      </div>
                      <?php
                    } else {
                      echo "<div class='col-md-12'>Event may not be existing.</div>";
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <form method="GET" action="">
              <input type="hidden" name="account_number" value="<?php echo $row['account_number']; ?>">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group row">
                    <label for="school_year" class="col-sm-4 col-form-label">School Year</label>
                    <div class="col-sm-8">
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
                        <option value="All" <?php if (isset($_GET['school_year']) && $_GET['school_year'] == 'All')
                          echo 'selected'; ?>>All</option>
                        <?php foreach ($schoolYears as $year) { ?>
                          <option value="<?php echo $year['school_year']; ?>" <?php
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
                </div>

                <div class="col-md-4">
                  <div class="form-group row">
                    <label for="semester" class="col-sm-4 col-form-label">Semester</label>
                    <div class="col-sm-8">
                      <?php
                      $query = "SELECT * FROM semester";
                      $result = mysqli_query($conn, $query);
                      $semesters = [];
                      $defaultSemester = '';

                      if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          $semesters[] = $row;
                          if ($row['dfault'] == 1) {
                            $defaultSemester = $row['semester'];
                          }
                        }
                      }
                      ?>
                      <select class="form-control" id="semester" name="semester">
                        <option value="" <?php if (!isset($_GET['semester']))
                          echo 'selected'; ?>>All</option>
                        <?php foreach ($semesters as $semester) { ?>
                          <option value="<?php echo $semester['semester']; ?>" <?php
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
                </div>
                <div class="col-md-2">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>








            <div class="card card-primary card-outline bg-white mt-4">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#attendance" data-toggle="tab">Attendance</a></li>
                  <li class="nav-item"><a class="nav-link" href="#payment" data-toggle="tab">Payment</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">

                  <div class="tab-pane active" id="attendance">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="col-3">Event Name</th>
                          <th class="col-2 text-center">Date</th>
                          <th class="col-2 text-center">School Year</th>
                          <th class="col-2 text-center">Semester</th>
                          <th class="col-2 text-center">Points</th>
                          <th class="col-2 text-center">Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $semester_condition = "";
                        if (isset($_GET['semester']) && $_GET['semester'] != "") {
                          $semester_condition = "AND e.semester = '" . $_GET['semester'] . "'";
                        }

                        $school_year_condition = "";
                        if (isset($_GET['school_year']) && $_GET['school_year'] != "All") {
                          $school_year_condition = "AND e.school_year = '" . $_GET['school_year'] . "'";
                        }

                        if (isset($_GET['account_number'])) {
                          $account_number = $_GET['account_number'];
                        }



                        $query = "SELECT 
                      e.event_name, 
                      e.date, 
                      e.school_year, 
                      e.semester, 
                      e.points, 
                      a.remarks
                  FROM 
                      events e
                  JOIN 
                      attendance a ON e.event_id = a.event_id
                  WHERE 
                      a.account_number = '$account_number' 
                      $semester_condition 
                      $school_year_condition";

                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                              <td class="align-middle">
                                <?php echo $row['event_name']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['date']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['school_year']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['semester']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['points']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php
                                $remarks = $row['remarks'];
                                if ($remarks == 'Present') {
                                  echo '<button type="button" class="btn btn-success btn-sm">Present</button>';
                                } elseif ($remarks == 'Absent') {
                                  echo '<button type="button" class="btn btn-danger btn-sm">Absent</button>';
                                } elseif ($remarks == 'Pending') {
                                  echo '<button type="button" class="btn btn-secondary btn-sm">Pending</button>';
                                } elseif (in_array($remarks, ['Excused', 'Exempted', 'Working'])) {
                                  echo '<button type="button" class="btn btn-warning btn-sm">' . $remarks . '</button>';
                                }
                                ?>
                              </td>
                            </tr>
                            <?php
                          }
                        } else {
                          echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                        ?>
                      </tbody>


                    </table>
                  </div>

                  <div class="tab-pane" id="payment">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="col-2">Payment Description</th>
                          <th class="col-1 text-center">Date</th>
                          <th class="col-1 text-center">School Year</th>
                          <th class="col-2 text-center">Semester</th>
                          <th class="col-1 text-center">Amount</th>
                          <th class="col-2 text-center">Date Paid</th>
                          <th class="col-2 text-center">Recieved By</th>
                          <th class="col-1 text-center">Status</th>
                      </thead>
                      <tbody>
                        <?php

                        $semester_condition = "";
                        if (isset($_GET['semester']) && $_GET['semester'] != "") {
                          $semester_condition = "AND e.semester = '" . $_GET['semester'] . "'";
                        }

                        $school_year_condition = "";
                        if (isset($_GET['school_year']) && $_GET['school_year'] != "All") {
                          $school_year_condition = "AND e.school_year = '" . $_GET['school_year'] . "'";
                        }

                        if (isset($_GET['account_number'])) {
                          $account_number = $_GET['account_number'];
                        }



                        $query = "SELECT 
                                      e.payment_description, 
                                      e.date, 
                                      e.school_year, 
                                      e.semester, 
                                      e.amount, 
                                      a.date_paid, 
                                      a.received_by, 
                                      a.remarks
                                  FROM 
                                      payment_for e
                                  JOIN 
                                      payment a ON e.payment_for_id = a.payment_for_id
                                  WHERE 
                                      a.account_number = '$account_number' 
                                      $semester_condition 
                                      $school_year_condition";

                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                              <td class="align-middle">
                                <?php echo $row['payment_description']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['date']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['school_year']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['semester']; ?>
                              </td>
                              <td class="align-middle text-center"> ₱
                                <?php echo $row['amount']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['date_paid']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php echo $row['received_by']; ?>
                              </td>
                              <td class="align-middle text-center">
                                <?php
                                $remarks = $row['remarks'];
                                if ($remarks == 'Paid') {
                                  echo '<button type="button" class="btn btn-success btn-sm">Paid</button>';
                                } elseif ($remarks == 'Unpaid') {
                                  echo '<button type="button" class="btn btn-danger btn-sm">Unpaid</button>';
                                }
                                ?>
                              </td>
                            </tr>
                            <?php
                          }
                        } else {
                          echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                        ?>
                      </tbody>


                    </table>
                  </div>
        </section>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
      </div>
      <?php include 'layout/fixed-footer.php'; ?>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <!-- Script for QR Code -->
      <script>
        $(document).ready(function () {
          $('#viewQRCodeBtn').click(function () {
            var accountNumber = $(this).data('account-number');

            // Perform AJAX request to fetch student data
            $.ajax({
              url: 'fetch_student_data.php',
              type: 'POST',
              data: { account_number: accountNumber },
              success: function (response) {
                // Parse JSON response
                var data = JSON.parse(response);

                $('#qrCodeImage').attr('src', 'qrCodeImages/' + data.code + '?' + new Date().getTime());
                $('#studentName').text(data.last_name.toUpperCase() + ', ' + data.first_name.toUpperCase() + ' ' + data.middle_name.charAt(0).toUpperCase() + '.');
                $('#studentProgram').text(data.program);
                $('#studentNumber').text(data.account_number);

                $('#qrCodeModal').modal('show');
              },
              error: function () {
                alert('Failed to fetch student data.');
              }
            });
          });
        });
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