<?php


interface IService 
{
    public function vrati_sve_korisnike();
    public function vrati_korisnika($paramID);
    public function vrati_korisnika_mp($m, $p);
    public function dodaj_korisnika(Korisnik $korisnik);
    public function izbrisi_korisnika($id);
    public function izmeni_korisnika(Korisnik $korisnik);
    public function dodaj_stranicu(Stranica $str);
    public function izbrisi_stranicu($id);
    public function izmeni_izmenjen_stranicu($idstrane, $tekst, $izmenio, $brglasova);
    public function izmeni_original_stranicu(Stranica $str);
    public function vrati_stranice($smer, $godina);
    public function vrati_stranicu($paramID);
    public function dodaj_glasali($idstr, $idkor);
    public function izbrisi_glasali($idstr);
    public function vrati_glasali($idstr, $idkor);
    public function dodaj_novost($idstr);
    public function izbrisi_novost($id);
    public function vrati_sve_novosti();
    public function dodaj_link(Link $link);
    public function izbrisi_link($id);
    public function izmeni_link(Link $link);
    public function vrati_linkove($idstr, $sn);
    public function dodaj_sliku(Slika $slika);
    public function izbrisi_sliku($id);
    public function vrati_slike($idstr, $sn);
    public function izmeni_sliku(Slika $slika);// MENJA SAMO STRANICA I STARNOV
    
    
}
