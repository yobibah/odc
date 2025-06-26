<?php 
namespace model;

class Dossier{

    private string $numero_dossier;
    private string $date_creation;
    private int $id_patient;
    private string $motif;
    private string $statut;

    public function __construct(string $numero_dossier, string $date_creation, int $id_patient, string $motif, string $statut)
    {
        
        $this->numero_dossier = $numero_dossier;
        $this->date_creation = $date_creation;
        $this->id_patient = $id_patient;
        $this->motif = $motif;
        $this->statut = $statut;
    }
   
    public function getNumeroDossier(): string {
        return $this->numero_dossier;
    }
    public function getDateCreation(): string {
        return $this->date_creation;
    }
    public function getIdPatient(): int {
        return $this->id_patient;
    }
    public function getMotif(): string {
        return $this->motif;
    }
    public function getStatut(): string {
        return $this->statut;
    }
  
    public function setNumeroDossier(string $numero_dossier): void {
        $this->numero_dossier = $numero_dossier;
    }
    public function setDateCreation(string $date_creation): void {
        $this->date_creation = $date_creation;
    }
    public function setIdPatient(int $id_patient): void {
        $this->id_patient = $id_patient;
    }
    public function setMotif(string $motif): void {
        $this->motif = $motif;
    }
    public function setStatut(string $statut): void {
        $this->statut = $statut;
    }

}