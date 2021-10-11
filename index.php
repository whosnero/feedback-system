<!DOCTYPE html>
<html lang="en">

 <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon (32x32) -->
    <link href="assets/img/favicon.png" rel="icon" />

    <!-- stylesheets -->
        <!-- custom -->
	    <link rel="stylesheet" href="assets/css/stylesheet.css" />
         <!-- animation -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <title>Feedo</title>
 </head>

    <body>
        
        <section class="main">
            <div class="main-container">
                <h1 data-aos="zoom-in">Welcome to Feedo!</h1>
                <h2 data-aos="fade-up">Whats´s your code?</h2>

                <div data-aos="zoom-in" class="row main-code justify-content-center">
                    <div data-aos="zoom-in">
                        <form action="sub.php" methode="post">
                            <input type="number" name="code" placeholder="Code" maxlength="10" >
                            <input type="submit" value="Start!"> 
                        </form>
                    </div>
                </div>
            </div>

        </section>
        	
		<footer>
			<span class="copyright">&copy; All Rights Reserved. </span>
			<script language="JavaScript" text="text/javascript">
				fyear = new Date().getYear();
				year = (fyear < 1900 ? fyear += 1900 : fyear);
				buildyear = 2021;
				document.write(year > buildyear ? buildyear + " - " + year : buildyear);
			</script>
		</footer>
        

    <!-- Javascript -->
     <!-- Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     <!-- AOS (animations) -->
     <script src="https://unpkg.com/aos@next/dist/aos.js"></script> <script> AOS.init(); </script>

    </body>

</html>