<?php

error_reporting(0); // disable warnings

require_once '../assets/php/db.php';
$bigtext = "Welcome to Feedo!";
$smalltext = "Site not found!";
$codetext = "";

/* create-page */
if (isset($_GET['create'], $_GET['code'])) {
    $code = $_GET['code'];
    $smalltext = "Your Survey has been created successfully!";
    $bigtext = "Code: ";
    $codetext = $code;
}

/* wrong code */
if (isset($_GET['wcode'])) {
    $code = $_GET['wcode'];
    $bigtext = "Code " . $code . " does not exist!";
    $smalltext = "Please try again.";

    header("Refresh:3; url=../index.php");
}

/* answer/s committed */
if (isset($_GET['answer'])) {
    $bigtext = "Your Answer has been committed successfully!";
    $smalltext = "Thank you!";

    header("Refresh:3; url=../index.php");
}

/* maintenance */
if (isset($_GET['conn'])) {
    $bigtext = "Feedo is currently down for maintenance!";
    $smalltext = "grab a snack :)";
}

/* no answers for code x */
if (isset($_GET['noanswer'])) {
    $code = $_GET['noanswer'];
    $bigtext = "There are no answers for this survey!";
    $smalltext = "Code: " . $code . "<br> <br>Please try again.";

    header("Refresh:3; url=../index.php");
}
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
    <meta name="theme-color" content="#2891d7">

    <!-- favicon -->
    <link rel="icon" href="../assets/img/feedo.png" />

    <!-- stylesheets -->
    <!-- custom -->
    <link rel="stylesheet" href="../assets/css/stylesheet.css" />
    <!-- animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- JavaScript -->
    <!-- custom -->
    <script src="../assets/js/main.js"> </script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/40327c7301.js" crossorigin="anonymous"></script>

    <title>Feedo!</title>
</head>

<body>
    <section class="notification">
        <div class="notification-header container-fluid">
            <div class="row notification-header-row">
                <div class="col-md-12 notification-header-col">
                    <a data-aos="flip-right" data-aos-duration="500" href="../index.php">
                        <img class="x-icon" src="../assets/img/x.png" alt="close help"></img>
                    </a>
                </div>
            </div>
        </div>
        <div class="notification-body container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <img data-aos="zoom-in" class="icon icon-notification" src="../assets/img/feedo.png" alt="Feedo Logo">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p data-aos="fade-down" class="notification-box">
                    <h1 class="bigtext" data-aos="zoom-in">
                        <div><?php echo $bigtext; ?></div>
                        <div id="notification-code"><?php echo $codetext; ?></div>
                        <?php if (isset($_GET['create'], $_GET['code'])) {
                            echo "<button class='copy-button' onclick='copyNotificationCode()' title='copy code'><i class='fa-solid fa-copy'></i></button>";
                        }
                        ?>
                        <span class='tooltip'>copied</span>
                    </h1>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="smalltext" data-aos="zoom-in"><?php echo $smalltext; ?></h2>
                    <p data-aos="fade-up" class="notification-box">
                    </p>
                </div>
            </div>

        </div>
        <footer class="notification-footer">
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
        document.onkeydown = function goBack() {
            if (window.event.keyCode == 27) {
                window.location.href = "../index.php";
            }
        }
        themeSetter(document.body.classList);
    </script>
</body>

</html>