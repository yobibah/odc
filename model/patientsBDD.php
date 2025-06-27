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
        // 1. Insertion dans la table users
        $sqlUser = "INSERT INTO users (nom, prenom, telephone, password, date_creation, role) VALUES (:nom, :prenom, :telephone, :password, NOW(), :role)";
        $stmtUser = $this->pdo->prepare($sqlUser);
        $stmtUser->bindValue(':nom', $patient->getNom());
        $stmtUser->bindValue(':prenom', $patient->getPrenom());
        $stmtUser->bindValue(':telephone', $patient->getTelephone());
        $stmtUser->bindValue(':password', $patient->getPassword());
        $stmtUser->bindValue(':role', $patient->getRole());
        $resultUser = $stmtUser->execute();
        if (!$resultUser) {
            return false;
        }

        $userId = $this->pdo->lastInsertId();

        // 2. Insertion dans la table patients
        $sqlPatient = "INSERT INTO patients (user_id, date_naissance, sexe, adresse, groupe_sanguine) VALUES (:user_id, :date_naissance, :sexe, :adresse, :groupe_sanguine)";
        $stmtPatient = $this->pdo->prepare($sqlPatient);
        $stmtPatient->bindValue(':user_id', $userId);
        $stmtPatient->bindValue(':date_naissance', $patient->getDateNaissance());
        $stmtPatient->bindValue(':sexe', $patient->getSexe());
        $stmtPatient->bindValue(':adresse', $patient->getAdresse());
        $stmtPatient->bindValue(':groupe_sanguine', $patient->getGroupeSanguine());
        $resultPatient = $stmtPatient->execute();

        return $resultPatient;
    }
    
    public function login($telephone, $password){
        $sql = "SELECT * FROM users WHERE telephone = :telephone AND password = :password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            if (password_verify($password, $data['password'])) {
                return [
                    'user_id' => $data['users_id'],
                    'user' => new users(
                        $data['nom'],
                        $data['prenom'],
                        $data['telephone'],
                        $data['password'],
                        $data['date_creation'],
                        $data['role'],
                        $data['auth_token']
                    )
                ];
            }
        }
        return null;
    }
    public function getPatientbyid($id)
    {
        $sql = "SELECT * FROM patients INNER JOIN users ON patients.user_id = users.id WHERE users.id = :id";
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
                    $data['telephone'],
                    $data['password'],
                    $data['date_creation'],
                    $data['role'],
                    $data['date_naissance'],
                    $data['sexe'],
                    $data['groupe_sanguine'],
                    $data['adresse']
                )
            ];
        }
        return null;
    }
    public function getAllPatients()
    {
        $sql = "SELECT * FROM patients INNER JOIN users ON patients.user_id = users.id";
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
                    $row['telephone'],
                    $row['password'],
                    $row['date_creation'],
                    $row['role'],
                    $row['date_naissance'],
                    $row['groupe_sanguine'],
                    $row['sexe'],
                    $row['adresse'],
                )
            ];
        }
        return $patients;
    }
    public function updatePatient($id, $patient)
    {
        // Mise à jour de la table users
        $sqlUser = "UPDATE users SET nom = :nom, prenom = :prenom, telephone = :telephone WHERE user_id = :id";
        $stmtUser = $this->pdo->prepare($sqlUser);
        $stmtUser->bindValue(':nom', $patient->getNom());
        $stmtUser->bindValue(':prenom', $patient->getPrenom());
        $stmtUser->bindValue(':telephone', $patient->getTelephone());
        $stmtUser->bindValue(':id', $id);
        $resultUser = $stmtUser->execute();

        // Mise à jour de la table patients
        $sqlPatient = "UPDATE patients SET date_naissance = :date_naissance, sexe = :sexe, adresse = :adresse, groupe_sanguine = :groupe_sanguine WHERE user_id = :id";
        $stmtPatient = $this->pdo->prepare($sqlPatient);
        $stmtPatient->bindValue(':date_naissance', $patient->getDateNaissance());
        $stmtPatient->bindValue(':sexe', $patient->getSexe());
        $stmtPatient->bindValue(':adresse', $patient->getAdresse());
        $stmtPatient->bindValue(':groupe_sanguine', $patient->getGroupeSanguine());
        $stmtPatient->bindValue(':id', $id);
        $resultPatient = $stmtPatient->execute();

        return $resultUser && $resultPatient;
    }
    public function getPatientByTelephone($telephone)
    {
        $sql = "SELECT * FROM patients INNER JOIN users ON patients.user_id = users.id WHERE telephone = :telephone";
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
                    $data['telephone'],
                    $data['password'],
                    $data['date_creation'],
                    $data['role'],
                    $data['date_naissance'],
                    $data['sexe'],
                    $data['groupe_sanguine'],
                    $data['adresse'],
                )
            ];
        }
        return null;
    }
    // Récupérer un patient par nom, prénom et date de naissance
    public function getPatient($nom, $prenom, $date_naissance)
    {
        $sql = "SELECT * FROM patients INNER JOIN users ON patients.user_id = users.id WHERE nom = :nom AND prenom = :prenom AND date_naissance = :date_naissance";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':date_naissance', $date_naissance);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return [
                'patients_id' => $data['users_id'],
                'patients' => new patients(
                    $data['nom'],
                    $data['prenom'],
                    $data['telephone'],
                    $data['password'],
                    $data['date_creation'],
                    $data['role'],
                    $data['date_naissance'],
                    $data['sexe'],
                    $data['groupe_sanguine'],
                    $data['adresse'],
                )
            ];
        }
        return null;
    }
}
