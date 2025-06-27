<?php
namespace model;

class document{
    private $patient_id;
    private $titre;
    private $fichier;
    private $type_document;
    private $date_ajout;

    public function __construct($patient_id, $titre, $fichier, $type_document, $date_ajout)
    {
        $this->patient_id = $patient_id;
        $this->titre = $titre;
        $this->fichier = $fichier;
        $this->type_document = $type_document;
        $this->date_ajout = $date_ajout;
    }
    public function getPatientId(){
        return $this->patient_id;
    }

    public function getTitre(){
        return $this->titre;
    }

    public function getFichier(){
        return $this->fichier;
    }

    public function getTypeDocument(){
        return $this->type_document;
    }

    public function getDateAjout(){
        return $this->date_ajout;
    }

}
