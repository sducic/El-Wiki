<?php
    include_once 'lib.php';
     session_start();
     use PHPMailer\PHPMailer\PHPMailer;
     use PHPMailer\PHPMailer\Exception;
     require 'C:\wamp64\bin\apache\apache2.4.33\htdocs\PHPMailer-master\vendor\autoload.php';
     
    $error="";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_POST["mail"]))   // MAIL
        {
            $error .= "Niste uneli e-mail<br/>";
        }
        else
        {
            $mail = $_POST["mail"];
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL) || (!strpos($mail, "@elfak.rs") && !strpos($mail, "@elfak.ni.ac.rs")))
            {
                $error .= "Pogresan format e-maila<br/>";
            }
        }
        if (empty($_POST["ime"]))    // IME
        {
            $error .= "Niste uneli ime i prezime<br/>";
        } 
        else 
        {
            $ime = $_POST["ime"];
            if (!preg_match("/^[a-zA-Z ]*$/",$ime)) 
            {
              $error .= "Za ime i prezime je dozvoljeno samo slova i 'odvojeno'<br/>"; 
            }
        }
        
        if (empty($_POST["lozinka"]))    // LOZINKA
        {
            $error .= "Niste uneli lozinku<br/>";
        }
        if($error == "")
        {
            $servis=new Service();
            $korisnici=array();
            $korisnici=$servis->vrati_sve_korisnike();
            foreach($korisnici as $k)
            {
                if($k->mail == $_POST["mail"])
                    $error .= "E-mail vec postoji<br/>";
            }
        }
        if($error == "")
        {
            $confirmcode=md5( rand(0,1000) );
            $korisnik= new Korisnik(0, $_POST["ime"], $_POST["mail"], $_POST["lozinka"], 1, $_POST["smer"], $_POST["godina"],"$confirmcode",0);//id,ime,mejl,lozinka,uloga,smer,godina
            $servis->dodaj_korisnika($korisnik);
          
           
            
            
            
            //$_SESSION["mail"]=$korisnik->mail;
            //$_SESSION["confirmcode"]=$korisnik->confirmcode;
            
                  
             //header("location: potvrda.php");  
             
             $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
            	
            	
                //Server settings
                $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'elwiki.projekat@gmail.com';                 // SMTP username
                $mail->Password = 'elwiki1234';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('elwiki.projekat@gmail.com', 'ElWiki');
                $email = $korisnik->mail; 
                $confirmcode = $korisnik->confirmcode;
                $mail->addAddress($email);
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Signup | Verification';
                $mail->Body    = "Kliknite na link da potvrdite email : "
                                .'<a href ="http://localhost/Ceosajt/verifikacija.php?email='.$email.'&confirmcode='.$confirmcode.'">http://localhost/Ceosajt/verifikacija.php?email='.$email.'&confirmcode='.$confirmcode.'</a>';



               if($mail->send())
                header("location: poruka.php");    //PROMENI
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
             
             
        }
    }
    

?>


<html >

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
		<div class="container my-auto" style="margin:0 auto;">
        <div class="row" style="margin:0 auto;">
		<section id="glavno" style="margin:0 auto;">
			<div class="col-lg-8 mx-auto" style="margin:0 auto;">

				<!--Login i napravi nalog-->
				<div class="col-sm-12" >
					<div class="container">
						<div class="row  text-center">
						
							<!--Form-->
							<div class="container">
							  <h2>Unesite informacije</h2>
							  <form action = "registracija.php" method = "post">
							  
								<div class="form-group">
								  <label for="email">Email:</label>
								  <input type="email" class="form-control" id="email" placeholder="Unesi email" name="mail">
								</div>
								
								<div class="form-group">
								  <label for="pwd">Ime i Prezime:</label>
								  <input  class="form-control" id="pwd" placeholder="Ime i Prezime" name="ime">
								</div>
								
								<div class="form-group">
								  <label for="pwd">Lozinka:</label>
								  <input type="password" id="lozinkaInput" class="form-control" id="pwd" placeholder="Lozinka" name="lozinka">
								</div>
								
								<label >Smer: </label>
								<select name="smer" size="1"  class="form-control"> 
									<option value="elektroenergetika">Elektroenergetika</option>
									<option value="elektronske komponente i mikrosistemi">Elektronske komponente i mikrosistemi</option>
									<option value="racunarstvo i informatika">Racunarstvo i informatika</option>
									<option value="upravljanje sistemima">Upravljanje sistemima</option>
									<option value="elektronika">Elektronika</option>
									<option value="telekomunikacije">Telekomunikacije</option>
								</select>
								<br/>
								<label>Godina: </label> 
										1 <input type="radio" name="godina" value="1" checked>
										2 <input type="radio" name="godina" value="2">
										3 <input type="radio" name="godina" value="3">
										4 <input type="radio" name="godina" value="4">
										5 <input type="radio" name="godina" value="5">
										<br/>
										<br/>
                     <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
														 
								<button type="submit" class="btn btn-primary btn-xl">Submit</button>
							  </form>
							</div>
							<!--Form-->
							<script>
								function prikazLozinke() {
										var x = document.getElementById("lozinkaInput");
										if (x.type === "password") {
											x.type = "text";
										} else {
											x.type = "password";
										}
								}
							</script>
							
						</div>
					</div>
				</div>
			</div>
			<!--Login i napravi nalog-->
			
			</section>
          </div>
		  
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

<!--
<html>
   
   <head>
      <title>Registruj se</title>
      
      <style type = "text/css">
         
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
                <form action = "registracija.php" method = "post">
                  <label>E-Mail: </label><input type = "text" name = "mail" class = "box"/><br /><br />
                  <label>Ime i Prezime: </label><input type = "text" name = "ime" class = "box"/><br /><br />
                  <label>Lozinka: </label><input type = "password" id="lozinkaInput" name = "lozinka" class = "box" /><br/><br />
                  <input type="checkbox" onclick="prikazLozinke()">Prikazi lozinku<br/>
                  <label>Smer: </label><select name="smer" size="1"> 
                      <option value="elektroenergetika">elektroenergetika</option>
                      <option value="elektronske komponente i mikrosistemi">elektronske komponente i mikrosistemi</option>
                      <option value="racunarstvo i informatika">racunarstvo i informatika</option>
                      <option value="upravljanje sistemima">upravljanje sistemima</option>
                      <option value="elektronika">elektronika</option>
                      <option value="telekomunikacije">telekomunikacije</option>
                  </select>
                  <label>Godina: </label> 1 <input type="radio" name="godina" value="1" checked>
                                          2 <input type="radio" name="godina" value="2">
                                          3 <input type="radio" name="godina" value="3">
                                          4 <input type="radio" name="godina" value="4">
                                          5 <input type="radio" name="godina" value="5"><br/>

                  <input type = "submit" value = "Submit"/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
               <p>Vec imate nalog? <a href="prijavljivanje.php">Prijavi se </a> </p>			
            </div>				
         </div>
          <div id="opsti dugmici">
                <form action="" method="POST">
                        <input type="button" value="Vrati se na pocetnu" onclick="window.location.href='home.php'" />
                    </form>
            </div>
      </div>
       <script>
           function prikazLozinke() {
                var x = document.getElementById("lozinkaInput");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
       </script>
   </body>
</html>-->