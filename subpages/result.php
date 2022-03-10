<?php

error_reporting(0); // disable warnings
$code = $_POST["code"];

/* checks post got an code */
if (!isset($code) || $code == null) {
    header('Location: ../index.php');
}

/* connection to db */
require_once '../assets/php/db.php';
$conn = openDB();

/* table inputs (surveys & responses) */
$query = $conn->prepare("SELECT responses.questionid, responses.valuation, surveys.question FROM responses LEFT JOIN surveys ON responses.code = surveys.code AND responses.questionid = surveys.questionid WHERE responses.code = ? ORDER BY responses.created_at ASC;"); // prepare db (against injection)
$query->bind_param("i", $code); // replace integer (code) to var ($code)
$query->execute();
$query->store_result(); // returns a buffered result object from query
$queryamount = $query->num_rows(); // amount for query
if ($queryamount > 0) { // amount
    $query->bind_result($questionid, $valuation, $question); //vars can be used
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

    <!-- favicon -->
    <link rel="icon" href="../assets/img/feedo.png" />

    <!-- stylesheets (CSS) -->
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
    <!-- Charts-API -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Feedo!</title>
</head>

<body>
    <section class="result">
        <div class="result-header container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <!-- for alignment of other header-columns -->
                </div>
                <div class="col-md-4 icon-result">
                    <img data-aos="zoom-in" class="icon icon-result" src="../assets/img/feedo.png" alt="Feedo Logo">
                </div>
                <div class="col-md-4 result-col">
                    <a data-aos="flip-right" data-aos-duration="500" href="../index.php">
                        <img class="x-icon" src="../assets/img/x.png" alt="close help"></img>
                    </a>
                </div>
            </div>
        </div>
        <div class="result-body container-fluid">
            <div class="row">
                <div data-aos="zoom-in" class="col-md-12 result-heading">
                    <h1>Here are your results!</h1>
                    <h2>(Code: <?php echo $code ?>)</h2>
                    <h2>Below you can see the average valuation and a pie chart for your questions</h2>
                    <h2>Scroll down to see all results <i class="fa-solid fa-arrow-down"></i></h2>
                </div>
            </div>

            <?php
            $questionid_array = array();
            /* getting average amount of valuations (connected with the questionid and code) */
            $valuequery = $conn->prepare("SELECT SUM(valuation) / COUNT(valuation) FROM responses WHERE questionid = ? AND code = ? ORDER BY responses.created_at ASC;"); // prepare db (against injection)
            while ($query->fetch()) { // while page can use this variables
                /* creates array, which knows all the questionid´s and run them just one time */
                if (!in_array($questionid, $questionid_array)) {
                    $valuequery->bind_param("ii", $questionid, $code); // replaces ? with vars
                    $valuequery->execute();
                    $valuequery->store_result(); // returns a buffered result object from valuequery
                    $valuequery_amount = $valuequery->num_rows(); // amount

                    if ($valuequery_amount > 0) {
                        $valuequery->bind_result($valuation_average);
                        while ($valuequery->fetch()) {
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
                                    $allvaluationforthisid === 1 ? $one++ : null;
                                    $allvaluationforthisid === 2 ? $two++ : null;
                                    $allvaluationforthisid === 3 ? $three++ : null;
                                    $allvaluationforthisid === 4 ? $four++ : null;
                                    $allvaluationforthisid === 5 ? $five++ : null;
                                }
                            } else {
                                /* couldn´t find any valuation for this questionid */
                            }

                            $piequery->close();

                            $questionid_array[] = $questionid; // adds current questionid to an array

                            $valuation_average = (round($valuation_average * 2)) / 2; // 1,25 = 1 && 1,65 = 1,5 && 1,75 = 2

                            $valuation_average_round_down = floor($valuation_average); // rounds the number down to the nearest integer

                            echo "<div data-aos='fade-up' class='row result-row'>";
                            echo "<div class='col-md-6 result-box darkerbg'>";
                            echo "<p class='result-question darkerbg word-break'> " . $question;
                            echo "<p class='submitamount darkerbg'> (submitted " . ($one + $two + $three + $four + $five) . "x) </p>";
                            echo "<ul class='star-list darkerbg'>";

                            /* checks the average valuation and creates stars for each case (0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5) */
                            for ($i = 1; $i <= $valuation_average_round_down; $i++) {
                                echo "<li id='" . $questionid . "-" . $i . "' class='result-star darkerbg'>";
                                echo "<i class='fa-solid fa-star darkerbg'></i>";
                                if ($i == $valuation_average) {
                                    echo "(" . $valuation_average .  ")";
                                }
                                echo "</li>";
                            }

                            if (filter_var($valuation_average, FILTER_VALIDATE_INT) === false) { //checks if valuation_average is an double than place the half star
                                echo "<li id='" . $questionid . "-" . $valuation_average . "' class='result-star darkerbg'>";
                                echo "<i class='fa-solid fa-star-half darkerbg'></i>";
                                echo "(" . $valuation_average .  ")";
                                echo "</li>";
                            }

                            echo "</ul></p></div><div class='col-md-6 chart-box darkerbg'>";
                            echo "<canvas class='myChart darkerbg' id='myChart-" . $questionid . "'></canvas>";
                            echo "</div></div>";

            ?>
                            <!-- Chart.js -->
                            <script>
                                confPie(<?php echo $one; ?>, <?php echo $two; ?>, <?php echo $three; ?>, <?php echo $four; ?>, <?php echo $five; ?>, <?php echo $questionid; ?>);
                            </script>
            <?php
                        }
                    } else {
                        /* couldn´t get average of sum(valuation) */
                    }
                }
            }


            /* closes all "editors" and connections */
            $query->close();
            $valuequery->close();
            closeDB($conn);
            ?>

        </div>
        </div>

    </section>
    <!-- footer-->
    <footer class="result-footer">
        <script>
            document.write(date());
        </script>
    </footer>

    <!-- Javascript -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> </script>

    <!-- AOS (animation) -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
            var themebtn = document.getElementById("themebtn");

            if(localStorage.getItem("theme") == null) {
                localStorage.setItem("theme", "light");
            }

            let localData = localStorage.getItem("theme");

            if(localData == "light") {
                document.body.classList.remove("dark-theme");
            } else if(localData == "dark-theme") {
                document.body.classList.add("dark-theme");
            }

            function changeTheme(){
                document.body.classList.toggle("dark-theme");
                if(document.body.classList.contains("dark-theme")){
                    localStorage.setItem("theme", "dark-theme");
                } else {
                    localStorage.setItem("theme", "light");
                }
            }
    </script>

</body>