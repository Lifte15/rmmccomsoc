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

        .bg-ce {
            background-color: #F74D00;
        }

        .bg-ite {
            background-color: #9A1824;
        }

        .bg-ccj {
            background-color: #3D2F62;
        }

        .bg-cas {
            background-color: #278A2D;
        }

        .bg-cte {
            background-color: #02055A;
        }

        .bg-cbe {
            background-color: #E9BE00;
        }

        .square-card {
            aspect-ratio: 1 / 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .square-card img {
            max-width: 100%;
            max-height: 100%;
            transition: transform 0.3s ease;
        }

        .square-card:hover img {
            transform: scale(1.1);
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
        <div class="card-body text-center">
            <img src="images/heading-image.png" class="heading-image" alt="RMMC Student Portal">
        </div>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="row w-100">
                <a class="col-6 col-md-4 mb-4" href="cas-student-portal/login.php">
                    <div class="card small-box bg-cas square-card">
                        <div class="card-body">
                            <img src="images/cas.png" class="card-img-top" alt="CAS">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="cbe-student-portal/login.php">
                    <div class="card small-box bg-cbe square-card">
                        <div class="card-body">
                            <img src="images/cbe.png" class="card-img-top" alt="CBE">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="ccj-student-portal/login.php">
                    <div class="card small-box bg-ccj square-card">
                        <div class="card-body">
                            <img src="images/ccj.png" class="card-img-top" alt="CCJ">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="ce-student-portal/login.php">
                    <div class="card small-box bg-ce square-card">
                        <div class="card-body">
                            <img src="images/ce.png" class="card-img-top" alt="CE">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="cte-student-portal/login.php">
                    <div class="card small-box bg-cte square-card">
                        <div class="card-body">
                            <img src="images/cte.png" class="card-img-top" alt="CTE">
                        </div>
                    </div>
                </a>
                <a class="col-6 col-md-4 mb-4" href="ite-student-portal/login.php">
                    <div class="card small-box bg-ite square-card">
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