<?php 
namespace model;

class medecin extends Users{
private string $specialite;
private string $id_centre;

public function __construct($specialite,$id_centre,string $nom,$prenom, string $password, string $telephone)
{
    parent::__construct($nom, $prenom, $telephone, $password);
    $this->specialite = $specialite;
    $this->id_centre = $id_centre;
}
public function getSpecialite(): string
{
    return $this->specialite;
}

public function setSpecialite(string $specialite): void
{
    $this->specialite = $specialite;
}

public function getId_centre(): string
{
    return $this->id_centre;
}
public function setId_centre(string $id_centre): void
{
    $this->id_centre = $id_centre;
}
}