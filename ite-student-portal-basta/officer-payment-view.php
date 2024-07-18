<!-- officer-payment-view.php and to view payments in officer form.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 19, 2024
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
        <title>Officer Payment View | ITE Student Portal </title>
        <link rel="icon" type="image/png" href="favicon.ico" />

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="path/to/lightbox.min.css">

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
                                <h1>Payment</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a id="addNewSubjectBtn" class="btn btn-secondary" href="officer-payment.php"><i
                                        class="nav-icon fas fa-solid fa-chevron-left"></i> Back to Payments</a>
                                <a id="exportDataBtn" class="btn btn-primary"
                                    href="indexes/officer-payment-view-export.php?payment_for_id=<?php echo $_GET['payment_for_id']; ?>">
                                    <i class="fas fa-file-export"></i> Export Data to Spreadsheet
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <?php if (isset($_GET['updatePaymentforSuccess'])) { ?>
                            <div class="alert alert-success">
                                <?php echo $_GET['updatePaymentforSuccess']; ?>
                            </div>
                        <?php } ?>

                        <div class="card card-primary card-outline bg-white" for="update-profilepicture">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-auto">
                                        <img src="images/payment_avatar.webp" alt="View event avatar"
                                            style="width: 150px; height: auto;">
                                    </div>

                                    <div class="col-md">
                                        <div class="table-responsive">
                                            <table class="subject-info">
                                                <?php
                                                if (isset($_GET['payment_for_id'])) {
                                                    $payment_for_id = $_GET['payment_for_id'];
                                                    $eventsql = "SELECT * FROM payment_for WHERE payment_for_id = '$payment_for_id'";
                                                    $result = $conn->query($eventsql);

                                                    if ($result && $result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        ?>
                                                        <table class="subject-info">
                                                            <tr>
                                                                <td class="col-md-3"><strong>Payment Description:</strong></td>
                                                                <td class="col-md-9"><?php echo $row['payment_description']; ?></td>
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
                                                                <td class="col-md-3"><strong>Amount:</strong></td>
                                                                <td class="col-md-9">₱<?php echo $row['amount']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-auto ml-auto">
                                                <a href="officer-payment-add-student.php?payment_for_id=<?php echo $row['payment_for_id']; ?>"
                                                    class="btn btn-success btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-plus"></i> Add Student</a>
                                                <a href="officer-payment-edit.php?payment_for_id=<?php echo $row['payment_for_id']; ?>"
                                                    class="btn btn-secondary btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-regular fa-pen-to-square"></i> Edit Payment</a>
                                                <a href="officer-payment-delete-student.php?payment_for_id=<?php echo $row['payment_for_id']; ?>"
                                                    class="btn btn-danger btn-sm d-block mb-2"><i
                                                        class="nav-icon fas fa-solid fa-minus"></i> Delete Student</a>
                                            </div>
                                            <?php
                                                    } else {
                                                        echo "Payment may not be existing.";
                                                    }
                                                }
                                                ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <form method="GET">
                            <input type="hidden" name="payment_for_id"
                                value="<?php echo isset($_GET['payment_for_id']) ? $_GET['payment_for_id'] : ''; ?>">
                            <div class="input-group mb-3">
                                <input type="text" name="search_input" class="form-control col-5" placeholder="Search...">
                                <div class="input-group-prepend col-2">
                                    <select name="column" class="form-control">
                                        <option value="account_number">Student Number</option>
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

                        $payment_for_id = isset($_GET['payment_for_id']) ? $_GET['payment_for_id'] : '';
                        $search_input = isset($_GET['search_input']) ? $_GET['search_input'] : '';
                        $column = isset($_GET['column']) ? $_GET['column'] : '';
                        $year_level = isset($_GET['year_level']) ? $_GET['year_level'] : '';
                        $program = isset($_GET['program']) ? $_GET['program'] : '';

                        $query = "SELECT user.account_number, user.username, user.first_name, user.last_name, 
                        user.middle_name, user.program, user.year_level, payment.remarks, payment.date_paid, 
                        payment.received_by, payment.proof_pic, payment.cn_number, payment.date_paid
          FROM payment 
          JOIN user ON payment.account_number = user.account_number 
          WHERE payment.payment_for_id = '$payment_for_id'";

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
                                                    <th class="col-1 text-center">Last Name</th>
                                                    <th class="col-1.5 text-center">First Name</th>
                                                    <th class="col-1 text-center">Program</th>
                                                    <th class="col-1 text-center">Year Level</th>
                                                    <th class="col-1 text-center">Date Paid</th>
                                                    <th class="col-2 text-center">Received By</th>
                                                    <th class="col-1 text-center">Proof of Payment</th>
                                                    <th class="col-1 text-center">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($studentrow = $studentresult->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td class="align-middle"><?php echo $studentrow['account_number']; ?></td>
                                                        <td class="align-middle text-center"><?php echo $studentrow['last_name']; ?>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <?php echo $studentrow['first_name']; ?></td>
                                                        <td class="align-middle text-center"><?php echo $studentrow['program']; ?>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <?php echo $studentrow['year_level']; ?></td>
                                                        <td class="align-middle text-center">
                                                            <?php echo $studentrow['date_paid'] == '0000-00-00' ? '' : date('F j, Y', strtotime($studentrow['date_paid'])); ?>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <?php echo $studentrow['received_by']; ?></td>
                                                            <td class="align-middle text-center">
                                                            <?php
                                                            $remarks = $studentrow['remarks'];
                                                            if ($remarks == 'Paid') {
                                                                if (!empty($studentrow['proof_pic'])) {
                                                                    $proof_pic_path = 'proof-of-payment/' . $studentrow['proof_pic'];
                                                                    echo '<a href="' . $proof_pic_path . '" data-lightbox="proof-pic-' . $studentrow['account_number'] . '"><img src="' . $proof_pic_path . '" alt="Proof of Payment" class="img-thumbnail" style="max-width: 100px; max-height: 100px;"></a>';
                                                                } else {
                                                                    echo 'No proof uploaded';
                                                                }
                                                            } elseif ($remarks == 'Unpaid') {
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <?php
                                                            $received_by = $_SESSION['last_name'] . ', ' . $_SESSION['first_name'];
                                                            $student_name = $studentrow['last_name'] . ', ' . $studentrow['first_name'];
                                                            $program = $studentrow['program'];
                                                            $year_level = $studentrow['year_level'];
                                                            $account_number = $studentrow['account_number'];
                                                            $remarks = $studentrow['remarks'];
                                                            $payment_for_id = $row['payment_for_id'];
                                                            $cn_number = $studentrow['cn_number'];
                                                            $proof_pic = $studentrow['proof_pic'];
                                                            $date_paid = $studentrow['date_paid'];
                                                            if ($remarks == 'Paid') {
                                                                echo '<button type="button" class="btn btn-success btn-sm mark-unpaid-btn" data-toggle="modal" data-target="#markUnpaidModal"
                                                    data-student-name="' . $student_name . '" 
                                                    data-received-by="' . $received_by . '" 
                                                    data-program="' . $program . '" 
                                                    data-account-number="' . $account_number . '" 
                                                    data-payment-for-id="' . $payment_for_id . '"
                                                    data-year-level="' . $year_level . '"
                                                    data-cn-number="' . $cn_number . '"
                                                    data-date-paid="' . $date_paid . '"
                                                    data-proof-pic="' . $proof_pic . '">Paid</button>';
                                                            } elseif ($remarks == 'Unpaid') {
                                                                echo '<button type="button" class="btn btn-danger btn-sm mark-paid-btn" data-toggle="modal" data-target="#markPaidModal"
                                                    data-student-name="' . $student_name . '" 
                                                    data-received-by="' . $received_by . '" 
                                                    data-program="' . $program . '" 
                                                    data-account-number="' . $account_number . '" 
                                                    data-payment-for-id="' . $payment_for_id . '"
                                                    data-year-level="' . $year_level . '">Unpaid</button>';
                                                            }
                                                            ?>
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

            <!-- Mark as Paid -->
            <div class="modal fade" id="markPaidModal" tabindex="-1" role="dialog" aria-labelledby="markPaidModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="markPaidModalLabel">Mark as Paid</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="markPaidForm" method="POST" action="indexes/officer-payment-paid-be.php"
                                enctype="multipart/form-data">
                                Are you sure you want to mark this student as paid?
                                <table class="subject-info">
                                    <tr>
                                        <td class="col-md-5"><strong>Student Name:</strong></td>
                                        <td class="col-md-7"><?php echo $student_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Program:</strong></td>
                                        <td class="col-md-7"><?php echo $program; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Year Level:</strong></td>
                                        <td class="col-md-7"><?php echo $year_level; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Payment Description:</strong></td>
                                        <td class="col-md-7"><?php echo $row['payment_description']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Amount:</strong></td>
                                        <td class="col-md-7"><?php echo $row['amount']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Date:</strong></td>
                                        <td class="col-md-7"><input type="date" name="date_paid" id="paymentDate"></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>CN Number:</strong></td>
                                        <td class="col-md-7"><input type="text" name="cn_number" id="cnNumber"
                                                value="${cnNumber}" placeholder="Receipt Number"></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Proof of Payment:</strong></td>
                                        <td class="col-md-7"><input type="file" name="file" >
                                        </td>
                                    </tr>

                                </table>
                                <input type="hidden" name="payment_for_id" id="modalPaymentForId"
                                    value="<?php echo $payment_for_id; ?>">
                                <input type="hidden" name="account_number" id="modalAccountNumber"
                                    value="<?php echo $account_number; ?>">
                                <input type="hidden" name="received_by" id="modalReceivedBy"
                                    value="<?php echo $received_by; ?>">

                                <button type="submit" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-primary" name="confirmMarkPaid">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Mark as Unpaid -->
            <div class="modal fade" id="markUnpaidModal" tabindex="-1" role="dialog" aria-labelledby="markUnpaidModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="markUnpaidModalLabel">Mark as Unpaid</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="markUnpaidForm" method="POST" action="indexes/officer-payment-unpaid-be.php">
                                Are you sure you want to mark this student as unpaid?
                                <table class="subject-info">
                                    <tr>
                                        <td class="col-md-5"><strong>Student Name:</strong></td>
                                        <td class="col-md-7"><?php echo $student_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Program:</strong></td>
                                        <td class="col-md-7"><?php echo $program; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Year Level:</strong></td>
                                        <td class="col-md-7"><?php echo $year_level; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Payment Description:</strong></td>
                                        <td class="col-md-7"><?php echo $row['payment_description']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Amount:</strong></td>
                                        <td class="col-md-7"><?php echo $row['amount']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>CN Number:</strong></td>
                                        <td class="col-md-7"><?php echo $row['cn_number']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-5"><strong>Proof of Payment:</strong></td>
                                        <td class="col-md-7">
                                            <?php
                                            if (!empty($row['proof_pic'])) {
                                                echo '<img src="proof-of-payment/' . $row['proof_pic'] . '" class="img-thumbnail" style="max-width: 100px; max-height: 100px;" alt="Proof of Payment">';
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" name="payment_for_id" id="modalPaymentForId"
                                    value="<?php echo $payment_for_id; ?>">
                                <input type="hidden" name="account_number" id="modalAccountNumber"
                                    value="<?php echo $account_number; ?>">
                                <input type="hidden" name="received_by" id="modalReceivedBy"
                                    value="<?php echo $received_by; ?>">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-primary" name="confirmMarkUnpaid">Yes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include 'layout/fixed-footer.php'; ?>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        </div>



        <!-- jQuery -->
        <script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js"></script>

        <!-- jQuery -->
        <script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.mark-paid-btn').click(function () {
                    var studentName = $(this).data('student-name');
                    var receivedBy = $(this).data('received-by');
                    var paymentForID = $(this).data('payment-for-id');
                    var accountNumber = $(this).data('account-number');
                    var program = $(this).data('program');
                    var yearLevel = $(this).data('year-level');
                    var cnNumber = $(this).data('cn-number'); // Check if this is correct

                    // Adjust date to local time zone
                    var today = new Date();
                    today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
                    var formattedToday = today.toISOString().split('T')[0];

                    $('#markPaidModal').find('.modal-body').html(`
                    <form id="markPaidForm" method="POST" action="indexes/officer-payment-paid-be.php" enctype="multipart/form-data">
                        Are you sure you want to mark ${studentName} as paid?
                        <table class="subject-info">
                        <tr>
                            <td class="col-md-5"><strong>Student Name:</strong></td>
                            <td class="col-md-7">${studentName}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Program:</strong></td>
                            <td class="col-md-7">${program}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Year Level:</strong></td>
                            <td class="col-md-7">${yearLevel}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Payment Description:</strong></td>
                            <td class="col-md-7"><?php echo $row['payment_description']; ?></td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Amount:</strong></td>
                            <td class="col-md-7"><?php echo $row['amount']; ?></td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Date:</strong></td>
                            <td class="col-md-7"><input type="date" name="date_paid" id="paymentDate" value="${formattedToday}"></td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>CN Number:</strong></td>
                            <td class="col-md-7"><input type="text" name="cn_number" id="cnNumber" value="${cnNumber !== undefined ? cnNumber : ''}"></td>
                        </tr>
                        <tr>
                                <td class="col-md-5"><strong>Proof of Payment:</strong></td>
                                <td class="col-md-7"><input type="file" name="file" >
                                </td>
                            </tr>
                    </table>
                    <input type="hidden" name="payment_for_id" id="modalPaymentForId" value="${paymentForID}">
                    <input type="hidden" name="account_number" id="modalAccountNumber" value="${accountNumber}">
                    <input type="hidden" name="received_by" id="modalReceivedBy" value="${receivedBy}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary" id="confirmMarkPaid" name="confirmMarkPaid">Yes</button>
                    </div>
                </form>
            `);
                });
            });
        </script>


        <script>
            $(document).ready(function () {
                $('.mark-unpaid-btn').click(function () {
                    var studentName = $(this).data('student-name');
                    var receivedBy = $(this).data('received-by');
                    var paymentforID = $(this).data('payment-for-id');
                    var accountnumber = $(this).data('account-number');
                    var program = $(this).data('program');
                    var yearLevel = $(this).data('year-level');
                    var cnNumber = $(this).data('cn-number');
                    var proofPic = $(this).data('proof-pic');
                    var datePaid = $(this).data('date-paid');

                    $('#markUnpaidModal').find('.modal-body').html(`
                    <table class="subject-info">
                        <tr>
                            <td class="col-md-5"><strong>Student Name:</strong></td>
                            <td class="col-md-7">${studentName}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Program:</strong></td>
                            <td class="col-md-7">${program}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Year Level:</strong></td>
                            <td class="col-md-7">${yearLevel}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Payment Description:</strong></td>
                            <td class="col-md-7"><?php echo $row['payment_description']; ?></td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Amount:</strong></td>
                            <td class="col-md-7"><?php echo $row['amount']; ?></td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Received By:</strong></td>
                            <td class="col-md-7">${receivedBy}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>Date Paid:</strong></td>
                            <td class="col-md-7">${datePaid}</td>
                        </tr>
                        <tr>
                            <td class="col-md-5"><strong>CN Number:</strong></td>
                            <td class="col-md-7">${cnNumber}</td>
                        </tr>
                        <tr>
        <td colspan="2" style="text-align: center;"><strong>Proof of Payment:</strong></td>
        <td class="col-md-0"></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center;">
            ${proofPic ? '<img src="proof-of-payment/' + proofPic + '" class="img-fluid" style="max-width: 100%; height: auto;" alt="Proof of Payment">' : ''}
        </td>
    </tr>

                    </table>
                    <hr>
                    <h5 style="text-align: center;"><strong>Are you sure you want to mark ${studentName} as unpaid?</strong></h5>
                    <form id="markPaidForm" method="POST" action="indexes/officer-payment-unpaid-be.php">
                        <input type="hidden" name="payment_for_id" id="modalPaymentForId" value="${paymentforID}">
                        <input type="hidden" name="account_number" id="modalAccountNumber" value="${accountnumber}">
                        <input type="hidden" name="received_by" id="modalReceivedBy" value="${receivedBy}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger" id="confirmMarkPaid" name="confirmMarkUnpaid">Yes</button>
                        </div>
                    </form>
                `);
                });
            });
        </script>


    </body>

    </html>


    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="AdminLTE-3.2.0/plugins/sparklines/sparkline.js"></script>
    <script src="path/to/lightbox.min.js"></script>
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