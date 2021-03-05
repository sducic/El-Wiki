<?php

class Korisnik
{
    var $id;
    var $ime;
    var $mail;
    var $lozinka;
    var $uloga;
    var $smer;
    var $godina;
    var $confirmcode;
    var $active;
    
    public function __construct($id, $im, $ma, $lo, $ul, $sm, $go,$cc,$a)
    {
        $this->id=$id;
        $this->ime=$im;
        $this->mail=$ma;
        $this->lozinka=$lo;
        $this->uloga=$ul;
        $this->smer=$sm;
        $this->godina=$go;
        $this->confirmcode=$cc;
        $this->active=$a;
    }
}

class Stranica
{
    var $id;
    var $naziv;
    var $br_glasova;
    var $original_tekst;
    var $izmenjen_tekst;
    var $izmenio;
    var $smer;
    var $godina;
    
    public function __construct($id, $naziv, $br_glasova, $original_tekst, $izmenjen_tekst, $izmenio, $smer, $godina)
    {
        $this->id=$id;
        $this->naziv=$naziv;
        $this->br_glasova=$br_glasova;
        $this->original_tekst=$original_tekst;
        $this->izmenjen_tekst=$izmenjen_tekst;
        $this->izmenio=$izmenio;
        $this->smer=$smer;
        $this->godina=$godina;
    }
}

class Novost
{
    var $id;
    var $stranica;
    var $datum_promene;
    
    public function __construct($id, $stranica, $datum_promene)
    {
        $this->id=$id;
        $this->stranica=$stranica;
        $this->datum_promene=$datum_promene;
    }
}

class Link
{
    var $id;
    var $stranica;
    var $starnov;
    var $link;
    public function __construct($id, $stranica, $starnov, $link)
    {
        $this->id=$id;
        $this->stranica=$stranica;
        $this->starnov=$starnov;
        $this->link=$link;
    }
}

class Slika
{
    var $id;
    var $stranica;
    var $starnov;
    var $slika;
    public function __construct($id, $stranica, $starnov, $slika)
    {
        $this->id=$id;
        $this->stranica=$stranica;
        $this->starnov=$starnov;
        $this->slika=$slika;
    }
}


?>
