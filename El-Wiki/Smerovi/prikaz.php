<?php
session_start();

require 'C:\wamp64\bin\apache\apache2.4.33\htdocs\PHPMailer-master\vendor\autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once '../lib.php';
if(!isset($_SESSION["id"]) || !isset($_GET["id"]) && !isset($_POST["id"]))
    header("location: ../index.php");
$servis=new Service();

if(isset($_POST["id"]))
{
    $str=$servis->vrati_stranicu($_POST["id"]);
if(isset($_POST["subslika"]))
{
    if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) 
    {
        //Allowed file type
        $allowed_extensions = array("jpg","jpeg","png","gif");
    
        //File extension
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    
        //Check extension
        if(in_array($ext, $allowed_extensions)) 
        {
           //Convert image to base64
           $encoded_image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
           $encoded_image = 'data:image/' . $ext . ';base64,' . $encoded_image;
           $slik=new Slika(0, $_POST["id"], 1, $encoded_image);
           $servis->dodaj_sliku($slik);
        }
    }

}
// OVDE SUBMITOVI
if(isset($_POST["potvrdi"])) //admin opcija
{
    $strr=$str;
    $strr->original_tekst = $str->izmenjen_tekst;
    $strr->izmenio=NULL;
    $strr->izmenjen_tekst=NULL;
    $strr->br_glasova=NULL;
    $servis->izmeni_original_stranicu($strr);
    $servis->izmeni_izmenjen_stranicu($_POST["id"], NULL, NULL, NULL);
    
    $nlb=array();
    $nlb=$servis->vrati_linkove($_POST["id"], 0);
    if($nlb)
    {
        foreach ($nlb as $lb) 
        {
            $servis->izbrisi_link($lb->id);
        }
    }
    $nsb=array();
    $nsb=$servis->vrati_slike($_POST["id"], 0);
    if($nsb)
    {
        foreach ($nsb as $sb) 
        {
            $servis->izbrisi_sliku($sb->id);
        }
    }
    
    $nli=array();
    $nli=$servis->vrati_linkove($_POST["id"], 1);
    if($nli)
    {
        foreach ($nli as $li) 
        {
            $li->starnov=0;
            $servis->izmeni_link($li);
        }
    }
    $nsi=array();
    $nsi=$servis->vrati_slike($_POST["id"], 1);
    if($nsb)
    {
        foreach ($nsi as $si) 
        {
            $si->starnov=0;
            $servis->izmeni_sliku($si);
        }
    }
    $servis->izbrisi_glasali($_POST["id"]);
}
if(isset($_POST["odbaci"])) // admin opcija
{
    $servis->izmeni_izmenjen_stranicu($_POST["id"], NULL, NULL, NULL);
    $nlb=array();
    $nlb=$servis->vrati_linkove($_POST["id"], 1);
    if($nlb)
    {
        foreach ($nlb as $lb) 
        {
            $servis->izbrisi_link($lb->id);
        }
    }
    $nsb=array();
    $nsb=$servis->vrati_slike($_POST["id"], 1);
    if($nsb)
    {
        foreach ($nsb as $sb) 
        {
            $servis->izbrisi_sliku($sb->id);
        }
    }
    $servis->izbrisi_glasali($_POST["id"]);
}

if(isset($_POST["subdodaj"]))
{
    if(!empty($_POST["dtekst"]))
    {
        $str->original_tekst.="<br/>".strip_tags($_POST["dtekst"]);
        $servis->izmeni_original_stranicu($str);
        $servis->dodaj_novost($str->id);
    }
}
if(isset($_POST["subizmenitekstlinks"]))    // ZAVRSIIIIIIIIIII
{
    if($str->izmenio)
    {
        $starnovbool2=1;
    }
    else 
    {
        $starnovbool2=0;
    }
    if(!empty($_POST["ta"]))
    {
        $IzmText= strip_tags($_POST["ta"]);
        $servis->izmeni_izmenjen_stranicu($_POST["id"], $IzmText, $_SESSION["id"], 0);
    }
    //if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $URL)) {
      //$websiteErr = "Invalid URL";}                  // KOD ZA PROVERU URL 
     $niz_lin=array();
     $niz_lin=$servis->vrati_linkove($_POST["id"], $starnovbool2);
     $countlinks=0;
     if($niz_lin)
     {
        foreach ($niz_lin as $lin) 
        {
            if(empty($_POST["link".$countlinks]) || (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["link".$countlinks])))
            {
                $servis->izbrisi_link($lin->id);
            }
            else
            {
                if($lin->link != $_POST["link".$countlinks])
                {
                    $lin->link = $_POST["link".$countlinks];
                    $servis->izmeni_link($lin);
                }
            }
            $countlinks += 1;
        }
     }
    
        if(!empty($_POST["link".$countlinks]) && (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["link".$countlinks])))
        {
            $novlink=new Link(10, $_POST["id"], 1, $_POST["link".$countlinks]);
            $servis->dodaj_link($novlink);
        } 
                
     $niz_sli=array();
     $niz_sli=$servis->vrati_slike($_POST["id"], $starnovbool2);
     $countslike=0;
     if($niz_sli)
     {
        foreach ($niz_sli as $sli) 
        {
            if(isset($_POST["slika".$countslike]))
            {
                $servis->izbrisi_sliku($sli->id);
            }
            $countslike += 1;
        }
     }
     $servis->izbrisi_glasali($_POST["id"]);
    $servis->dodaj_novost($str->id);
}

