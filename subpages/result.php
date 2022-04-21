<?php

error_reporting(0); // disable warnings
$code = $_POST["code"];

/* checks post got an code */
if (!isset($code) || $code == null) {
    header('Location: ../index.php');
}

/* connection to db */
require_once '../assets/php/db.php';
require_once '../assets/php/Cryption.php';
$encryption_class = new Cryption();

$conn = openDB();

/* table inputs (surveys & responses) */
$query = $conn->prepare("SELECT responses.questionid, surveys.question FROM responses LEFT JOIN surveys ON responses.code = surveys.code AND responses.questionid = surveys.questionid WHERE responses.code = ? ORDER BY responses.created_at ASC;"); // prepare db (against injection)
$query->bind_param("i", $code); // replace integer (code) to var ($code)
$query->execute();
$query->store_result(); // returns a buffered result object from query
$queryamount = $query->num_rows(); // amount for query
if ($queryamount > 0) { // amount
    $query->bind_result($questionid, $question_hashed); //vars can be used
} else {
    /* no result (db=responses, no answer?) */
    header('Location: notification.php?noanswer=' . $code);
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

    <!-- stylesheets (CSS) -->
    <!-- custom -->
    <link rel="stylesheet" href="../assets/css/stylesheet.css" />
    <link rel="stylesheet" media="print" href="../assets/css/print.css" />
    <!-- animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- JavaScript -->
    <!-- custom -->
    <script src="../assets/js/main.js"> </script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/40327c7301.js" crossorigin="anonymous"></script>
    <!-- Charts-API -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Feedo!</title>
</head>

<body>
    <section class="result">
        <div class="result-header container-fluid">
            <div class="row result-header-row">
                <div class="col-md-4 result-header-col-1">
                    <button class="result-download" onClick="print()"name="btnSubmit">Download!</button>
                </div>
                <div class="col-md-4 result-header-col-2">
                    <img data-aos="zoom-in" class="icon icon-result" src="../assets/img/feedologo2.png" alt="Feedo Logo">
                </div>
                <div class="col-md-4 result-header-col-3">
                    <a data-aos="flip-right" data-aos-duration="500" href="../index.php">
                        <img class="x-icon" src="../assets/img/x.png" alt="close results"></img>
                    </a>
                </div>
            </div>
        </div>
        <div class="result-body container-fluid">
            <div class="row">
                <div data-aos="zoom-in" class="col-md-12 result-heading">
                    <h1>Here are your results!</h1>
                    <h2>(Code: <?php echo $code ?>)</h2>
                    <h3>Below you can see the average valuation and a pie chart for your questions</h2>
                        <h4>Scroll down to see all results <i class="fa-solid fa-arrow-down"></i></h2>
                </div>
            </div>

            <?php
            $questionid_array = array();
            /* getting average amount of valuations (connected with the questionid and code) */

            $testquery = $conn->prepare("SELECT COUNT(code) FROM surveys WHERE code = ?"); // prepare db (against injection)
            $testquery->bind_param("i", $code); // replace integer (code) to var ($code)
            $testquery->execute();
            $testquery->store_result(); // returns a buffered result object from surveyquery
            $testquery->bind_result($testamount);
            $testquery->fetch();

            $countwhile = 1;
            while ($query->fetch()) { // while page can use this variables
                /* creates array, which knows all the questionid´s and run them just one time */
                if (!in_array($questionid, $questionid_array)) {
                    $one = 0;
                    $two = 0;
                    $three = 0;
                    $four = 0;
                    $five = 0;

                    $piequery = $conn->prepare("SELECT valuation FROM responses LEFT JOIN surveys ON responses.code = surveys.code AND responses.questionid = surveys.questionid WHERE responses.code = ? AND responses.questionid = ? ORDER BY responses.created_at ASC;");
                    $piequery->bind_param("ii", $code, $questionid);
                    $piequery->execute();
                    $piequery->store_result();

                    if ($piequery->num_rows() > 0) {
                        $piequery->bind_result($allvaluationforthisid);

                        while ($piequery->fetch()) {
                            $decryptedvaluation = $encryption_class->decryptString($allvaluationforthisid);
                            $decryptedvaluation == 1 ? $one++ : null;
                            $decryptedvaluation == 2 ? $two++ : null;
                            $decryptedvaluation == 3 ? $three++ : null;
                            $decryptedvaluation == 4 ? $four++ : null;
                            $decryptedvaluation == 5 ? $five++ : null;
                        }
                    } else {
                        /* couldn´t find any valuation for this questionid */
                    }

                    $valuation_average = ($one + (2 * $two) + (3 * $three) + (4 * $four) + (5 * $five)) / ($one + $two + $three + $four + $five);

                    $piequery->close();

                    $questionid_array[] = $questionid; // adds current questionid to an array

                    $valuation_average = (round($valuation_average * 2)) / 2; // 1,25 = 1 && 1,65 = 1,5 && 1,75 = 2

                    $valuation_average_round_down = floor($valuation_average); // rounds the number down to the nearest integer

                    $question = $encryption_class->decryptString($question_hashed);

                    echo "<div class='row result-row" . " _" . $questionid . " '>";
                    echo "<div class='col-md-6 result-box'>";
                    echo "<p class='question'>Question " . $questionid . "</p>";
                    echo "<p class='result-question'> " . $question . "</p>";
                    echo "<p class='submitamount'> (submitted " . ($one + $two + $three + $four + $five) . "x) </p>";
                    echo "<ul class='star-list'>";

                    /* checks the average valuation and creates stars for each case (0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5) */
                    for ($i = 1; $i <= $valuation_average_round_down; $i++) {
                        echo "<li id='" . $questionid . "-" . $i . "' class='result-star'>";
                        echo "<i class='fa-solid fa-star'></i>";
                        if ($i == $valuation_average) {
                            echo "(" . $valuation_average .  ")";
                        }
                        echo "</li>";
                    }

                    if (filter_var($valuation_average, FILTER_VALIDATE_INT) === false) { //checks if valuation_average is an double than place the half star
                        echo "<li id='" . $questionid . "-" . $valuation_average . "' class='result-star'>";
                        echo "<i class='fa-solid fa-star-half'></i>";
                        echo "(" . $valuation_average .  ")";
                        echo "</li>";
                    }

                    echo "</ul></p></div><div class='col-md-6 chart-box'>";
                    echo "<canvas class='myChart' id='myChart-" . $questionid . "'></canvas>";
                    echo "</div><script>
                            confPie(" .  $one . "," . $two . ",". $three . "," . $four . "," . $five . "," . $questionid . ");
                            </script></div>";


                    if ($countwhile < $testamount){
                        if ($questionid % 2 == 0) {
                            echo "<div class='result-print-header container-fluid'>
                                    <div class='row result-header-row'>
                                        <div class='col-md-4 result-header-col-1'>
                                            <!-- for alignment of other header-columns -->
                                        </div>
                                        <div class='col-md-4 result-header-col-2'>
                                        <img data-aos='zoom-in' class='icon icon-result' src='../assets/img/feedologo2.png' alt='Feedo Logo'>
                                        </div>
                                        <div class='col-md-4 result-header-col-3'>
                                            <a data-aos='flip-right' data-aos-duration='500' href='../index.php'>
                                                <img class='x-icon' src='../assets/img/x.png' alt='close results'></img>
                                            </a>
                                        </div>
                                    </div>
                                </div>";
                        }
                    } else if ($countwhile = $testamount && $questionid % 2 !== 0) {
                        $fillpage = "<div class='fill'></div>";
                    }
                    $countwhile ++;
            ?>

            <?php

                }
            }


            /* closes all "editors" and connections */
            $query->close();

            closeDB($conn);
            ?>

        </div>
        </div>

        <!-- footer-->
        <footer class="result-footer">
            <script>
                document.write(date());
            </script>
            <?php echo $fillpage; ?>
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