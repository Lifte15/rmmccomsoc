 <!-- login.php and to login in ITE Student Portal.
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: May 15, 2024
Brief overview of the file's contents. -->
<?php
require_once 'googleconfig.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.ico" />
    <title>ITE Student Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="AdminLTE-3.2.0/dist/css/bootstrap.css">
    <style>
        body {
            background-image: url('images/student-portal-background.png');
            background-size: cover;
            background-position: center;
        }

        @media screen and (max-width: 768px) {
            .login-image {
                display: none;
            }
        }
    </style>
</head>

<body>
    <section>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">
                    <div class  ="card border-danger shadow-sm">
                        <div class="row g-0">
                            <div class="col-12 col-md-6">
                                <img class="login-image img-fluid rounded-start w-100 h-100 object-fit-cover"
                                    loading="lazy" src="images/login-heading.png" alt="Login Page image">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div class="card-body p-3 p-md-4 p-xl-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-5">
                                                    <div class="text-center mb-2">
                                                        <img src="images/ite.png" alt="ite Student Portal Logo"
                                                            width="80" height="80">
                                                    </div>
                                                    <h3 class="text-center">Welcome back ITE Students!</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (isset($_GET['login-error'])) { ?>
                                            <div class="alert alert-danger text-center">
                                                <?php echo $_GET['login-error']; ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($_GET['success'])) { ?>
                                            <div class="alert alert-success text-center">
                                                <?php echo $_GET['success']; ?>
                                            </div>
                                        <?php } ?>

                                        <form action="indexes/login-index.php" method="post">
                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12">
                                                    <div class="form-floating mb-1">
                                                        <select class="form-select" name="role" id="role">
                                                            <option value="Admin" <?php if (isset($_GET['role']) && $_GET['role'] == 'Admin')
                                                                echo 'selected'; ?>>Admin
                                                            </option>
                                                            <option value="Officer" <?php if (isset($_GET['role']) && $_GET['role'] == 'Officer')
                                                                echo 'selected'; ?>>Officer
                                                            </option>
                                                            <option value="Student" <?php if (!isset($_GET['role']) || $_GET['role'] == 'Student')
                                                                echo 'selected'; ?>>Student
                                                            </option>
                                                        </select>
                                                        <label for="entry" class="form-label">Entry Type</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating mb-1">
                                                        <?php if (isset($_GET['accountnumber'])) { ?>
                                                            <input type="text" class="form-control" name="accountnumber"
                                                                id="accountnumber" placeholder="Account Number"
                                                                value="<?php echo $_GET['accountnumber']; ?>">
                                                        <?php } else { ?>
                                                            <input type="text" class="form-control" name="accountnumber"
                                                                id="accountnumber" placeholder="Account Number">
                                                        <?php } ?>
                                                        <label for="Account Number" class="form-label">Account
                                                            Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating mb-1">
                                                        <input type="password" class="form-control" name="password"
                                                            id="password" value="" placeholder="Password">
                                                        <label for="password" class="form-label">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <a href="forgotpassword.php" class="form-check-label text-secondary"
                                                            id="ForgotPassword" style="text-decoration: none;">Forgot
                                                            Password?</a>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button class="btn btn-dark btn-lg" type="submit"
                                                            name="login">Log in</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <hr>
                                        <div class="col-12">
                                            <p class="text-center mt-3 mb-2">Or sign in with</p>
                                            <div class="d-flex gap-3 flex-column">
                                                <a href="<?php echo $client->createAuthUrl(); ?>" class="btn btn-lg btn-outline-dark mt-2">
                                                    <img src="images/google_icon.png" alt="Google Icon"
                                                        class="google-icon me-2 fs-6" style="width: 1em; height: 1em;">
                                                    <span class="fs-6 mt-0">Log in with Google</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>