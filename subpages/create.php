<?php
if (!isset($additionalquestions)) {
  $additionalquestions = 2;
}

error_reporting(0); // disable warnings

/* connection to db */
require_once '../assets/php/db.php';
$conn = openDB();

/* table inputs (sample_questions) */
$samplequery = $conn->prepare("SELECT id, question FROM sample_questions"); // prepare db (against injection)
$samplequery->execute();
$samplequery->store_result(); // returns a buffered result object from samplequery
$sampleamount = $samplequery->num_rows();

if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['btnSubmit'])) {

  $code = generateCode(100, 999); // define range of generateCode

  $postconn = openDB();

  foreach ($_POST as $i => $postinput) {
    if ($i != "btnSubmit") {

      if ($postinput != "" && $postinput != "Create") {
        /* insert new data into db and creating new code */
        $postquery = $postconn->prepare("INSERT INTO surveys (code, question, questionid) VALUES (?, ?, ?)");
        $postquery->bind_param("isi", $code, $postinput, $i); // code = integer, question = string, questionid = integer
        $postquery->execute();

        if ($postquery->affected_rows < 0) {
          /* failed to insert data */
          header('Location: create.php');
        }
        $postquery->close();
      }
    }
  }

  closeDB($postconn);

  /* successful imported data into db */
  header('Location: notification.php?create&code=' . $code);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- favicon (32x32) -->
  <link rel="icon" href="../assets/img/feedo.png" />

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
  <section class="create container-fluid">
    <div class="create-header container-fluid">
      <div class="row">
        <div class="col-md-4">
          <p class="invisible">to be added soon (language change)</p>
        </div>
        <div class="col-md-4 icon-answer">
          <img data-aos="zoom-in" class="icon icon-create" src="../assets/img/feedo.png" alt="Feedo Logo">
        </div>
        <div class="col-md-4 backtomain">
          <a data-aos="flip-right" data-aos-duration="500" href="../index.php"><img class="x-icon" src="../assets/img/x.png" alt="close help"></a>
        </div>
      </div>
    </div>
    <div class="create-body container-fluid">
      <div class="row">
        <div class="col-md-12 typequestionmsg">
          <h1 data-aos="zoom-in-down">Type your questions in the text-boxes!</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" maxwidth="684px">
          <form data-aos="zoom-in" method="post" class="create-form" id="create-form" action="create.php" enctype="multipart/form-data">
            <?php
            /* getting sample questions */
            /* checks result and creates variables from result */

            if ($sampleamount > 0) { // amount
              $samplequery->bind_result($questionid_sample, $question_sample);
              while ($samplequery->fetch()) { // while page can use this variables
                /* echo text-box, value from db */
                $required = $questionid_sample === 1 ? "required" : ""; // one question is always required
                echo "<input class='question-box' type='text' name='" . $questionid_sample . "' placeholder='Write your question in here.' maxlength='100' size='70'; value='" . $question_sample . "'" . $required . "> <br>";
              }
            } else {
              /* no result (db=sample_question) */
              header('Location: ../index.php');
            }

            $samplequery->close();
            closeDB($conn);

            /* adds more input for user */
            for ($i = ($sampleamount + 1); $i <= ($additionalquestions + $sampleamount); $i++) {
              echo "<input class='question-box' type='text' name='" . $i . "' placeholder='Write your question in here.' maxlength='100' size='70' ><br>";
            }
            ?>
            <br>
            <div class="row">
              <div class="col-md-12">
                <input class="togglequestions" onclick="createNewField()" type="button" id="addqbtn" name="addqbtn" value="+">
                <input class="togglequestions" onclick="removeNewField()" type="button" id="removeqbtn" name="removeqbtn" value="-">
                <input class="createsurvey2" type="submit" name="btnSubmit" value="Create Survey!">
              </div>
            </div>
            <br>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- footer-->
  <footer class="create-footer">
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

    var addcounter = <?php echo ($additionalquestions + $sampleamount) ?>;
    var addqbtn = document.getElementById('addqbtn');
    var form = document.getElementById('create-form');
    var br = document.createElement("br");
    var createNewField = function() {
      addcounter++;

      var input = document.createElement("input");

      input.classList.add("additionalquestion-box");
      input.type = 'text';
      input.id = addcounter;
      input.name = addcounter;
      input.placeholder = 'Write your question in here. ';
      input.maxLength = 100;

      if (addcounter <= 10) {
        form.appendChild(input);
        form.appendChild(br);
      } else {
        addcounter--;
      }

    };


    var removeNewField = function() {
      var inputfield = document.getElementById(addcounter);
      br.remove();
      inputfield.remove();
      addcounter--;
    };
  </script>

</body>

</html>