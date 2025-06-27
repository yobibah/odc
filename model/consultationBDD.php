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
        $sql = "INSERT INTO consultation (patient_id, medecin_id, date_consultation, motif, diagnostique, traitement, note) 
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
    public function getConsultationByPatientId($patientId)
    {
        $sql = "SELECT * FROM consultation WHERE patient_id = :patient_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $patientId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getConsultationById($id)
    {
        $sql = "SELECT * FROM consultation WHERE consultation_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateConsultation(consultation $consultation)
    {
        $sql = "UPDATE consultation SET patient_id = :patient_id, medecin_id = :medecin_id, date_consultation = :date_consultation, motif = :motif, diagnostique = :diagnostique, traitement = :traitement, note = :note WHERE consultation_id = :id";
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
        $sql = "DELETE FROM consultation WHERE consultation_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
    public function countConsultationByPatientId($patientId)
    {
        $sql = "SELECT COUNT(*) FROM consultation WHERE patient_id = :patient_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $patientId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function countConsultation()
    {
        $sql = "SELECT COUNT(*) FROM consultation";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getAllConsultation()
    {
        $sql = "SELECT * FROM consultation";
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
    public function getConsultationByMedecinId($medecinId){
        $sql = "SELECT * FROM consultation WHERE medecin_id = :medecin_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':medecin_id', $medecinId);
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
    public function getConsultationByDate($date)
    {
        $sql = "SELECT * FROM consultation WHERE date_consultation = :date_consultation";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':date_consultation', $date);
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
    public function countConsultationByDate($date)
    {
        $sql = "SELECT COUNT(*) FROM consultation WHERE date_consultation = :date_consultation";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':date_consultation', $date);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function countConsultationByMedecinId($medecinId)
    {
        $sql = "SELECT COUNT(*) FROM consultation WHERE medecin_id = :medecin_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':medecin_id', $medecinId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}