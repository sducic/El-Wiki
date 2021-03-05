<?php
    include_once 'lib.php';
    session_start();
   $error="";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      $service= new Service();
      // If result matched $myusername and $mypassword, table row must be 1 row
	$korisnik= $service->vrati_korisnika_mp($_POST["mail"], $_POST["lozinka"]);  
        $uporedi=NULL;
         if($korisnik) {
			//session_register("myusername");
			  $uporedi=$service->uporediActive($korisnik->id);
			  if($uporedi)
			  { 
				 $_SESSION['id'] = $korisnik->id;
				 $_SESSION["ime"] = $korisnik->ime;
				 $_SESSION["uloga"] = $korisnik->uloga;
			 
				 header("location: logedIn.php");
			  }
			  else
			  {
				   $error = "Nalog nije verifikovan";
			  }
		  }
		  else {
			 $error = "Uneli ste pogresan mejl ili lozinku";
		  } 
   }
   

    

   
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>ElWiki</title>
	
	
	
	<!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	
	
	<!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/creative.min.css" rel="stylesheet">
	
	<!--Login button-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	
	<!--Form-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	
	
	

  </head>
  
  <body id="page-top">
	
	<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
		<a class="navbar-brand js-scroll-trigger" href="#page-top">
			<img class="img-responsive" src="img/logo.png" alt="ElWiki" height="100">
		</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="http://www.elfak.ni.ac.rs" target="_blank">Elektronski fakultet</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Kontaktirajte nas</a>
            </li>
          </ul>
        </div>
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

			<!--Login i napravi nalog-->
			<div class="col-sm-12">
				<div class="container">
					<div class="row  text-center">
					
						<div class="col-xs-12 col-sm-8 col-sm-offset-4 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" style="margin:0 auto;">
							<div class="container">
								<!--<button type="button" class="btn btn-primary btn-xl" data-toggle="collapse" data-target="#signin">Uloguj Se</button>-->
								<!--Uloguj se-->
								<!--<div class="collapse" id="signin">-->
									<form role="Form" method="POST" action="" accept-charset="UTF-8">
										<div class="form-group">
											<input type="text" name="mail" placeholder="Email..." class="form-control">	
										</div>
										<div class="form-group">
											<input type="password" name="lozinka" placeholder="Šifra..." class="form-control">
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-xl" href="logedIn.php">Submit</button>
										</div>
										<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
										
									</form>
									
								<!--</div>--><br><br>
							</div>
							<input class="btn btn-primary btn-xl" type="button" value="Registruj se" onclick="window.location.href='registracija.php'" />
						</div>
						
					</div>
				</div>
			</div>
			</div>
			<!--Login i napravi nalog-->
			
          </div>
		  </section>
        </div>
      
	  
	  
    </header>
	
	<!-- Kontaktirajtenas-->
		<section id="contact">
		  <div class="container">
			<div class="row">
			  <div class="col-lg-8 mx-auto text-center">
				<h2 class="section-heading">Kontaktirajte Nas!</h2>
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
	  <!-- Kontaktirajtenas-->
	
	
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
