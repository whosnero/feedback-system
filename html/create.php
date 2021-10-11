<!DOCTYPE html>
<html lang="en">

 <head>
    <!-- required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon (32x32) -->
    <link rel="icon" href="../assets/img/favicon.png" />

    <!-- stylesheets -->
        <!-- custom -->
	    <link rel="stylesheet" href="../assets/css/stylesheet.css" />
         <!-- animation -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <!-- title logo -->
    <link rel="shortcut icon" href="assets/img/favicon.ico.ico" type="image/x-icon"/>
    <title>Feedo!</title>
 </head>

    <body>
        
        <!-- Code section-->
        <section class="main">
            <div class="main-container container-fluid">
                <div class="row">
                    <div class="col-md-6 showhelp">
                        <form action="?test=1" method="get">
                            <input type="submit" name="help" value="?"> <!-- muss am 13.10 gefixed werden-->
                        </form>
                    </div>
                    <div class="col-md-6 createpoll">
                        <ul>
                            <li><a href="create.php">Create Poll</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- clickable icon redirecting to homepage -->
                        <a href="../index.php">
                            <img class="icon" src="../assets/img/favicon-removebg.png" alt="Feedo Logo">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h1 data-aos="zoom-in-down">Welcome to Feedo!</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2 data-aos="fade-up">What´s your code?</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div data-aos="zoom-in" class="row main-code justify-content-center">
                                <form action="?test=1" methode="post">
                                    <input type="number" name="code" placeholder="Code" maxlength="10" >
                                    <input type="submit" value="Start!"> 
                                </form>
                            </div>
                    </div>
                </div>
            </div>

        </section>
        
        <!-- footer-->
		<footer>
			<script language="JavaScript"> fyear = new Date().getYear(); year = (fyear < 1900 ? fyear += 1900 : fyear); buildyear = 2021; document.write(year > buildyear ? "&copy " + buildyear + " - " + year : "&copy " + buildyear); </script>
		</footer>
        

    <!-- Javascript -->
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> </script>
        <!-- AOS (animation) -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script> <script> AOS.init(); </script>

    </body>

</html>