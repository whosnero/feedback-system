<?php

if (!isset($additionalquestions)) {
  $additionalquestions = 2;
}

error_reporting(0); // disable warnings

/* connection to db */
require_once '../assets/php/db.php';
require_once '../assets/php/Cryption.php';
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

        // the function automatically generates a cryptographically safe salt.
        $encryption_class = new Cryption();
        $hashToStoreInDB = $encryption_class->encryptString($postinput);

        $postquery->bind_param("isi", $code, $hashToStoreInDB, $i); // code = integer, question = string, questionid = integer
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
  <section class="create">
    <div class="create-header container-fluid">
      <div class="row create-header-row">
        <div class="col-md-12 create-header-col">
          <a data-aos="flip-right" data-aos-duration="500" href="../index.php">
            <img class="x-icon" src="../assets/img/x.png" alt="close help"></img>
          </a>
        </div>
      </div>
    </div>
    <div class="create-body container-fluid">
      <div class="row">
        <div class="col-md-12">
          <img data-aos="zoom-in" class="icon icon-create" src="../assets/img/feedologo2.png" alt="Feedo Logo"> </img>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 typequestionmsg">
          <h1 data-aos="zoom-in-down">Fill the text-boxes with your questions!</h1>
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
                $required = $questionid_sample === 1 ? "required" : ""; // first question is always required
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
    <footer class="create-footer">
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

    document.onkeydown = function shortcutCreate(e) {
      e = e || window.event;
      keycode = e.which || e.keyCode;
      if (keycode == 187 || keycode == 107) { // keycodes for "+"
        e.preventDefault();
        createNewField();
      }
      if (keycode == 189 || keycode == 109) { // keycodes for "-"
        e.preventDefault();
        removeNewField();
      }
    }

    var addcounter = <?php echo ($additionalquestions + $sampleamount) ?>;
    var addqbtn = document.getElementById('addqbtn');
    var form = document.getElementById('create-form');
    var br = document.createElement("br");

    function createNewField() {
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
      window.scrollTo(0, document.body.scrollHeight);
    };

    function removeNewField() {
      var inputfield = document.getElementById(addcounter);

      if (inputfield) {
        br.remove();
        inputfield.remove();
      }

      if (addcounter >= 5) {
        addcounter--;
      }
    };
  </script>
  <script>
        var themebtn = document.getElementById("themebtn");
        
        if(localStorage.getItem("theme") == null) {
            localStorage.setItem("theme", "light");
        }

        let localData = localStorage.getItem("theme");

        if(localData == "light") {
            document.body.classList.remove("dark-theme");
            document.getElementById("theme-icon").classList.add("fa-moon");
        } else if(localData == "dark-theme") {
            document.body.classList.add("dark-theme");
            document.getElementById("theme-icon").classList.add("fa-sun");
        }

        function changeTheme(){
            document.body.classList.toggle("dark-theme");
            if(document.body.classList.contains("dark-theme")){
                localStorage.setItem("theme", "dark-theme");
                document.getElementById("theme-icon").classList.remove("fa-moon");
                document.getElementById("theme-icon").classList.add("fa-sun");
            } else {
                localStorage.setItem("theme", "light");
                document.getElementById("theme-icon").classList.remove("fa-sun");
                document.getElementById("theme-icon").classList.add("fa-moon");
            }
        }

        document.onkeydown = function shortcutCreate(i) {
            i = i || window.event;
            keycode = i.which || i.keyCode;
            if (keycode == 27 || keycode == "Escape") {
                goBack();
            }
            }
  </script>

</body>

</html>