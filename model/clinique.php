<?php 
namespace model;

class Clinique{
     private $nom;
    private $numero;
    private $longitute;
    private $latitude;
    private $ville;
    private  $quartier;
    private $rue;
    private $id_service;

    public function __construct($nom,$numero,$longitute,$latitude,$ville,$quartier,$rue,$id_service)
    {
          $this->nom = $nom;
        $this->numero = $numero;
        $this->longitute = $longitute;
        $this->latitude = $latitude;
        $this->ville = $ville;
        $this->quartier = $quartier;
        $this->rue = $rue;
        $this->id_service=$id_service;

    }
       public function getNomC() {
        return $this->nom;
    }
    public function getNumeroC() {
        return $this->numero;
    }
    public function getLongituteC() {
        return $this->longitute;
    }

     public function getLatitudeC() {
        return $this->latitude;
    }

    public function getVilleC(){
        return $this->ville;
    }

    
    public function getQuartierC(){
        return $this->quartier;
    }
    
    public function getrueC(){
        return $this->rue;
    }
      public function getIDserviceC(){
        return $this->id_service;
    }
}