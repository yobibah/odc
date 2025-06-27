<?php
namespace model;

use model\ordonnance;
use config\Config;
use PDO;

class ordonnanceBDD extends ordonnance{
    private $pdo;
    public function __construct(){
        $this->pdo = Config::getPDO()->getConnexion();
    }
    public function addOrdonnance(ordonnance $ordonnance){
        $sql = "INSERT INTO ordonnance (consultation_id, contenu, date_emission) VALUES (:consultation_id, :contenu, :date_emission)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':consultation_id', $ordonnance->getConsultationId());
        $stmt->bindValue(':contenu', $ordonnance->getContenu());
        $stmt->bindValue(':date_emission', $ordonnance->getDateEmission());
        
        return $stmt->execute();
    }
    public function getOrdonnanceByConsultationId($consultationId){
        $sql = "SELECT * FROM ordonnance WHERE consultation_id = :consultation_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':consultation_id', $consultationId);
        $stmt->execute();
        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $ordonnance) {
            return [
                'ordonnance_id' => $ordonnance['ordonnance_id'],
                'ordonnance' => new ordonnance(
                    $ordonnance['consultation_id'],
                    $ordonnance['contenu'],
                    $ordonnance['date_emission']
                )
            ];
        }
    }
    public function getAllOrdonnances(){
        $sql = "SELECT * FROM ordonnance";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ordonnance) {
            return [
                'ordonnance_id' => $ordonnance['ordonnance_id'],
                'ordonnance' => new ordonnance(
                    $ordonnance['consultation_id'],
                    $ordonnance['contenu'],
                    $ordonnance['date_emission']
                )
            ];
        }
    }
    public function deleteOrdonnance($id){
        $sql = "DELETE FROM ordonnance WHERE ordonnance_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
    public function updateOrdonnance(ordonnance $ordonnance){
        $sql = "UPDATE ordonnance SET contenu = :contenu, date_emission = :date_emission WHERE ordonnance_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':contenu', $ordonnance->getContenu());
        $stmt->bindValue(':date_emission', $ordonnance->getDateEmission());
        return $stmt->execute();
    }
    public function getOrdonnanceByPatientId($patientId){
        $sql = "SELECT * FROM ordonnance INNER JOIN consultation ON ordonnance.consultation_id = consultation.consultation_id WHERE consultation.patient_id = :patient_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $patientId);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ordonnance) {
            return [
                'ordonnance_id' => $ordonnance['ordonnance_id'],
                'ordonnance' => new ordonnance(
                    $ordonnance['consultation_id'],
                    $ordonnance['contenu'],
                    $ordonnance['date_emission']
                )
            ];
        }
    }
    public function getOrdonnanceByDate($date){
        $sql = "SELECT * FROM ordonnance WHERE date_emission = :date_emission";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':date_emission', $date);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ordonnance) {
            return [
                'ordonnance_id' => $ordonnance['ordonnance_id'],
                'ordonnance' => new ordonnance(
                    $ordonnance['consultation_id'],
                    $ordonnance['contenu'],
                    $ordonnance['date_emission']
                )
            ];
        }
    }
    public function countAllOrdonnances(){
        $sql = "SELECT COUNT(*) FROM ordonnance";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function countOrdonnancesByPatientId($patientId){
        $sql = "SELECT COUNT(*) FROM ordonnance INNER JOIN consultation ON ordonnance.consultation_id = consultation.consultation_id WHERE consultation.patient_id = :patient_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $patientId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function countOrdonnancesByDate($date){
        $sql = "SELECT COUNT(*) FROM ordonnance WHERE date_emission = :date_emission";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':date_emission', $date);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function countOrdonnancesByConsultationId($consultationId){
        $sql = "SELECT COUNT(*) FROM ordonnance WHERE consultation_id = :consultation_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':consultation_id', $consultationId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}