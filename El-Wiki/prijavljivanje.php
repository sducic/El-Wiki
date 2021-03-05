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
         
             header("location: home.php");
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
<html>
   
   <head>
      <title>Prijavi se</title>
      
      <style type = "text/css">
         
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
                <form action = "prijavljivanje.php" method = "post">
                  <label>E-Mail: </label><input type = "text" name = "mail" class = "box"/><br /><br />
                  <label>Lozinka: </label><input type = "password" name = "lozinka" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
               <p>Nemate nalog? <a href="registracija.php"> Registruj se </a> </p>			
            </div>				
         </div>	
          <div id="opsti dugmici">
                <form action="" method="POST">
                        <input type="button" value="Vrati se na pocetnu" onclick="window.location.href='home.php'" />
                    </form>
            </div>
      </div>

   </body>
</html>
