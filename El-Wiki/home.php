<?php
session_start();
include_once 'lib.php';
if(!isset($_SESSION["id"]))
    header("location: index.php");
$servis= new Service();
?>

<!doctype html>
<html>
	<head>
		<title> Pocetna </title>
		<!--<link rel="stylesheet" href="primer1.css" /> -->
	</head>
	<body>
		<div id="main">
                    <h1>Neki opis</h1>
                    <form action="prikaz.php" method="GET">
                    <select name="id" size="1"> 
                      <option value="1">Zaposleni</option>
                      <option value="2">Studentske Organizacije</option>
                      <option value="3">Prakse</option>
                      <option value="4">Oglasi</option>
                      <option value="5">Elektroenergetika</option>
                      <option value="6">Elektronske komponente i mikrosistemi</option>
                      <option value="7">Racunarstvo i informatika</option>
                      <option value="8">Upravljanje sistemima</option>
                      <option value="9">Elektronika</option>
                      <option value="10">Telekomunikacije</option>
                    </select>
                        <input type = "submit" value = "Submit"/><br />
                        
                        
                    </form>
		</div>
            <div id="novosti">
                <?php 
                $niz_novosti = $servis->vrati_sve_novosti();
                if($niz_novosti)
                {
                    echo '<br/>Nedavne izmene:';
                    echo '<br/>Stranica | Datum';
                    foreach ($niz_novosti as $novost) 
                    {
                        $strana=$servis->vrati_stranicu($novost->stranica);
                        if($strana)
                        {
                        echo '<br/>'.$strana->naziv.' | '.$novost->datum_promene;
                        }
                    }
                }
                ?>
            </div>
            <div id="opsti dugmici">
                <form action="izmeniNalog.php" method="POST">
                        <input type="button" value="Lista korisnika" onclick="window.location.href='korisnici.php'" />
                        <input type="button" value="Odjavi se" onclick="window.location.href='logout.php'" />
                        <input type="hidden" name="id" value= <?php echo $_SESSION["id"]; ?> />
                        <input type="submit" value="Izmeni svoj nalog" />
                    </form>
            </div>

		<!--<script src="javaskript.js"></script>-->
	</body>

</html>
