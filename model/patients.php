<?php 
namespace model;
use model\Dossier;
use model\users;

class patients extends users
{

    private $nom;
    private $prenom;
    private $date_naissance;
    private $sexe;
    private $adresse;


    public function __construct(  $telephone, $numero_peronne_rev, 
                                 string $nom, string $prenom, string $date_naissance, 
                                string $sexe, string $adresse)
    {
        parent::__construct(null, null, $telephone, $numero_peronne_rev, null);
      
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->sexe = $sexe;
        $this->adresse = $adresse;
    }

    // Getters and Setters



    public function getNom(): string {
        return $this->nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function getDateNaissance(): string {
        return $this->date_naissance;
    }

    public function getSexe(): string {
        return $this->sexe;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

  

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function setDateNaissance(string $date_naissance): void {
        $this->date_naissance = $date_naissance;
    }

    public function setSexe(string $sexe): void {
        $this->sexe = $sexe;
    }

    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }
}