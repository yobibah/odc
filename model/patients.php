<?php

namespace model;

use model\users;

class patients extends users
{

    private $date_naissance;
    private $sexe;
    private $groupe_sanguine;
    private $adresse;


    public function __construct(
        $nom,
        $prenom,
        $telephone,
        $password,
        $date_creation,
        $role,
        string $date_naissance,
        string $sexe,
        string $groupe_sanguine,
        string $adresse
    ) {
        parent::__construct($nom, $prenom, $telephone, $password, $date_creation, $role);

        $this->date_naissance = $date_naissance;
        $this->sexe = $sexe;
        $this->groupe_sanguine = $groupe_sanguine;
        $this->adresse = $adresse;
    }

    // Getters and Setters


    public function getDateNaissance(): string
    {
        return $this->date_naissance;
    }
    public function getGroupeSanguine(): string
    {
        return $this->groupe_sanguine;
    }


    public function getSexe(): string
    {
        return $this->sexe;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }
    public function setGroupeSanguine(string $groupe_sanguine): void
    {
        $this->groupe_sanguine = $groupe_sanguine;
    }

    public function setDateNaissance(string $date_naissance): void
    {
        $this->date_naissance = $date_naissance;
    }

    public function setSexe(string $sexe): void
    {
        $this->sexe = $sexe;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }
}
