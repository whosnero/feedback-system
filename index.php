<?php

error_reporting(1); // disable warnings

/* connection to db */
require_once 'assets/php/db.php';
$conn = openDB();

$selquery = $conn->prepare("SELECT code FROM surveys WHERE DATE(created_at) < CURDATE() - INTERVAL 7 DAY;"); // prepare db (against injection)
$selquery->execute();
$selquery->store_result();

if ($selquery->num_rows() > 0) {
    while ($selquery->fetch()) {
        $selquery->bind_result($delcode);

        $delquery = $conn->prepare("DELETE FROM surveys WHERE code = ?;"); // prepare db (against injection)
        $delquery->bind_param("i", $delcode);
        $delquery->execute();
        $delquery->close();

        $delquery2 = $conn->prepare("DELETE FROM responses WHERE code = ?;"); // prepare db (against injection)
        $delquery2->bind_param("i", $delcode);
        $delquery2->execute();
        $delquery2->close();
    }
} else {
    /* no code to delete */
}

$selquery->close();


closeDB($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon (32x32) -->
    <link rel="icon" href="assets/img/favicon.ico" />

    <!-- stylesheets (CSS) -->
    <!-- custom -->
    <link rel="stylesheet" href="assets/css/stylesheet.css" />
    <!-- animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- javascript (custom) -->
    <script src="assets/js/main.js"> </script>

    <title>Feedo!</title>
</head>

<body>
    <!-- Code section-->
    <section class="main">
        <div class="main-header container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <p class="invisible">to be added soon (language change)</p>
                </div>
                <div class="col-md-4 icon-main">
                    <img data-aos="zoom-in" class="icon invisible" src="assets/img/logo.png" alt="Feedo Logo">
                </div>
                <div class="col-md-4 createsurvey">
                    <ul>
                        <li><a data-aos="fade-down" href="subpages/create.php">Create Survey</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-body container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <img data-aos="zoom-in" class="icon" src="assets/img/logo.png" alt="Feedo Logo">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 welcomemsg">
                    <h1 data-aos="zoom-in-down">Welcome to Feedo!</h1>
                </div>
            </div>
            <div class="row">
                <div data-aos="zoom-in" class="col-md-12">
                    <form method="post" class="main-form" action="subpages/answer.php" enctype="multipart/form-data" autocomplete="off">
                        <input type="number" name="code" placeholder="Code" oninput="this.value = Math.abs(this.value)" min="0" maxlength="10" required>
                        <input type="submit" name="btnEnter" value="Enter">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 whatsfeedo">
                    <h2 data-aos="zoom-in">What´s Feedo? Click <a href="subpages/help.html">here</a> for more Information!</h2>
                </div>
            </div>
        </div>

    </section>

    <!-- footer-->
    <footer class="main-footer">
        <script>
            document.write(date());
        </script>
    </footer>

    <!-- Javascript -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> </script>

    <!-- AOS (animation) -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>