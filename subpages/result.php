<?php

error_reporting(1); // disable warnings
$code = $_POST["code"];

/* checks post got an code */
if (!isset($code) || $code == null) {
    header('Location: ../index.php');
}

/* connection to db */
require_once '../assets/php/db.php';
$conn = openDB();

/* table inputs (surveys) */
$query = $conn->prepare("SELECT responses.questionid, responses.valuation, surveys.question FROM responses LEFT JOIN surveys ON responses.code = surveys.code AND responses.questionid = surveys.questionid WHERE responses.code = ? ORDER BY responses.created_at ASC;"); // prepare db (against injection)
$query->bind_param("i", $code); // replace integer (code) to var ($code)
$query->execute();
$query->store_result(); // returns a buffered result object from query
$queryamount = $query->num_rows(); // amount
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

    <!-- favicon (32x32) -->
    <link rel="icon" href="../assets/img/favicon.ico" />

    <!-- stylesheets (CSS) -->
    <!-- custom -->
    <link rel="stylesheet" href="../assets/css/stylesheet.css" />
    <!-- animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- javascript (custom) -->
    <script src="../assets/js/main.js"> </script>

    <title>Feedo!</title>
</head>

<body>
    <!-- Code section-->
    <section class="answer">
        <div class="answer-header container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <p class="invisible">to be added soon (language change)</p>
                </div>
                <div class="col-md-4 icon-answer">
                    <img data-aos="zoom-in" class="icon" src="../assets/img/logo.png" alt="Feedo Logo">
                </div>
                <div class="col-md-4 backtomain">
                    <a data-aos="flip-right" data-aos-duration="500" href="../index.php"><img class="x-icon" src="../assets/img/x.png" alt="close help"></a>
                </div>
            </div>
        </div>
        <div class="answer-body container-fluid">
            <div class="row">
                <div class="col-md-12 answer-heading">
                    <h1>Here your results!</h1>
                </div>
            </div>

            <?php

            $questionid_array = array();
            $valuecon = openDB();
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
                            $questionid_array[] = $questionid; // adds current questionid to an array

                            $valuation_average = (round($valuation_average * 2)) / 2; // 1,25 = 1 && 1,65 = 1,5 && 1,75 = 2

                            //TODO: create stars for every question and use bootstrap
                            echo "<p> Question: " . $question . ", Valuation: " . $valuation_average . "</p>";
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
            closeDB($valuecon);
            ?>

            <br>


        </div>
        </div>

        <!-- footer-->
        <footer class="answer-footer">
            <script>
                document.write(date());
            </script>
        </footer>
    </section>


    <!-- Javascript -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> </script>

    <!-- AOS (animation) -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>