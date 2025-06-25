<?php 
//ici ces pour add des medicaments
namespace model;
use config\Config;
use model\Medicament;

class MedicammentBDD extends Medicament{
    private $pdo;

    public function __construct(){
        $this->pdo= Config::getpdo()->getconnexion();
    }

    public function ajouter_medicament(Medicament $medicament){
        $stm = $this->pdo->prepare("INSERT INTO medicament (users_id,libelle,heur_prise) VALUES (:users_id, :libelle, :heur_prise)");
        $stm->bindValue(":users_id", $medicament->getId_client());
        $stm->bindValue(":libelle", $medicament->getLibelle());
        $stm->bindValue(":heur_prise", $medicament->getHeureprise());
        $stm->execute();
    }

public function mes_medicaments($id_client) {
    $stm = $this->pdo->prepare("SELECT * FROM medicament WHERE users_id = :id_client");
    $stm->bindValue(":id_client", $id_client);
    $stm->execute();
    $data = $stm->fetchAll();

    $result = [];

    foreach ($data as $rw) {
        $result[] = [
            'id_medicament' => $rw['id_medoc'],
            'medicament' => new Medicament($rw['users_id'], $rw['libelle'], $rw['heur_prise'])
        ];
    }

    return $result;
}


    public function supprimer_medicament($id_medicament){
        $stm = $this->pdo->prepare("DELETE FROM medicament WHERE id_medoc = :id_medicament");
        $stm->bindValue(":id_medicament", $id_medicament);
        $stm->execute();
    }


}