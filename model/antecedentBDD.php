<?php 
namespace model;
use model\Antecedent;
use config\Config;

class AntecedentBDD extends Antecedent{
    private $pdo;
    public function __construct(){
        $this->pdo= Config::getpdo()->getconnexion();
    }

    public function Ajouter_antecedent($id_dossier,$id_antecedents){
        $sql = "INSERT INTO dossier_antecedents (id_dossier,id_antecedents) VALUE(:id_dossier,:id_antecedents)";
        $smt = $this->pdo->prepare($sql);
       return $smt->execute([
            ':id_dossier'=>$id_dossier,
            'id_antecedents'=>$id_antecedents
        ]);
    }

    //optionnel pour la version de test .......
    public function supprimer_antecedents(){

    }
    public function getAntecedentsByIdDossier($id_dossier){
        $stmt = $this->pdo->prepare("SELECT * FROM dossier_antecedents WHERE id_dossier = :id_dossier");
        $stmt->bindParam(':id_dossier', $id_dossier, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if ($data) {
            $antecedents = [];
            foreach ($data as $row) {
                $antecedents[] = [
                    'id_antecedents' => $row['id_antecedents'],
                    'libelle' => (new Antecedent($row['libelle']))->getLibelle()
                ];
            }
            return $antecedents;
        }
        return null;
    }
}