<?php

error_reporting(0); // disable warnings
$code = $_POST["code"];

/* checks post got an code */
if (!isset($code) || $code == null || !isset($_POST['btnEnter'])) {
  header('Location: ../index.php');
}

/* connection to db */
require_once '../assets/php/db.php';
require_once '../assets/php/Cryption.php';
$encryption_class = new Cryption();

$conn = openDB();

/* table inputs (surveys) */
$surveyquery = $conn->prepare("SELECT code, question, questionid, created_at FROM surveys WHERE code = ?"); // prepare db (against injection)
$surveyquery->bind_param("i", $code); // replace integer (code) to var ($code)
$surveyquery->execute();
$surveyquery->store_result(); // returns a buffered result object from surveyquery
$surveyamount = $surveyquery->num_rows();
if ($surveyamount > 0) { // amount
  $surveyquery->bind_result($code_survey, $question_survey_hashed, $questionid_survey, $created_at_survey);
} else {
  /* no result (db=survey) */
  header('Location: notification.php?wcode=' . $code);
}

$postconn = openDB();

if (isset($_POST['btnSubmit'])) {
  foreach ($_POST as $qid => $valuation) {
    /* search vars from form */
    if (substr($qid, 0, 4) === "star") {
      $qid = str_replace("star-", "", $qid); // for easier insert

      $postquery = $postconn->prepare("INSERT INTO responses (code, questionid, valuation) VALUES (?, ?, ?)");
      $encryptvaluation = $encryption_class->encryptString($valuation);
      $postquery->bind_param("iis", $code, $qid, $encryptvaluation);
      $postquery->execute();

      if ($postquery->affected_rows < 0) {
        /* failed to insert data */
        header('Location: index.php');
      }
      $postquery->close();
    }
  }

  header('Location: notification.php?answer');
}

closeDB($postconn);

/* disallow showing result button */

$disallow = $conn->prepare("SELECT responses.questionid FROM responses WHERE responses.code = ?;"); // prepare db (against injection)
$disallow->bind_param("i", $code); // replace integer (code) to var ($code)
$disallow->execute();
$disallow->store_result(); // returns a buffered result object from query

$disallowboolean = false;

if ($disallow->num_rows() < 1) { // amount
  $disallowboolean = true;
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
  <section class="answer">
    <div class="answer-header container-fluid">
      <div class="row answer-header-row">
        <div class="col-md-4 answer-header-col-1">
          <form data-aos="flip-left" method="post" action="result.php" enctype="multipart/form-data">
            <?php
            echo "<input type='" . ($disallowboolean ? "hidden" : "submit") . "' class='seeresult' name='seeresult' value='See Result'>";
            ?>
            <input type="hidden" name="code" value="<?php echo $code; ?>">
          </form>
        </div>
        <div class="col-md-4 answer-header-col-2">
          <img data-aos="zoom-in" class="icon icon-answer" src="../assets/img/feedologo2.png" alt="Feedo Logo">
        </div>
        <div class="col-md-4 answer-header-col-3">
          <a data-aos="flip-right" data-aos-duration="500" href="../index.php">
            <img class="x-icon" src="../assets/img/x.png" alt="close answer"></img>
          </a>
        </div>
      </div>
    </div>
    <div class="answer-body container-fluid">
      <div class="row">
        <div data-aos="fade-down" class="col-md-12 answer-heading">
          <h1>Please answer all the following questions precisely & honest!</h1>
          <h2>(Code: <?php echo $code ?>)</h2>
          <h2>Scroll down to see all questions <i class="fa-solid fa-arrow-down"></i></h2>
          <h2>You can submit your answers at the bottom of the page</h2>
        </div>
      </div>

      <form class="answer-form container" data-aos="zoom-in" method="post" action="answer.php" enctype="multipart/form-data">
        <?php
        /* getting sample questions */
        /* checks result and creates variables from result */

        while ($surveyquery->fetch()) { // while page can use this variables
          $question_survey = $encryption_class->decryptString($question_survey_hashed);
          /* creates form to answer */
        ?>
          <div data-aos="fade-up" class="answer-box">
            <label for="<?php echo $questionid_survey; ?>">
              <p border-radius="25px" class="answer-question word-break"><?php echo $question_survey; ?></p>
            </label><br>
            <div class='col-md-12 valuation'>
              <?php

              for ($i = 5; $i >= 1; $i--) {
                echo "<input type='radio' name='star-" . $questionid_survey . "' value='" . $i . "'  id='star" . $questionid_survey . "-" . $i . "'><label for='star" . $questionid_survey . "-" . $i . "'></label>";
              }

              ?>
            </div>
          </div>
        <?php
        }

        $surveyquery->close();
        closeDB($conn);
        ?>

        <br>
        <input type="hidden" name="code" value="<?php echo $code_survey; ?>">
        <input type="submit" class="answer-submit" name="btnSubmit" value="Submit!">

      </form>

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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> </script>

  <!-- AOS (animation) -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>

</html>