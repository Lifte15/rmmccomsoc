<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.ico" />
    <title>Student Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <style>
        body {
            background-image: url('student-portal-background.png');
            background-size: cover;
            background-position: center;
        }

        @media screen and (max-width: 768px) {
            .login-image {
                display: none;
            }
        }

        .cas-custom-background {
            background-image: url('cas-student-portal/images/student-portal-background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .cbe-custom-background {
            background-image: url('cbe-student-portal/images/student-portal-background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .ccj-custom-background {
            background-image: url('ccj-student-portal/images/student-portal-background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .ce-custom-background {
            background-image: url('ce-student-portal/images/student-portal-background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .cte-custom-background {
            background-image: url('cte-student-portal/images/student-portal-background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .ite-custom-background {
            background-image: url('ite-student-portal/images/student-portal-background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .square-card {
            aspect-ratio: 1 / 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border: none;
            /* Ensure no border is adding extra space */
            margin: 0;
            /* Remove margin if any */
            padding: 0;
            /* Remove padding if any */
        }

        .square-card img {
            max-width: 100%;
            max-height: 100%;
            transition: transform 0.5s ease;
        }

        .square-card:hover img {
            transform: scale(1.1);
        }

        .card {
            margin: 0;
            /* Ensure no margin on card */
            padding: 0;
            /* Ensure no padding on card */
        }

        .small-box {
            position: relative;
        }

        .heading-image {
            display: block;
            margin: 20px auto;
            max-width: 50%;
        }
    </style>
</head>

<body>
    <section>
        <img src="images/heading-image.png" class="heading-image text-center" alt="RMMC Student Portal">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
            <div class="row w-100">
                <a class="col-6 col-md-4 mb-4" href="cas-student-portal/login.php">
                    <div class="card small-box bg-cas square-card cas-custom-background">
                        <div class="card-body">
                            <img src="images/cas.png" class="card-img-top" alt="CAS">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="cbe-student-portal/login.php">
                    <div class="card small-box bg-cbe square-card cbe-custom-background">
                        <div class="card-body">
                            <img src="images/cbe.png" class="card-img-top" alt="CBE">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="ccj-student-portal/login.php">
                    <div class="card small-box bg-ccj square-card ccj-custom-background">
                        <div class="card-body">
                            <img src="images/ccj.png" class="card-img-top" alt="CCJ">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="ce-student-portal/login.php">
                    <div class="card small-box bg-ce square-card ce-custom-background">
                        <div class="card-body">
                            <img src="images/ce.png" class="card-img-top" alt="CE">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="cte-student-portal/login.php">
                    <div class="card small-box bg-cte square-card cte-custom-background">
                        <div class="card-body">
                            <img src="images/cte.png" class="card-img-top" alt="CTE">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="ite-student-portal/login.php">
                    <div class="card small-box bg-ite square-card ite-custom-background">
                        <div class="card-body">
                            <img src="images/ite.png" class="card-img-top" alt="ITE">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</body>

</html>