if(isset($_POST["glasda"]))
{
    if($_POST["izmenioo"] == $str->izmenio)
    {
            $glasa=$str->br_glasova+1;
            if(br_glasova+1 == 30)  // slanje e mail adminu
            {
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
                    $mail->Port = 587;
                    $mail->setFrom('elwiki.projekat@gmail.com', 'ElWiki');
                    $mail->addAddress('nikola.popovic@elfak.rs');
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Elwiki glasanje';
                    $mail->Body    = 'strana sa id '.$_POST["id"].'ima 30 pozitivnih glasova';
                    $mail->send();
                }
            catch (Exception $e) {}
            
        }
        $servis->izmeni_izmenjen_stranicu($str->id, $str->izmenjen_tekst, $str->izmenio, $glasa);
            $servis->dodaj_glasali($_POST["id"], $_SESSION["id"]);
    }
}
if(isset($_POST["glasne"]))
{
    if($_POST["izmenioo"] == $str->izmenio)
    {
        $glasa=$str->br_glasova-1;
        if(br_glasova-1 == -30)  // slanje e mail adminu
        {
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
                    $mail->Port = 587;
                    $mail->setFrom('elwiki.projekat@gmail.com', 'ElWiki');
                    $mail->addAddress('nikola.popovic@elfak.rs');
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Elwiki glasanje';
                    $mail->Body    = 'strana sa id '.$_POST["id"].'ima 30 negativnih glasova';
                    $mail->send();
                }
            catch (Exception $e) {}
        }
        $servis->izmeni_izmenjen_stranicu($str->id, $str->izmenjen_tekst, $str->izmenio, $glasa);
        $servis->dodaj_glasali($_POST["id"], $_SESSION["id"]);
    }
}


if(isset($_POST["submoderatordodaj"]))
{
    $str->original_tekst=$_POST["td"];
    $servis->izmeni_original_stranicu($str);
    $servis->dodaj_novost($str->id);
}

if(isset($_POST["submoderatornapravi"]))
{
    if($_POST["godina"] == 1)
        $smerr="nema";
    else
        $smerr=$_POST["smer"];
    $novastrana= new Stranica(100,$_POST["naziv"],0,"",NULL,NULL,$smerr, $_POST["godina"]);
    $servis->dodaj_stranicu($novastrana);
}
if(isset($_POST["submoderatorbrisi"]))
{
    if($_POST["idstrane"] > 10)
    {
        $servis->izbrisi_stranicu($_POST["idstrane"]);

        $servis->izbrisi_novost($_POST["idstrane"]);
    }
}

header("location: prikaz.php?id=".$_POST["id"]);
}
$str=$servis->vrati_stranicu($_GET["id"]);
if($_SESSION["uloga"] > 1 && $_GET["id"]>10)
    $adminvis="visibility: visible";
else
    $adminvis="visibility: hidden";
if($_SESSION["uloga"] > 1 && $_GET["id"] < 11)
    $admindodajvis="visibility: visible";
else
    $admindodajvis="visibility: hidden";
if($_SESSION["uloga"] > 0 && $_GET["id"] > 10)
    $izmenavis ="visibility: visible";
else
    $izmenavis= "visibility: hidden";
if(($_SESSION["uloga"] == 1 && $_GET["id"] > 2 && $_GET["id"] < 5) )
    $dodajvis ="visibility: visible";
else
    $dodajvis= "visibility: hidden";



?>

