<?php 
namespace model;

class Antecedent{
  
    private string $libelle;

    public function __construct(string $libelle)
    {
        $this->libelle=$libelle;
       

    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    // ajout de certanes methodes si necessaires

}