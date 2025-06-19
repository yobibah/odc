<?php 
// cette partie sera utilise pour complter les donnes sensibles de l'utilisateur

namespace model;

class Medicament{
    private $users_id;
    private string $libelle;
    private $heureprise;

    public function __construct($users_id,string $libelle,$heure_prise){
        $this->users_id=$users_id;
        $this->libelle=$libelle;
        $this->heureprise=$heure_prise;
    }
    public function getId_client(){
        return $this->users_id;
    }
    public function getLibelle(){
        return $this->libelle;
    }
    public function getHeureprise(){
        return $this->heureprise;
    }
}