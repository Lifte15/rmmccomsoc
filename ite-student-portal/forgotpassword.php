<!-- forgotpassword.php if you forget your password.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: June 17, 2024
Brief overview of the file's contents. -->

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

                <a href="login.php" class="btn btn-secondary mb-3"><i class="nav-icon fas fa-solid fa-chevron-left"></i>
                    Back</a>
                <?php if (isset($_GET['searchAccountFailed'])) { ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $_GET['searchAccountFailed']; ?>
                    </div>
                <?php } ?>


                <form action="indexes/searchforgotpassword-be.php" method="post">
                    <h6 class="success-text" style="text-align:center">Please enter your account number and search. A
                        verification code will be sent to your registered email address</h6>
                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-123"></i></span>
                        <?php if (isset($_GET['account_number'])) { ?>
                            <input type="text" class="form-control" name="account_number" placeholder="Account Number"
                                value="<?php echo $_GET['account_number']; ?>">
                        <?php } else { ?>
                            <input type="text" class="form-control" name="account_number" placeholder="Account Number">
                        <?php } ?>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-dark" name="searchAccount">Search Account</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>