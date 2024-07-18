<!-- verifyforgotpassword.php and to verify forgot password in ITE Student Portal.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 21, 2024
Brief overview of the file's contents. -->

<?php
session_start();

if (isset($_SESSION['verify']) && isset($_SESSION['email'])) {

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="favicon.ico" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
        <title>Forgot Password | ITE Student Portal</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" type="text/css" href="AdminLTE-3.2.0/dist/css/bootstrap.css">
        <style>
            body {
                background-image: url('images/student-portal-background.png');
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>

    <body>
        <section>
            <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
                <div class="shadow p-4 mb-5 bg-white rounded" style="width: 500px;">

                    <a href="forgotpassword.php" class="btn btn-secondary mb-3"><i
                            class="nav-icon fas fa-solid fa-chevron-left"></i>
                        Back</a>
                    <?php if (isset($_GET['verifyFailed'])) { ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $_GET['verifyFailed']; ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['searchAccountSuccess'])) { ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_GET['searchAccountSuccess']; ?>
                        </div>
                    <?php } ?>


                    <form action="indexes/resetpassword-be.php" method="post">
                        <h6 class="success-text" style="text-align:center">
                            <strong><?php echo $_SESSION['email']; ?></strong> <br>Please enter the reset password code below. 
                            <br><span class="text-muted">If the reset password code was sent to an email that is no longer
                                active, please contact your officer. Thank you</span>
                        </h6>
                        <br>

                        <input type="hidden" name="account_number" value="<?php echo $_SESSION['account_number']; ?>">
                        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-123"></i></span>
                            <input type="text" class="form-control" name="v_code" placeholder="Reset Password Code">
                        </div>

                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-dark" name="resetPassword">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </body>

    </html>




    <?php
} else {
    header("Location: forgotpassword.php");
    exit();
}
?>