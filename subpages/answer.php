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

/* table inputs (surveys) */
$surveyquery = $conn->prepare("SELECT code, question, questionid, created_at FROM surveys WHERE code = ?"); // prepare db (against injection)
$surveyquery->bind_param("i", $code); // replace integer (code) to var ($code)
$surveyquery->execute();
$surveyquery->store_result(); // returns a buffered result object from surveyquery
$surveyamount = $surveyquery->num_rows();
if ($surveyamount > 0) { // amount
  $surveyquery->bind_result($code_survey, $question_survey, $questionid_survey, $created_at_survey);
} else {
  /* no result (db=survey) */
  header('Location: ../index.php');
}

$postconn = openDB();

if (isset($_POST['btnSubmit'])) {
  foreach ($_POST as $qid => $valuation) {
    /* search vars from form */
    if (str_starts_with($qid, "star")) {
      $qid = str_replace("star-", "", $qid); // for easier insert


      $postquery = $postconn->prepare("INSERT INTO responses (code, questionid, valuation) VALUES (?, ?, ?)");
      $postquery->bind_param("iii", $code, $qid, $valuation);
      $postquery->execute();

      if ($postquery->affected_rows < 0) {
        /* failed to insert data */
        header('Location: index.php');
      }
      $postquery->close();
    }
  }
}

closeDB($postconn);

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
          <h1>Please answer the following questions precisely & honest!</h1>
        </div>
      </div>

      <form method="post" action="answer.php" enctype="multipart/form-data">
        <?php
        /* getting sample questions */
        /* checks result and creates variables from result */

        while ($surveyquery->fetch()) { // while page can use this variables
          /* creates form to answer */
        ?>
              <div class="row">
              <label for="<?php echo $questionid_survey; ?>"><b><?php echo $question_survey; ?></b></label> <br>
              <div class='col-md-12 valuation'>
              <div id="group<?php echo $questionid_survey; ?>"> <!-- ist wichtig, nicht rausmachen. hat noch keinen nutzen-->
              <?php

              for ($i = 1; $i <= 5; $i++) {
                echo "<input type='radio' name='group" . $questionid_survey . "' value='" . $i . "'  id='star" . $i . "'><label for='star" . $i . "'></label>";
              }

              ?>
            </div>
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