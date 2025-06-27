<?php 
namespace model;

use model\consultation;
use config\Config;
use PDO;

class consultationBDD extends consultation{
    private $pdo;

    public function __construct()
    {
        $this->pdo = config::getpdo()->getconnexion();
    }

    public function addConsultation(consultation $consultation)
    {
        $sql = "INSERT INTO consultations (patient_id, medecin_id, date_consultation, motif, diagnostique, traitement, note) 
                VALUES (:patient_id, :medecin_id, :date_consultation, :motif, :diagnostique, :traitement, :note)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $consultation->getPatientId());
        $stmt->bindValue(':medecin_id', $consultation->getMedecinId());
        $stmt->bindValue(':date_consultation', $consultation->getDateConsultation());
        $stmt->bindValue(':motif', $consultation->getMotif());
        $stmt->bindValue(':diagnostique', $consultation->getDiagnostique());
        $stmt->bindValue(':traitement', $consultation->getTraitement());
        $stmt->bindValue(':note', $consultation->getNote());

        return $stmt->execute();
    }
    public function getConsultationsByPatientId($patientId)
    {
        $sql = "SELECT * FROM consultations WHERE patient_id = :patient_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $patientId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getConsultationById($id)
    {
        $sql = "SELECT * FROM consultations WHERE consultation_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateConsultation(consultation $consultation)
    {
        $sql = "UPDATE consultations SET patient_id = :patient_id, medecin_id = :medecin_id, date_consultation = :date_consultation, motif = :motif, diagnostique = :diagnostique, traitement = :traitement, note = :note WHERE consultation_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $consultation->getPatientId());
        $stmt->bindValue(':medecin_id', $consultation->getMedecinId());
        $stmt->bindValue(':date_consultation', $consultation->getDateConsultation());
        $stmt->bindValue(':motif', $consultation->getMotif());
        $stmt->bindValue(':diagnostique', $consultation->getDiagnostique());
        $stmt->bindValue(':traitement', $consultation->getTraitement());
        $stmt->bindValue(':note', $consultation->getNote());

        return $stmt->execute();
    }
    public function deleteConsultation($id)
    {
        $sql = "DELETE FROM consultations WHERE consultation_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
    public function countConsultationsByPatientId($patientId)
    {
        $sql = "SELECT COUNT(*) FROM consultations WHERE patient_id = :patient_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $patientId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function countConsultations()
    {
        $sql = "SELECT COUNT(*) FROM consultations";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getAllConsultations()
    {
        $sql = "SELECT * FROM consultations";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            return [
                'consultation_id' => $row['consultation_id'],
                'consultation' => new consultation(
                    $row['patient_id'],
                    $row['medecin_id'],
                    $row['date_consultation'],
                    $row['motif'],
                    $row['diagnostique'],
                    $row['traitement'],
                    $row['note']
                )
            ];
        }
    }
}