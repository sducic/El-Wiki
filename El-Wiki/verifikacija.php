<?php
    include_once 'lib.php';
    
    $email=$_GET['email'];
    $confirmcode=$_GET['confirmcode'];

            

    $servis=new Service();
    $korisnik=$servis->uporediKorisnika($email, $confirmcode);
    
    if($korisnik)
    {  
        $servis->izmeni_korisnika2($korisnik);
        echo "Uspesno ste verifikovali nalog";
        echo "<br>";
        echo  "Stranica za logovanje ce automatski biti prikazana, sacekajte.";
        header( "refresh:5;url=index.php" );
    }
    else
        echo "Doslo je do greske";


?>
                  