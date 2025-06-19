<?php 
//cette partie s'occuppe des donnes des consultations

namespace model;
use model\consultation;
use config\Config;
class ConsultationBDD extends consultation{
    private $pdo;
    public function __construct() {
        $this->pdo= Config::getpdo()->getconnexion();
    }
    public function getConsultation($id){
        $req=$this->pdo->prepare('SELECT * FROM consultation WHERE id_consultation=?');
        $req->execute(array($id));
        $data = $req->fetchAll();
        foreach($data as $row){
             return   [
                     'consulation'=> new consultation($row['id_client'],$row['date'],$row['heure'], $row['nom_medecin'], $row['nom_hopital'])   
        ];
    }
        }
       
    
    public function addConsultation(Consultation $consultation){
        $req=$this->pdo->prepare('INSERT INTO consultation (id_client,date_consultation,heure,nom_medecin,nom_hopital) VALUES (?,?,?,?,?)');

        $req->execute(array($consultation->getId_client(),$consultation->getDate(),$consultation->getHeure(), $consultation->getNom_medecin(),$consultation ->getHoiptal()));
        return $this->pdo->lastInsertId();
    }


   
}