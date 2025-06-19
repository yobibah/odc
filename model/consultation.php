<?php 
//cette partie est utilise pour rapppler les prises de rendez vous du client;
namespace model;
class consultation{
    private $id_client;
    private $date;
    private $heure;
  
    private $nom_medecin;
    private string $hoiptal;

    public function __construct($id_client,$date,$heure,$nom_medecin,$hoiptal){
        $this->id_client=$id_client;
        $this->date=$date;
        $this->heure=$heure;
        $this->nom_medecin=$nom_medecin;
        $this->hoiptal=$hoiptal;
    }
    public function getId_client(){
        return $this->id_client;
    }
    public function getDate(){
        return $this->date;
    }
    public function getHeure(){
        return $this->heure;
    }
    public function getNom_medecin(){
        return $this->nom_medecin;
    }
    public function getHoiptal(){
        return $this->hoiptal;
    }
    public function setId_client($id_client){
        $this->id_client=$id_client;
    }
    public function setDate($date){
        $this->date=$date;
    }
}