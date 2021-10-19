<?php

require_once '../assets/php/db.php';
$bigtext = "Welcome to Feedo!";
$smalltext = "Why u are here?";


/* create-page messages */
if (isset($_GET['create'], $_GET['code'])) {
    $code = $_GET['code'];
    $bigtext = "Die Umfrage wurde erfolgreich erstellt!";
    $smalltext = "Der Code lautet: " . $code;
}

/* index wrong code */
if (isset($_GET['wcode'])) {
    $code = $_GET['wcode'];
    $bigtext = "Code " .$code . " nicht gefunden!";
    $smalltext = "Bitte erneut versuchen.";
    header("Refresh:2; url=../index.php");
}

/* answer-page messages */
if (isset($_GET['answer'])) {
    $bigtext = "Die Antworten wurde übermittelt!";
    $smalltext = "Vielen Dank!";

    header("Refresh:3; url=../index.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon (32x32) -->
    <link rel="icon" href="../assets/img/favicon.ico" />

    <!-- stylesheets (CSS) -->
    <!-- custom -->
    <link rel="stylesheet" href="../assets/css/stylesheet.css" />
    <!-- animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- javascript (custom) -->
    <script src="../assets/js/main.js"> </script>

    <title>Feedo!</title>
</head>

<body>
    <!-- Code section-->
    <section class="main">
        <div class="main-body container-fluid">
            <div class="row">
                <div class="col-md-4 backtomain">
                    <a data-aos="flip-right" data-aos-duration="500" href="../index.php"><img class="x-icon" src="../assets/img/x.png" alt="close help"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <img data-aos="zoom-in" class="icon" src="../assets/img/logo.png" alt="Feedo Logo">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h1 data-aos="zoom-in-down"><?php echo $bigtext; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 whatsfeedo">
                    <h2 data-aos="zoom-in"><?php echo $smalltext; ?></h2>
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