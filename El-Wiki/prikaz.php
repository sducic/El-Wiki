<?php
session_start();

require 'C:\wamp64\bin\apache\apache2.4.33\htdocs\PHPMailer-master\vendor\autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once 'lib.php';
if(!isset($_SESSION["id"]) || !isset($_GET["id"]) && !isset($_POST["id"]))
    header("location: index.php");
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
            $servis->izmeni_izmenjen_stranicu($str->id, $str->izmenjen_tekst, $str->izmenio, $glasa);
            $servis->dodaj_glasali($_POST["id"], $_SESSION["id"]);
        }
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
<!doctype html>
<html>
	<head>
            <title> <?php echo $str->naziv; ?> </title>
	</head>
	<body>
            <div id="prvi">
                <?php 
                        if ($str->izmenio)
                        {
                            echo'<h4> Izmenjeno </h4>';
                        echo '<pre>'.$str->izmenjen_tekst.'</pre>'; 
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
            <div id="drugi">
                <?php
                if($str->izmenio)
                    echo '<h4> Neizmenjeno </h4>';
                
                echo '<pre>'.$str->original_tekst.'</pre>';
                
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
            
            <div id="izmena" style= <?php echo $izmenavis;  ?> >          <!-- IIIIIIIIIIIIIIZZZZZZZZZZZZZ-->
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
                    <textarea name="ta" rows="10" cols="100" ><?php echo $string; ?></textarea>
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
                        echo '<img src="'.$si->slika.'" width="250">';
                       echo '<input type="checkbox" name="slika'.$countslike.'" value="checked"><label> izbrisi ovu sliku</label>';
                       $countslike += 1;
                    }
                }
                // PRODUZITI FORM DOVDE????
                ?>
                <input type="submit" name="subizmenitekstlinks" value="izmeni"/>
                </form>
                <form action="prikaz.php" method="POST" enctype="multipart/form-data">
                    <p>Select image to upload:</p>
                    <input type="hidden" name="id" value=<?php echo $_GET["id"]; ?> >
                    <input type="file" name="image"/>
                    <input type="submit" name="subslika" value="UPLOAD"/>
                </form>
                
            </div>
            
            <div id="moderator" style=<?php echo $adminvis; ?> >
                <p>ADMIN COMMANDS:</p>
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
            <div id="opsti dugmici">
                <form action="izmeniNalog.php" method="POST">
                        <input type="hidden" name="id" value= <?php echo $_SESSION["id"]; ?> />
                        <input type="button" value="Vrati se na pocetnu" onclick="window.location.href='home.php'" />
                        <input type="button" value="Odjavi se" onclick="window.location.href='logout.php'"/>
                        <input type="submit" value="Izmeni svoj nalog" />
                    </form>
            </div>
	</body>
 </html>

