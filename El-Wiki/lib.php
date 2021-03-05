<?php
include_once 'data.php';
include_once 'IService.php';

class Service implements IService
{
    const db_host = "localhost";
    const db_korisnicko_ime = "root";
    const db_lozinka = "";
    const db_ime_baze = "ElWiki";

    function vrati_sve_korisnike()  //////////OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    {
    
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze); 
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare(
                    "SELECT id, ime, mail, lozinka, uloga, smer, godina,confirmcode,active "
                    . "FROM korisnik ORDER BY godina ASC");
            
            //$naredba->bind_param('sssisisi', $korisnik->ime, $korisnik->mail, $korisnik->lozinka, $korisnik->uloga, $korisnik->smer, $korisnik->godina,$korisnik->confirmcode,$korisnik->active);

            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);

            if ($rezultat) 
            {
                $niz = array();
                while ($naredba->fetch()) 
                {
                    $niz[$id] = new Korisnik($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
                }
                $naredba->close();
                $konekcija->close();
                return $niz;
            }
            else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } 
            else 
            {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }

    function vrati_korisnika($paramID) 
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("SELECT * FROM korisnik WHERE id=?"); ///OOOOOOOOO
            $naredba->bind_param("i", $paramID);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
            $korisnik = NULL;
            if ($rezultat) 
            {
                if ($naredba->fetch()) 
                {
                    $korisnik = new Korisnik($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
                }
                $naredba->close();
                $konekcija->close();
                return $korisnik;
            } else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    function vrati_korisnika_mp($m, $p)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("SELECT * FROM korisnik WHERE mail=? AND lozinka=?"); ///OOOOOOOOO
            $naredba->bind_param('ss', $m, $p);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
            $korisnik = NULL;
            if ($rezultat) 
            {
                if ($naredba->fetch()) 
                {
                    $korisnik = new Korisnik($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
                }
                $naredba->close();
                $konekcija->close();
                return $korisnik;
            } else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    
    //*************************
    function uporediKorisnika($m, $p)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("SELECT * FROM korisnik WHERE mail=? AND confirmcode=?"); 
            $naredba->bind_param('ss', $m, $p);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
            $korisnik = NULL;
           // $match=0;
            if ($rezultat) 
            {
                if ($naredba->fetch()) 
                {
                    $korisnik = new Korisnik($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
                   // $match=1;
                }
                $naredba->close();
                $konekcija->close();
                return $korisnik;
            } else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    function uporediActive($korid)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("SELECT * FROM korisnik WHERE id=? and active='1' ");
            $naredba->bind_param('i',$korid);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
            $korisnik = NULL;
            $match=0;
            if ($rezultat) 
            {
                if ($naredba->fetch()) 
                {
                    $korisnik = new Korisnik($id, $ime, $mail, $lozinka, $uloga, $smer, $godina,$confirmcode,$active);
                    $match=1;
                }
                $naredba->close();
                $konekcija->close();
                return $match;
            } else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    
    function izmeni_korisnika2(Korisnik $korisnik)  
    {
         $con = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
    if ($con->connect_errno)
    {
        print ("Connection error (" . $con->connect_errno . "): $con->connect_error");
    }
    else
    {
        $res = $con->query("update korisnik set confirmcode = '0',active='1' where id = '$korisnik->id'");
        if (!$res)
        {
            print ("Query failed");
        }
        return $res;
    }
    }
    //*************************
    
    function dodaj_korisnika(Korisnik $korisnik)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("INSERT INTO korisnik (ime, mail, lozinka, uloga, smer, godina,confirmcode,active) VALUES ("
                    . "?, ?, ?, ?, ?, ?,?,?)");
            // "i" označava celobrojni tip podataka. 
            // "s" označava string tip podataka.
            // "d" označava realni tip podataka.
            // PARAMETRI SE NAVODE PO REDOSLEDU U KOM SE OČEKUJU U PRIPREMLJENOM UPITU!
            $naredba->bind_param('sssisisi', $korisnik->ime, $korisnik->mail, $korisnik->lozinka, $korisnik->uloga, $korisnik->smer, $korisnik->godina,$korisnik->confirmcode,$korisnik->active);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izbrisi_korisnika($id)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("DELETE FROM korisnik WHERE id=?");
            $naredba->bind_param("i", $id);        
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    // U slučaju greške pri izvršenju upita odštampati odgovarajucu poruku
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    // U slučaju greške pri izvršenju upita odštampati odgovarajucu poruku
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izmeni_korisnika(Korisnik $korisnik)  //////OOOOOOOOOOOOOO  SAMO JEDNA IZMENA??????
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
           $naredba = $konekcija->prepare("UPDATE korisnik SET ime=?, mail=?, lozinka=?, uloga=?, smer=?, godina=? "
                    . "WHERE id=?");
            $naredba->bind_param('sssisii', $korisnik->ime, $korisnik->mail, $korisnik->lozinka, $korisnik->uloga, $korisnik->smer, $korisnik->godina, $korisnik->id);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();

            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function dodaj_stranicu(Stranica $str)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("INSERT INTO stranica (naziv, smer, godina, original_tekst) VALUES ("
                    . "?, ?, ?, ?)");
            // "i" označava celobrojni tip podataka. 
            // "s" označava string tip podataka.
            // "d" označava realni tip podataka.
            // PARAMETRI SE NAVODE PO REDOSLEDU U KOM SE OČEKUJU U PRIPREMLJENOM UPITU!
            $naredba->bind_param('ssis', $str->naziv, $str->smer, $str->godina, $str->original_tekst);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izbrisi_stranicu($id)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("DELETE FROM stranica WHERE id=?");
            $naredba->bind_param("i", $id);        
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izmeni_izmenjen_stranicu($idstrane, $tekst, $izmenio, $brglasova)   //OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
           $naredba = $konekcija->prepare("UPDATE stranica SET izmenjen_tekst=?, izmenio=?, br_glasova=? "
                    . "WHERE id=?");
            $naredba->bind_param('siii', $tekst, $izmenio, $brglasova, $idstrane);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izmeni_original_stranicu(Stranica $str)//POTVRDJENA PROMENA STRANE
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
           $naredba = $konekcija->prepare("UPDATE stranica SET naziv=?,original_tekst=?,smer=?,godina=?,izmenjen_tekst=?, izmenio=?, br_glasova=? "
                    . "WHERE id=?");
            $naredba->bind_param('sssisiii', $str->naziv, $str->original_tekst, $str->smer, $str->godina, $str->izmenjen_tekst, $str->izmenio, $str->br_glasova, $str->id);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function vrati_stranice($smer, $godina)  //////////OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    {
    
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze); 
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare(
                    "SELECT * "
                    . "FROM stranica WHERE smer=? AND godina=? ORDER BY godina ASC");
            $naredba->bind_param("si", $smer, $godina);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $naziv, $br_glasova, $original_tekst, $izmenjen_tekst, $izmenio, $smer, $godina);

            if ($rezultat) 
            {
                $niz = array();
                while ($naredba->fetch()) 
                {
                    $niz[$id] = new Stranica($id, $naziv, $br_glasova, $original_tekst, $izmenjen_tekst, $izmenio, $smer, $godina);
                }
                $naredba->close();
                $konekcija->close();
                return $niz;
            }
            else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } 
            else 
            {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }

    function vrati_stranicu($paramID) 
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("SELECT * FROM stranica WHERE id=?"); ///OOOOOOOOO
            $naredba->bind_param("i", $paramID);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $naziv, $br_glasova, $original_tekst, $izmenjen_tekst, $izmenio, $smer, $godina);
            $stranica = NULL;
            if ($rezultat) 
            {
                if ($naredba->fetch()) 
                {
                    $stranica = new Stranica($id, $naziv, $br_glasova, $original_tekst, $izmenjen_tekst, $izmenio, $smer, $godina);
                }
                $naredba->close();
                $konekcija->close();
                return $stranica;
            } else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    function dodaj_glasali($idstr, $idkor)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("INSERT INTO glasali (predmet, korisnik) VALUES ("
                    . "?, ?)");
            // "i" označava celobrojni tip podataka. 
            // "s" označava string tip podataka.
            // "d" označava realni tip podataka.
            // PARAMETRI SE NAVODE PO REDOSLEDU U KOM SE OČEKUJU U PRIPREMLJENOM UPITU!
            $naredba->bind_param('ii', $idstr, $idkor);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izbrisi_glasali($idstr)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("DELETE FROM glasali WHERE predmet=?");
            $naredba->bind_param("i", $idstr);        
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function vrati_glasali($idstr, $idkor)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("SELECT korisnik FROM glasali WHERE predmet=? AND korisnik=?"); ///OOOOOOOOO
            $naredba->bind_param("ii", $idstr, $idkor);
            $rezultat = $naredba->execute();
            $naredba->bind_result($korisnik);
            $korisnik = NULL;
            if ($rezultat) 
            {
                $naredba->fetch();
                
                $naredba->close();
                $konekcija->close();
                return $korisnik;
            } else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    function dodaj_novost($idstr)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error"); //////OVDEEEEEEEEEE
        } 
        else 
        {
            $brojac0=0;
                $maxnovosti=6;
                $duplikat= -1;
                $odIdBrisi= -1;
            $naredba0 = $konekcija->prepare("SELECT id, stranica, datum_promene FROM novosti ORDER BY id DESC");
            $rezultat0 = $naredba0->execute();
            $naredba0->bind_result($id, $stranica, $datum_promene);
            if ($rezultat0) 
            {
                $niz = array();
                while ($naredba0->fetch()) 
                {
                    if($brojac0 == 0 && $idstr == $stranica)
                    {
                        $duplikat=$id;
                        $maxnovosti++;
                    }
                    $niz[$brojac0] = new Novost($id, $stranica, $datum_promene);
                    $brojac0++;
                    if($brojac0 == $maxnovosti-1)
                        $odIdBrisi=$id;
                }
                $naredba0->close();
                //$konekcija->close();
                //return $niz;
            }
            
            if($duplikat != -1)
            {
                $naredba1 = $konekcija->prepare("DELETE FROM novosti WHERE id = ?");
                $naredba1->bind_param("i", $duplikat);        
                $rezultat1 = $naredba1->execute();
                $naredba1->close();
                //$konekcija->close();
                if (!$rezultat1) {
                    if ($konekcija->errno) {
                        print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                    } else {
                        print ("Nepoznata greška pri izvrsenju upita");
                    }
                }
            }
            
            if($odIdBrisi != -1)
            {
                $naredba2 = $konekcija->prepare("DELETE FROM novosti WHERE id < ?");
                $naredba2->bind_param("i", $odIdBrisi);        
                $rezultat2 = $naredba2->execute();
                $naredba2->close();
                //$konekcija->close();
                if (!$rezultat2) 
                {
                    if ($konekcija->errno) {
                        print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                    } else {
                        print ("Nepoznata greška pri izvrsenju upita");
                    }
                }
            }
            
            date_default_timezone_set('Europe/Belgrade');
            $date = date('Y-m-d H:i:s');
            $naredba = $konekcija->prepare("INSERT INTO novosti (stranica, datum_promene) VALUES (?, ?)");
            $naredba->bind_param('is', $idstr, $date);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) 
            {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izbrisi_novost($id)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("DELETE FROM novosti WHERE stranica=?");
            $naredba->bind_param("i", $id);        
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function vrati_sve_novosti() 
    {
    
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze); 
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare(
                    "SELECT * "
                    . "FROM novosti ORDER BY id DESC");
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $ids, $dat);

            if ($rezultat) 
            {
                $niz = array();
                while ($naredba->fetch()) 
                {
                    $niz[$id] = new Novost($id, $ids, $dat);
                }
                $naredba->close();
                $konekcija->close();
                return $niz;
            }
            else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } 
            else 
            {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    function dodaj_link(Link $link)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("INSERT INTO linkovi (stranica, starnov, link) VALUES ("
                    . "?, ?, ?)");
            $naredba->bind_param('iis', $link->stranica, $link->starnov, $link->link);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function izbrisi_link($id)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("DELETE FROM linkovi WHERE id=?");
            $naredba->bind_param("i", $id);        
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function vrati_linkove($idstr, $sn)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze); 
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare(
                    "SELECT * "
                    . "FROM linkovi WHERE stranica=? AND starnov=?");
            $naredba->bind_param("ii", $idstr, $sn);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $stranica, $starnov, $link);
            if ($rezultat) 
            {
                $niz = array();
                while ($naredba->fetch()) 
                {
                    $niz[$id] = new Link($id, $stranica, $starnov, $link);
                }
                $naredba->close();
                $konekcija->close();
                return $niz;
            }
            else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } 
            else 
            {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
    
    function dodaj_sliku(Slika $slika) //id,idstr,starnov,imgcontent i
    {
        
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("INSERT INTO slike (stranica, starnov, slika) VALUES ("
                    . "?, ?, ?)");
            $null=NULL;
            $naredba->bind_param('iib', $slika->stranica, $slika->starnov, $null);
            $naredba->send_long_data(2, $slika->slika);
            $rezultat = $naredba->execute();
            //$naredba->close();
            //$konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
            $naredba->close();
            $konekcija->close();
            return $rezultat;
        }
    }
    
    
    function izbrisi_sliku($id)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare("DELETE FROM slike WHERE id=?");
            $naredba->bind_param("i", $id);        
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    // U slučaju greške pri izvršenju upita odštampati odgovarajucu poruku
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    // U slučaju greške pri izvršenju upita odštampati odgovarajucu poruku
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
    
    function vrati_slike($idstr, $sn)
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze); 
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
            $naredba = $konekcija->prepare(
                    "SELECT * "
                    . "FROM slike WHERE stranica=? AND starnov=?");
            $naredba->bind_param("ii", $idstr, $sn);
            $rezultat = $naredba->execute();
            $naredba->bind_result($id, $stranica, $starnov, $slika);

            if ($rezultat) 
            {
                $niz = array();
                while ($naredba->fetch()) 
                {
                    $niz[$id] = new Slika($id, $stranica, $starnov, $slika);
                }
                $naredba->close();
                $konekcija->close();
                return $niz;
            }
            else if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } 
            else 
            {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }

    function izmeni_link(Link $link) 
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
           $naredba = $konekcija->prepare("UPDATE linkovi SET stranica=?,starnov=?,link=? "
                    . "WHERE id=?");
            $naredba->bind_param('iisi', $link->stranica, $link->starnov, $link->link, $link->id);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }

    function izmeni_sliku(Slika $slika) // MENJA SAMO STRANICA I STARNOV
    {
        $konekcija = new mysqli(self::db_host, self::db_korisnicko_ime, self::db_lozinka, self::db_ime_baze);
        $konekcija->set_charset('utf8');
        if ($konekcija->connect_errno) 
        {
            print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
        } 
        else 
        {
           $naredba = $konekcija->prepare("UPDATE slike SET stranica=?,starnov=? "
                    . "WHERE id=?");
            $naredba->bind_param('iii', $slika->stranica, $slika->starnov, $slika->id);
            $rezultat = $naredba->execute();
            $naredba->close();
            $konekcija->close();
            if (!$rezultat) {
                if ($konekcija->errno) {
                    print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
                } else {
                    print ("Nepoznata greška pri izvrsenju upita");
                }
            }
        }
    }
}
?>