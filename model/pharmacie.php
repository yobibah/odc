<?php 
namespace model;

class Pharmacie{
    private $nom;
    private $numero;
    private $longitute;
    private $latitude;
    private $ville;
    private  $quartier;
    private $rue;

    public function __construct($nom, $numero, $longitute, $latitude, $ville, $quartier, $rue) {
        $this->nom = $nom;
        $this->numero = $numero;
        $this->longitute = $longitute;
        $this->latitude = $latitude;
        $this->ville = $ville;
        $this->quartier = $quartier;
        $this->rue = $rue;
    }

    public function getNom() {
        return $this->nom;
    }
    public function getNumero() {
        return $this->numero;
    }
    public function getLongitute() {
        return $this->longitute;
    }

    public function getVille(){
        return $this->ville;
    }

    
    public function getQuartier(){
        return $this->quartier;
    }
    
    public function getrue(){
        return $this->rue;
    }
    // les setters ici . facultatifs

}