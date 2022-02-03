<?php

error_reporting(0); // disable warnings

/* connection to db */
require_once 'assets/php/db.php';
$conn = openDB();

/* search code to delete */
$selquery = $conn->prepare("SELECT code FROM surveys WHERE DATE(created_at) < CURDATE() - INTERVAL 7 DAY;"); // prepare db (against injection)
$selquery->execute();
$selquery->store_result();

/* when code found, starting delete query */
if ($selquery->num_rows() > 0) {
    while ($selquery->fetch()) {
        $selquery->bind_result($delcode);

        /* delete all data (db=surveys) */
        $delquery = $conn->prepare("DELETE FROM surveys WHERE code = ?;"); // prepare db (against injection)
        $delquery->bind_param("i", $delcode);
        $delquery->execute();
        $delquery->close();

        /* delete all data (db=responses) */
        $delquery2 = $conn->prepare("DELETE FROM responses WHERE code = ?;"); // prepare db (against injection)
        $delquery2->bind_param("i", $delcode);
        $delquery2->execute();
        $delquery2->close();
    }
} else {
    /* no code found to delete */
}
hallo
$selquery->close();

closeDB($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- custom meta tags -->
    <meta name="description" content="Feedo is a Feedback-System for students!" />
    <meta name="keywords" content="feedo, students, feedback-system" />

    <!-- favicon -->
    <link rel="icon" href="assets/img/feedo.png" />

    <!-- stylesheets (CSS) -->
    <!-- custom -->
    <link rel="stylesheet" href="assets/css/stylesheet.css" />
    <!-- animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- JavaScript -->
    <!-- custom -->
    <script src="assets/js/main.js"> </script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/40327c7301.js" crossorigin="anonymous"></script>

    <title>Feedo!</title>
</head>

<body>
    <!-- Code section-->
    <section class="main d-flex flex-column justify-content-between">
        <div class="main-header container-fluid d-flex">
            <div class="row h-100 d-flex">
                <div class="col-md-12 h-100 d-flex">
                    <form class="main-header-form d-flex align-items-center" data-aos="fade-down" action="subpages/create.php" method="post" enctype="multipart/form-data">
                        <input type="submit" class="createsurvey" name="createsurvey" value="Create Survey">
                    </form>
                </div>
            </div>
        </div>
        <div class="main-body container-fluid d-flex justify-content-center align-items-center flex-column">
            <div class="row">
                <div class="col-md-12">
                    <img data-aos="zoom-in" class="icon icon-main" src="assets/img/feedologo2.png" alt="Feedo Logo">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 welcomemsg">
                    <h1 data-aos="zoom-in-down">Welcome!</h1>
                </div>
            </div>
            <div class="row">
                <div data-aos="zoom-in" class="col-md-12 d-flex justify-content-center">
                    <form method="post" class="main-form" action="subpages/answer.php" enctype="multipart/form-data" autocomplete="off">
                        <input type="number" name="code" placeholder="Code" oninput="value = Math.abs(value)" min="0" maxlength="10" required>
                        <input type="submit" name="btnEnter" value="Enter">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 whatsfeedo d-flex justify-content-center">
                    <h2 data-aos="zoom-in">What´s Feedo? <a href="subpages/help.html">Click here</a> for more Information!</h2>
                </div>
            </div>
        </div>

        <!-- footer-->
        <footer class="main-footer h-10 d-flex justify-content-end">
            <script>
                document.write(date());
            </script>
        </footer>
    </section>


    <!-- Javascript -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> </script>

    <!-- AOS (animation) -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>