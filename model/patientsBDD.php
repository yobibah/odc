<?php
namespace model;

use model\patients;

class PatientsBDD
{
    private $pdo;
    
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Inscription d'un patient
    public function inscription(patients $patient)
    {
        $sql = "INSERT INTO patients (nom, prenom, date_naissance, sexe, adresse, telephone, num_pav) 
                VALUES (:nom, :prenom, :date_naissance, :sexe, :adresse, :telephone, :num_pav)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom', $patient->getNom());
        $stmt->bindValue(':prenom', $patient->getPrenom());
        $stmt->bindValue(':date_naissance', $patient->getDateNaissance());
        $stmt->bindValue(':sexe', $patient->getSexe());
        $stmt->bindValue(':adresse', $patient->getAdresse());
        $stmt->bindValue(':telephone', $patient->getTelephone());
        $stmt->bindValue(':num_pav', $patient->numero_peronne_rev());

        return $stmt->execute();
    }
    public function getPatientbyid($id)
    {
        $sql = "SELECT * FROM patients WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return [
                'patients_id' => $data['id'],
                'patients' => new patients(
                    $data['nom'],
                    $data['prenom'],
                    $data['date_naissance'],
                    $data['sexe'],
                    $data['adresse'],
                    $data['telephone'],
                    $data['num_pav']
                )
            ];
        }
        return null;
    }
    public function getAllPatients()
    {
        $sql = "SELECT * FROM patients";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $patients = [];
        foreach ($data as $row) {
            $patients[] = [
                'patients_id' => $row['id'],
                'patients' => new patients(
                    $row['nom'],
                    $row['prenom'],
                    $row['date_naissance'],
                    $row['sexe'],
                    $row['adresse'],
                    $row['telephone'],
                    $row['num_pav']
                )
            ];
        }
        return $patients;
    }
    public function updatePatient($id, $patient)
    {
        $sql = "UPDATE patients SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, sexe = :sexe, adresse = :adresse, telephone = :telephone, num_pav = :num_pav WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom', $patient->getNom());
        $stmt->bindValue(':prenom', $patient->getPrenom());
        $stmt->bindValue(':date_naissance', $patient->getDateNaissance());
        $stmt->bindValue(':sexe', $patient->getSexe());
        $stmt->bindValue(':adresse', $patient->getAdresse());
        $stmt->bindValue(':telephone', $patient->getTelephone());
        $stmt->bindValue(':num_pav', $patient->numero_peronne_rev());
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
    public function deletePatient($id)
    {
        $sql = "DELETE FROM patients WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
    public function getPatientByTelephone($telephone)
    {
        $sql = "SELECT * FROM patients WHERE telephone = :telephone";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return [
                'patients_id' => $data['id'],
                'patients' => new patients(
                    $data['nom'],
                    $data['prenom'],
                    $data['date_naissance'],
                    $data['sexe'],
                    $data['adresse'],
                    $data['telephone'],
                    $data['num_pav']
                )
            ];
        }
        return null;
    }
    public function getPatientByNumPav($numPav)
    {
        $sql = "SELECT * FROM patients WHERE num_pav = :num_pav";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':num_pav', $numPav);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return [
                'patients_id' => $data['id'],
                'patients' => new patients(
                    $data['nom'],
                    $data['prenom'],
                    $data['date_naissance'],
                    $data['sexe'],
                    $data['adresse'],
                    $data['telephone'],
                    $data['num_pav']
                )
            ];
        }
        return null;
    }
    public function getPatient($nom, $prenom, $date_naissance)
    {
        $sql = "SELECT * FROM patients WHERE nom = :nom AND prenom = :prenom AND date_naissance = :date_naissance";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':date_naissance', $date_naissance);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return [
                'patients_id' => $data['id'],
                'patients' => new patients(
                    $data['nom'],
                    $data['prenom'],
                    $data['date_naissance'],
                    $data['sexe'],
                    $data['adresse'],
                    $data['telephone'],
                    $data['num_pav']
                )
            ];
        }
        return null;
    }

}