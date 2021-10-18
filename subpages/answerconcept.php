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
                <div class="col-md-12 answer-question">
                    <h1>Wie gefällt dir der Unterricht?</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 valuation">
                    <input type="radio" name="star" id="star1"><label for="star1"></label>
                    <input type="radio" name="star" id="star2"><label for="star2"></label>
                    <input type="radio" name="star" id="star3"><label for="star3"></label>
                    <input type="radio" name="star" id="star4"><label for="star4"></label>
                    <input type="radio" name="star" id="star5"><label for="star5"></label>
                </div>
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