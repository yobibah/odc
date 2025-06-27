<?php
namespace model;

use model\document;
use config\Config;
use PDO;

class documentBDD extends document {
    private $pdo;

    public function __construct() {
        $this->pdo = Config::getPDO()->getConnexion();
    }

    public function addDocument(document $document) {
        $sql = "INSERT INTO document (patient_id, titre, fichier, type_document, date_ajout) 
                VALUES (:patient_id, :titre, :fichier, :type_document, :date_ajout)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $document->getPatientId());
        $stmt->bindValue(':titre', $document->getTitre());
        $stmt->bindValue(':fichier', $document->getFichier());
        $stmt->bindValue(':type_document', $document->getTypeDocument());
        $stmt->bindValue(':date_ajout', $document->getDateAjout());

        return $stmt->execute();
    }

    public function getDocumentByPatientId($patientId) {
        $sql = "SELECT * FROM document WHERE patient_id = :patient_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':patient_id', $patientId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteDocument($id) {
        $sql = "DELETE FROM document WHERE document_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}