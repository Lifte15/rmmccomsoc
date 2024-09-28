<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.ico" />
    <title>About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            /* Light grey background */
        }

        .container-wrapper {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .about-section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
        }

        @media (max-width: 576px) {
            .container-wrapper {
                align-items: flex-start;
                padding-top: 20px;
            }

            .about-section {
                padding: 20px;
            }

            .text-justify {
                text-align: justify;
            }
        }
    </style>
</head>

<body>

    <div class="container about-section">
        <div class="text-center">
            <img src="images/comsoc.png" alt="Logo" class="img-fluid mb-4" style="max-height: 150px;">
            <h1>About Our System</h1>
            <div class="container">
                <p class="text-justify">The <strong>RMMC Student Portal: Attendance and Payment Monitoring
                        System</strong> was developed by three BSIT students from Ramon Magsaysay Memorial
                    Colleges - General Santos City, under the Computing Society organization, which includes students
                    from BSIT, BSCS, BLIS, and ACT programs. This system addresses the challenges of managing attendance
                    and payments for ITE students, aiming to reduce time-consuming manual processes, minimize human
                    error, and enhance data security. Originally created as a deliverable for the course "Integrative
                    Programming and Technology," the developers recognized its potential and sought to expand its
                    application across other departments.
                </p>

                <p class="text-justify">Through their dedication, they aimed to create an efficient, user-friendly, and
                    secure solution that improves productivity and simplifies attendance and payment management. This
                    system benefits both students and department staff, promoting better tracking and maintenance for
                    the student community.
                </p>
            </div>
        </div>
        <h2 class="text-center mt-5">Meet Our Developers</h2>
        <div class="row mt-4">
            <div class="col-md-4 text-center">
                <img src="images/lowie-jay-orillo.jpg" alt="Developer 1" class="img-fluid rounded-circle mb-2"
                    style="max-height: 150px;">
                <h4>LOWIE JAY ORILLO</h4>
            </div>
            <div class="col-md-4 text-center">
                <img src="images/avatar.png" alt="Developer 2" class="img-fluid rounded-circle mb-2"
                    style="max-height: 150px;">
                <h4>BRIAN ANGELO BOGNOT</h4>
            </div>
            <div class="col-md-4 text-center">
                <img src="images/caryl-mae-subaldo.png" alt="Developer 3" class="img-fluid rounded-circle mb-2"
                    style="max-height: 150px;">
                <h4>CARYL MAE SUBALDO</h4>
            </div>
            <div class="text-center">
                <p class="text-justify">These are three developers who are third-year BSIT students of Ramon Magsaysay
                    Memorial Colleges - General Santos City. This is developed as a deliverable for the course called
                    Integrative Programming and Technology or IPT101; it is intended to address a problem of the
                    Information Technology Education Program concerning the management of attendance and payments for
                    the Department Student Council Officers..
                </p>

                <p class="text-justify">Recognizing the potential of the system after successfully completing their
                    course, they decided to expand the scope of their work to see how such a system could help in
                    attendance management and maintenance of payments across other departments and colleges. Their
                    dedication and forward-thinking approach describe them as people who strive for making the impact
                    possible and working hard for the greater good of the student community.

                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>