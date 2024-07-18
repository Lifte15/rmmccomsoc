<!-- verifyforgotpassword.php and to verify email in ITE Student Portal.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 21, 2024
Brief overview of the file's contents. -->

<?php

session_start();

if (isset($_SESSION['verify'])) {
    $account_number = isset($_SESSION['account_number']) ? $_SESSION['account_number'] : '';

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="favicon.ico" />
        <title>Account Verification | ITE Student Portal</title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
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
                    <a href="login.php" class="btn btn-secondary mb-3"><i
                            class="nav-icon fas fa-solid fa-chevron-left"></i>
                        Back</a>

                    <form action="indexes/sendverificationcode.php" method="post">
                        <h1 style="text-align:center"><i class="bi bi-patch-check"></i></h1>
                        <h6 class="success-text" style="text-align:center">Please register your active email address.</h6>
                        <br>
                        <?php if (isset($_GET['codeSentFailed'])) { ?>
                            <div class="alert alert-danger ">
                                <?php echo $_GET['codeSentFailed']; ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['codeSentSuccess'])) { ?>
                            <div class="alert alert-success">
                                <?php echo $_GET['codeSentSuccess']; ?>
                            </div>
                        <?php } ?>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-123"></i></span>
                            <input type="text" class="form-control" name="accountnumber"
                                value="<?php echo htmlspecialchars($account_number); ?>" disabled>
                        </div>

                        <input type="text" class="form-control" name="account_number"
                            value="<?php echo htmlspecialchars($account_number); ?>" hidden>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                            <?php if (isset($_GET['email'])) { ?>
                                <input type="email" class="form-control" name="email" placeholder="Email Address*"
                                    value="<?php echo $_GET['email']; ?>">
                            <?php } else { ?>
                                <input type="email" class="form-control" name="email" placeholder="Email Address*">
                            <?php } ?>
                        </div>

                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-dark" name="sendCode">Send Verification Code</button>
                        </div>
                    </form>

                    <hr>

                    <form action="indexes/verifyaccount.php" method="post">
                        <?php if (isset($_GET['verifyFailed'])) { ?>
                            <div class="alert alert-danger ">
                                <?php echo $_GET['verifyFailed']; ?>
                            </div>
                        <?php } ?>
                        <input type="text" class="form-control" name="account_number"
                            value="<?php echo htmlspecialchars($account_number); ?>" hidden>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-braces"></i></span>
                            <input type="text" class="form-control" name="v_code" placeholder="Verification Code">
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-dark" name="verify">Verify</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </body>

    </html>

    <?php
} else {
    header("Location: login.php");
    exit();
}
?>