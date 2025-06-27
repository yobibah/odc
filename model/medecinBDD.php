<?php 
namespace model;
use config\Config;
use model\medecin;

class medecinBDD extends medecin{
    private $pdo;

    public function __construct(){
        $this->pdo = Config::getpdo()->getconnexion();
    }

    public function addMedecin(medecin $medecin){
        $stm = $this->pdo->prepare("INSERT INTO medecin (specialite, id_centre, nom, prenom, password, telephone) VALUES (:specialite, :id_centre, :nom, :prenom, :password, :telephone)");
        $stm->bindValue(":specialite", $medecin->getSpecialite());
        $stm->bindValue(":id_centre", $medecin->getId_centre());
        $stm->bindValue(":nom", $medecin->getNom());
        $stm->bindValue(":prenom", $medecin->getPrenom());
        $stm->bindValue(":password", password_hash($medecin->getPassword(), PASSWORD_DEFAULT));
        $stm->bindValue(":telephone", $medecin->getTelephone());
        return $stm->execute();
    }

    public function login_medecin($telephone, $password){
        $stm = $this->pdo->prepare("SELECT * FROM medecin WHERE telephone = :telephone");
        $stm->bindValue(":telephone", $telephone);
        $stm->execute();
        $data = $stm->fetch();

        if ($data && password_verify($password, $data['password'])) {
            return new medecin($data['specialite'], $data['id_centre'], $data['nom'], $data['prenom'], $data['password'], $data['telephone']);
        }
        return null;
    }

    public function getMedecinById($id){
        $stm = $this->pdo->prepare("SELECT * FROM medecin WHERE id = :id");
        $stm->bindValue(":id", $id);
        $stm->execute();
        $data = $stm->fetch();

        if ($data) {
            return new medecin($data['specialite'], $data['id_centre'], $data['nom'], $data['prenom'], $data['password'], $data['telephone']);
        }
        return null;
    }
}