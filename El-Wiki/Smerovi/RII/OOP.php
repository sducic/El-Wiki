<?php
session_start();
include_once '../../lib.php';
if(!isset($_SESSION["id"]))
    header("location: ../../index.php");
$servis= new Service();

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	
	
	<!--Sumernote-->
		
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
		<link  href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
		<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
		<script src="../../summernote-master/menjanje.js"></script> 
		<script src="../../summernote-master/bootbox.min.js"></script>
	
	<!--Sumernote-->
	
		
    <title>ElWiki</title>
	

    <!-- Bootstrap core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
	
    <!-- Plugin CSS -->
    <link href="../../vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/creative.min.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
		<img class="img-responsive" src="../../img/logo.png" alt=""  height="100px">
        <!--<a class="navbar-brand js-scroll-trigger" href="#page-top">ElWiki</a>-->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="http://elfak.ni.ac.rs" target="_blank">Elektronski fakultet</a>
            </li>
            
          </ul>
        </div>
      </div>
	  
	  <!--Drop down meni-->
		<div class="btn-group navbar-expand-lg" id="mainbtn">
		
				<button type="button" class="btn btn-primary1 dropdown-toggle" style="border-radius: 0" data-toggle="dropdown">
				  Smer
				</button>
				<ul class="dropdown-menu" role="menu" style="background-color: #212529">
				  <!--<li><a href="Smerovi\PrvaGodina.html" target="_blank">Prva godina</a></li>
				  <li><a href="Smerovi\Elektonika.html" target="_blank">Elektronika</a></li>
				  <li><a href="Smerovi\RI.html" target="_blank">Računarstvo i informatika</a></li>
				  <li><a href="Smerovi\Elektroenergetika.html" target="_blank">Elektroenergetika</a></li>
				  <li><a href="Smerovi\Komponente.html" target="_blank">Elektronske komponente i mikrosistemi</a></li>
				  <li><a href="Smerovi\Telekomunikacije.html" target="_blank">Telekomunikacije</a></li>
				  <li><a href="Smerovi\UpravljanjeSistemima.html" target="_blank">Upravljanje sistemima</a></li>
				  -->
				  
				  <li><form action = "../../Smerovi/PrvaGodina.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Prva Godina" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Smerovi/Elektonika.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Elektonika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Smerovi/RI.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Računarstvo i informatika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Smerovi/Elektroenergetika.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Elektroenergetika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Smerovi/Komponente.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Komponente" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Smerovi/Telekomunikacije.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Telekomunikacije" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Smerovi/UpravljanjeSistemima.php" method = "POST">
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
				  <li><a href="Vanredne aktivnosti\Oglasi.html">Oglasi</a></li>-->
				  
				  <li><form action = "../../Vanredne aktivnosti/StudOrg.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Studentske organizacije" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Vanredne aktivnosti/Prakse.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Prakse" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../../Vanredne aktivnosti/Oglasi.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Oglasi" class="btn btn-primary1 dropdown-toggle"> </form></li>
				</ul>
		</div>
		
		<div class="btn-group" id="mainbtn">
		
			
				<button type="button" class="btn btn-primary1 dropdown-toggle" data-toggle="dropdown">
				  Profil
				</button>
				<ul class="dropdown-menu" role="menu" style="background-color: #212529">
				 
                                  <li><form action = "izmeniNalog.php" method = "POST">
                                  <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?> >
                                  <input type="submit" name="subizmeninalog" value="Moj profil" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
                                  <li><form action = "korisnici.php" method = "POST">
                                  <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?> >
                                  <input type="submit" name="subkorisnici" value="Korisnici" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
								  <li><form method = "POST">
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
        <div class="">
			<!--<div id="airlock">annotator-->
			<div class="click2edit" id="menjamo" style="font-size:13px; text-align:justify"">Lorem ipsum dolor sit amet, nam vidit ponderum conceptam ex. Mei no populo percipitur, sed errem graeco gubergren eu, ornatus accusamus eu nam. Eos id facer persius dissentiet, rebum malis id vim. Facer appareat sed ad. Gubergren similique dissentias est ut, nisl nibh eius id eam. Ei lorem convenire eos.
				Facete recteque sadipscing ne per, sea sint feugiat eu, cu usu tota erant instructior. In duo dicat bonorum scaevola. Scripta alterum omnesque an pro, id vel stet aeque incorrupte. Vim petentium maiestatis et, nemore delenit adipiscing sit te, amet quodsi ex mel. Nulla consequuntur interpretaris ut vix.
				Eum praesent assueverit delicatissimi te. Hinc dicant tamquam ea mei, pri aperiri mediocritatem no. No nemore elaboraret his, cu per prima dolor. Quo ad saepe adipiscing accommodare, dolore nonumy contentiones sea no.
				Nisl adipisci dissentiet nec ea, nisl veri meis et per, ad saperet singulis vim. Ad melius constituam mei. Ferri harum qui ad, omnis aeterno persequeris mei cu. Putent intellegat quo et. Eirmod accusamus assueverit at duo, amet iriure fuisset ne per. Nemore inermis forensibus vis eu, zril feugiat adversarium vel eu. Mei diceret sententiae vituperatoribus ad.
				Rebum postea volutpat id eam, iisque apeirian deseruisse te pri, eu eleifend maiestatis duo. Sed feugait efficiantur ut. An has mnesarchum dissentias, ius quod incorrupte reprehendunt ei, ut eum cibo iuvaret percipitur. Cum ut amet vituperata percipitur, at ius viderer expetenda. Has in melius mediocrem mnesarchum, per ne facilis complectitur.
				Eu mei dico officiis. Duo ea rebum sonet, debet ridens pericula ad per. Justo deserunt ei ius, ad dolore partiendo usu. Lorem eripuit ea me
				Quo utroque vivendum mnesarchum at. Eam dico eros ad. An nulla prompta laoreet has, no mea evertitur prodesset cotidieque. Ad vis odio diam interesset, ad duo populo atomorum. Ea vim nonumy noluisse, mel ad impetus partiendo signiferumque, sed id elitr nullam semper.
				Ut utinam blandit est. Cum et causae consulatu dissentiet, eu accumsan offendit facilisi vel. Ad case ullum per, delicata gubergren scripserit ut quo. In pri dico altera. Pro ad cibo ponderum, ius ei iusto affert. Cu sea tale reque omnes, diam admodum eu has.
				Per at utinam eleifend, civibus torquatos te per. Cu sea doming quaestio. Eum iudicabit necessitatibus ne, eam ex eirmod meliore interpretaris. At maiorum appareat omittantur vis, usu integre indoctum expetendis te, ea nisl mandamus scribentur duo.
				Facer omnesque at eum, homero aperiam et vel, vix noster patrioque et. Ius cu meis aeterno explicari. Mei partem delicatissimi ne, consequat accommodare theophrastus eos ex, vero quaestio argumentum te sea. Populo meliore temporibus et vix, suas veritus per ne.
			</div>
			<!--</div>-->
			</br>
			<button id="edit" class="btn btn-primary" onclick="edit()" type="button">Azuriraj</button>
			<button id="save" class="btn btn-primary" onclick="save()" type="button">Sačuvaj</button>
			
			<script>
				var app = new annotator.App();
				app.include(annotator.ui.main);
				app.include(annotator.storage.http);
				app.start();
				
			</script>
			
        </div>
      </div>
    </header>
	
    

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="../vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="../js/creative.min.js"></script>

	<!--Anotator-->
		<script>
      /*jQuery(function ($) {
        if (typeof $.fn.annotator !== 'function') {
          alert("Ooops! it looks like you haven't built the Annotator concatenation file. " +
                "Either download a tagged release from GitHub, or modify the Cakefile to point " +
                "at your copy of the YUI compressor and run `cake package`.");
        } else {
          // This is the important bit: how to create the annotator and add
          // plugins
          $('#airlock').annotator()
                       .annotator('addPlugin', 'Permissions')
                       .annotator('addPlugin', 'Markdown')
                       .annotator('addPlugin', 'Tags');

          $('#airlock').data('annotator').plugins['Permissions'].setUser("Joe Bloggs");
        }
      });*/
    </script>
	<!--Anotator-->
	
  </body>

</html>