<!DOCTYPE html>
<html lang="en">

  <head>
		<title> <?php echo $str->naziv; ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	
	
	<!--Sumernote-->
		
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
		<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
		<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
		<script src="../summernote-master/menjanje.js"></script> 
		<script src="../summernote-master/bootbox.min.js"></script>
	
	<!--Sumernote-->
	
		
    <title>ElWiki</title>
	

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
	
    <!-- Plugin CSS -->
    <link href="../vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/creative.min.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
		<a href="../logedIn.php">
              <img class="img-responsive" src="../img/logo.png"  alt=""  height="100px">
        </a>
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
				  
				  <li><form action = "../Smerovi/PrvaGodina.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Prva Godina" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Smerovi/Elektonika.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Elektonika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Smerovi/RI.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Računarstvo i informatika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Smerovi/Elektroenergetika.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Elektroenergetika" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Smerovi/Komponente.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Komponente" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Smerovi/Telekomunikacije.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Telekomunikacije" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Smerovi/UpravljanjeSistemima.php" method = "POST">
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
				  
				  <li><form action = "../Vanredne aktivnosti/StudOrg.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Studentske organizacije" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Vanredne aktivnosti/Prakse.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Prakse" class="btn btn-primary1 dropdown-toggle"> </form></li>
				  <li><form action = "../Vanredne aktivnosti/Oglasi.php" method = "POST">
                  <input type="submit" name="subizmeninalog" value="Oglasi" class="btn btn-primary1 dropdown-toggle"> </form></li>
				</ul>
		</div>
		
		<div class="btn-group" id="mainbtn">
		
			
				<button type="button" class="btn btn-primary1 dropdown-toggle" data-toggle="dropdown">
				  Profil
				</button>
				<ul class="dropdown-menu" role="menu" style="background-color: #212529">
				 
                                  <li><form action = "../izmeniNalog.php" method = "POST">
                                  <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?> >
                                  <input type="submit" name="subizmeninalog" value="Moj profil" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
                                  <li><form action = "../korisnici.php" method = "POST">
                                  <input type="hidden" name="id" value=<?php echo $_SESSION["id"]; ?> >
                                  <input type="submit" name="subkorisnici" value="Korisnici" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
								  <li><form method = "POST" action = "../zaposleni.php">
                                  <input type="submit" name="" value="Zaposleni" class="btn btn-primary1 dropdown-toggle"> </form></li>
								  
								  <li><form action = "../logout.php" method = "POST">
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
			
			
			<div id="prvi">
                <?php 
                        if ($str->izmenio)
                        {
                            echo'<h4> Izmenjeno </h4>';
                        echo '<pre style="color:white">'.$str->izmenjen_tekst.'</pre>'; 
                        $niz_nl=array();   
                        $niz_nl = $servis->vrati_linkove($_GET["id"], 1);
                        if ($niz_nl)
                        {
                            echo '<br/><br/>';
                            foreach($niz_nl as $nl)
                            {
                                echo "<br/><a href='" .$nl->link. "'> " .$nl->link. " </a>";
                            }
                        }
                        $niz_ns=array();
                        $niz_ns=$servis->vrati_slike($_GET["id"], 1);
                        if ($niz_ns)
                        {
                            echo '<br/><br/>';
                            foreach($niz_ns as $ns)
                            {
                                //echo "<br/><a href='" .$nl->link. "'> " .$nl->link. " </a>";
                                echo '<img src="'.$ns->slika.'" width="250">';
                            }
                        }
                        $mogucnostglasa="";
                        if($servis->vrati_glasali($_GET["id"], $_SESSION["id"]))
                            {
                                $mogucnostglasa="disabled";
                            }
                        $kor=$servis->vrati_korisnika($str->izmenio);
                        echo "<br/> Izmenio: " .$kor->ime. " Broj glasova: " .$str->br_glasova. " ";
                        echo "<form action='prikaz.php' method='POST'>";
                        echo "<input type='hidden' name='id' value='".$_GET["id"]."'>";
                        echo "<input type='hidden' name='izmenioo' value='".$str->izmenio."'>";
                        echo "<input type='submit' name='glasda' value='da'".$mogucnostglasa.">";
                        echo "<input type='submit' name='glasne' value='ne'".$mogucnostglasa.">";
                        echo "</form>";
                        }
                ?>
            </div>
            <div id="drugi" >
                <?php
                if($str->izmenio)
                    echo '<h4> Neizmenjeno </h4>';
                
                echo '<pre style="color:white">'.$str->original_tekst.'</pre>';
                
                if($str->id > 4 && $str->id < 11)
                {
                    echo '<br/><br/><br/>1 godina:';
                    $napravi_niz=$servis->vrati_stranice('nema', 1);
                    foreach ($napravi_niz as $naprniz)
                    {
                        echo '<br/><a href="prikaz.php?id='.$naprniz->id.'">'.$naprniz->naziv.'</a>';
                    }
                    for ($index = 2; $index < 6; $index++) 
                    {
                        echo '<br/><br/>'.$index.' godina:';
                        $napravi_niz=$servis->vrati_stranice($str->naziv, $index);
                        foreach ($napravi_niz as $naprniz)
                        {
                            echo '<br/><a href="prikaz.php?id='.$naprniz->id.'">'.$naprniz->naziv.'</a>';
                        }
                    }
                }
                
                $niz_sl=array();
                $niz_sl=$servis->vrati_linkove($_GET["id"], 0);
                if($niz_sl)
                {
                    echo '<br/><br/>';
                    foreach ($niz_sl as $sl) 
                    {
                        echo "<br/><a href='". $sl->link .".'> ". $sl->link ." </a>";
                    }
                }
                $niz_ss=array();
                $niz_ss=$servis->vrati_slike($_GET["id"], 0);
                if($niz_ss)
                {
                    echo '<br/><br/>';
                    foreach ($niz_ss as $ss)
                    {
                        echo '<img src="'.$ss->slika.'" width="250">';
                    }
                }
                ?>
            </div>
            <div id="dodavanje" style= <?php echo $dodajvis; ?> >
                <p> Dodaj svoj tekst </p>
                <?php if($str->izmenjen_tekst) {  $string=$str->izmenjen_tekst;}  
                else { $string=$str->original_tekst;} ?>
                <form action="prikaz.php" method="POST">
                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
                    <textarea name="dtekst" rows="10" cols="100"  > </textarea>
                    <input type="submit" name="subdodaj" value="Dodaj">
                </form>
            </div>
            
            
			
			
			
			
        </div>
      </div>
    </header>
	<div style="margin:0 auto;">
		<div id="izmena" style=<?php echo $izmenavis;  ?>; class="text-center" >          <!-- IIIIIIIIIIIIIIZZZZZZZZZZZZZ-->
	                <p> Izmeni tekst </p>
	                <?php if($str->izmenio) 
	                    {  
	                        $string=$str->izmenjen_tekst;
	                        $starnovbool=1;    
	                    }  
	                else 
	                    { 
	                        $string=$str->original_tekst;
	                        $starnovbool=0;
	                    } ?>
	                <form action="prikaz.php" method="POST">
	                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
	                    <textarea name="ta" rows="10" cols="100" class="text-center"><?php echo $string; ?></textarea>
	                    <br/> <h5>Linkovi</h5>
	                <?php
	                $niz_li=array();
	                $niz_li=$servis->vrati_linkove($_GET["id"], $starnovbool);
	                $countlinks=0;
	                if($niz_li)
	                {
	                        foreach ($niz_li as $li) 
	                        {
	                            echo "<input type='text' name='link".$countlinks."' value='".$li->link."'>";
	                        $countlinks += 1;
	                        }
	                        
	                }
	                echo "<input type='text' name='link".$countlinks."' value=''>";
	                ?>
	                <br/> <h5>Slike</h5>
	                <?php
	                $niz_si=array();
	                $niz_si=$servis->vrati_slike($_GET["id"], $starnovbool);
	                $countslike=0;
	                if($niz_si)
	                {
	                    echo "<br/>";
	                    foreach ($niz_si as $si) 
	                    {
	                        echo '<img src="'.$si->slika.'" width="100">';
	                       echo '<input type="checkbox" name="slika'.$countslike.'" value="checked"><label> izbrisi ovu sliku</label>';
	                       $countslike += 1;
	                    }
	                }
	                // PRODUZITI FORM DOVDE????
	                ?>
	                <input type="submit" class="btn btn-primary btn-xl" name="subizmenitekstlinks" value="izmeni"/>
	                </form>
	                <form action="prikaz.php" method="POST" enctype="multipart/form-data">
	                    <p>Select image to upload:</p>
	                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
	                    <input type="file" name="image"/>
	                    <input type="submit" name="subslika" value="UPLOAD"/>
	                </form>
	                
	            </div>
	            
	            <div id="moderator" style=<?php echo $adminvis; ?> class="text-center">
	                <p>ADMIN KOMANDE:</p>
	                <form action="prikaz.php" method="post">
	                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
	                    <input type="submit" name="potvrdi" value="Potvrdi izmenjeno"/>
	                    <input type="submit" name="odbaci" value="Odbaci izmenjeno"/>
	                </form>
	            </div>
	            
	            <div id="moderatordodaj" style=<?php echo $admindodajvis; ?> >
	                <form action="prikaz.php" method="post">
	                    <p>ADMIN IZMENA:</p>
	                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
	                    <textarea name="td" rows="10" cols="100"  > <?php echo $str->original_tekst; ?>  </textarea>
	                    <input type="submit" name="submoderatordodaj" value="Izmeni">
	                </form>
	                <form action="prikaz.php" method="post">
	                    <p>Napravi stranicu za nov predmet:</p>
	                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
	                    <label>Naziv:</label><input type="text" name="naziv">
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
	                    <input type="submit" name="submoderatornapravi" value="Napravi">
	                </form>
	                <form action="prikaz.php" method="post">
	                    <p>Izbrisi stranicu predmeta:</p>
	                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
	                    <label>ID stranice:</label><input type="text" name="idstrane">
	                    <input type="submit" name="submoderatorbrisi" value="Izbrisi">
	                </form>
	            </div>
    </div> 
   

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