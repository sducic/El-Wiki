<?php
session_start();
include_once 'lib.php';
if(!isset($_SESSION["id"]))
    header("location: index.php");
$servis= new Service();
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ElWiki</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
	
    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/creative.min.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
		<img class="img-responsive" src="img/logo.png" alt=""  height="100">
        <!--<a class="navbar-brand js-scroll-trigger" href="#page-top">ElWiki</a>-->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="http://elfak.ni.ac.rs" target="_blank">Elektronski fakultet</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Kontaktirajte nas</a>
            </li>
          </ul>
        </div>
      </div>
	  
	  <!--Drop down meni-->
		<div class="btn-group navbar-expand-lg" id="mainbtn">
		
			<!--<button type="button" class="btn btn-primary1">Smer</button>-->
				<button type="button" class="btn btn-primary1 dropdown-toggle" style="border-radius: 0" data-toggle="dropdown">
				  <span class="caret"></span>Smer
				</button>
				<ul class="dropdown-menu" role="menu" style="background-color: #212529">
					<!--
				  <li><a href="Smerovi\PrvaGodina.html" target="_blank">Prva godina</a></li>
				  <li><a href="Smerovi\Elektonika.html" target="_blank">Elektronika</a></li>
				  <li><a href="Smerovi\RI.html" target="_blank">Računarstvo i informatika</a></li>
				  <li><a href="Smerovi\Elektroenergetika.html" target="_blank">Elektroenergetika</a></li>
				  <li><a href="Smerovi\Komponente.html" target="_blank">Elektronske komponente i mikrosistemi</a></li>
				  <li><a href="Smerovi\Telekomunikacije.html" target="_blank">Telekomunikacije</a></li>
				  <li><a href="Smerovi\UpravljanjeSistemima.html" target="_blank">Upravljanje sistemima</a></li>
				  -->
				  <li><form action = "Smerovi/PrvaGodina.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Prva Godina" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Smerovi/Elektonika.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Elektonika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Smerovi/RI.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Računarstvo i informatika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Smerovi/Elektroenergetika.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Elektroenergetika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Smerovi/Komponente.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Komponente" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Smerovi/Telekomunikacije.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Telekomunikacije" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Smerovi/UpravljanjeSistemima.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Upravljanje Sistemima" class="btn btn-primary1 dropdown-toggle"> </form></li>
				</ul>
		</div>
		
		<div class="btn-group" id="mainbtn">
		
			<!--<button type="button" class="btn btn-primary1" style="border-radius: 0">Vanredne aktivnosti</button>-->
				<button type="button" class="btn btn-primary1 dropdown-toggle" style="border-radius: 0" data-toggle="dropdown">
				  <span class="caret1"></span>Vanredne aktivnosti
				</button>
				<ul class="dropdown-menu" role="menu" style="background-color: #212529">
					<!--
				  <li><a href="Vanredne aktivnosti\StudOrg.html">Studentske organizacije</a></li>
				  <li><a href="Vanredne aktivnosti\Prakse.html">Prakse</a></li>
				  <li><a href="Vanredne aktivnosti\Oglasi.html">Oglasi</a></li>
				  -->
				  <li><form action = "Vanredne aktivnosti/StudOrg.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Studentske organizacije" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Vanredne aktivnosti/Prakse.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Prakse" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "Vanredne aktivnosti/Oglasi.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Oglasi" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  
				</ul>
		</div>
		
		<div class="btn-group" id="mainbtn">
		
			<!--<button type="button" class="btn btn-primary1" style="border-radius: 0;">Profil</button>-->
				<button type="button" class="btn btn-primary1 dropdown-toggle" data-toggle="dropdown">
				  <span class="caret1"></span>Profil
				</button>
				<ul class="dropdown-menu" role="menu" style="background-color: #212529">
				  <!--<<li><a href="izmeniNalog.php">Moj profil</a></li>
				  <li><a href="korisnici.php">Korisnici</a></li>-->
                                  <li><form action = "izmeniNalog.php" method = "POST">
                                  <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?> >
                                  <input type="submit" name="subizmeninalog" value="Moj profil" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
                                  <li><form action = "korisnici.php" method = "POST">
                                  <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?> >
                                  <input type="submit" name="subkorisnici" value="Korisnici" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
								  <li><form action = "zaposleni.php" method = "POST">
                                  <input type="submit" name="" value="Zaposleni" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
								  <li><form action = "logout.php" method = "POST">
                                  <input type="submit" name="subizmeninalog" value="Izloguj se" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
								 
				</ul>
		</div>
		<div style="font-size:3pix">
			<i class="fas fa-pencil-alt "></i>
		</div>
	  
    </nav>
	
    <header class="masthead text-center text-white d-flex">
      <div class="container my-auto">
        <div class="row">
		<section id="glavno">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>Informacioni portal Elektronskog fakulteta</strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
            <p class="text-faded mb-5">Informacije o Elektronskom fakultetu pisane od strane studenata za studente!</p>
           <!-- <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Doznajte više</a>-->
          </div>
		  </section>
        </div>
      </div>
    </header>
	
    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading">Kontaktirajte Nas!</h2>
            <hr class="my-4">
            <p class="mb-5">Imate problema ili želite da nam kažete koliko vam se sviđa sajt?</br> Kontaktirajte nas i odgovorićemo vam što je pre moguće!</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 ml-auto text-center">
            <i class="fa fa-phone fa-3x mb-3 sr-contact"></i>
            <p>123-456-6789</p>
          </div>
          <div class="col-lg-4 mr-auto text-center">
            <i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
            <p>
              <a href="mailto:admin@elfak.rs">admin@elfak.rs</a>
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/creative.min.js"></script>

  </body>

</html>
