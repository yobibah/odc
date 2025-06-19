<?php 
namespace model;
use model\Rdv;
use config\Config;
class RdvBDD extends Rdv{
    private $pdo;
     public function __construct(){
        $this->pdo = Config::getPdo()->getconnexion();
    }

    public function getRdvByDate($date){
        $sql = "SELECT * FROM rdv WHERE date_rdv = :date_rdv";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':date_rdv', $date, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function add_rdv(Rdv $rdv){
        $sql = "INSERT INTO rdv (heur_rdv, hopitale_rdv,date_rdv,id_client) VALUES (:heur_rdv,:hopitale_rdv,:date_rdv,:id_client)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':date_rdv', $rdv->getDate(), \PDO::PARAM_STR);
        $stmt->bindValue(':hopitale_rdv', $rdv->getHopitale_rdv(), \PDO::PARAM_STR);
        $stmt->bindValue(':heur_rdv',$rdv->getHeure(),\PDO::PARAM_STR);
        $stmt->bindValue(':id_client', $rdv->getId_client(), \PDO::PARAM_INT);
         return  $stmt->execute();
       
    }

    public function mes_rdv($id){
        $sql = "SELECT * FROM rdv WHERE id_client=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function supprimer_rdv($id){
        $sql = "DELETE FROM rdv WHERE id_client  =:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function modifier_rdv(Rdv $rdv,$id_rdv,$id_client){
        $sql = "UPDATE rdv SET heur_rdv =:heur_rdv, hopitale_rdv =:hopitale_rdv, date_rdv =:date_rdv WHERE users_id =:id_client AND id_rdv= :id_rdv";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_client', $rdv->getId_client(), \PDO::PARAM_INT);
         $stmt->bindValue(':date_rdv', $rdv->getDate(), \PDO::PARAM_STR);
        $stmt->bindValue(':hopitale_rdv', $rdv->getHopitale_rdv(), \PDO::PARAM_STR);
        $stmt->bindValue(':heur_rdv',$rdv->getHeure(),\PDO::PARAM_STR);
        $stmt->bindValue(':id_client', $id_client, \PDO::PARAM_INT);
         $stmt->bindValue(':id_rdv', $id_rdv, \PDO::PARAM_INT);
         return  $stmt->execute();
}

     



    public function getRdvsDuJour7h() {
        $today = date('Y-m-d');
        $targetHour = '07:00';

        $sql = "
            SELECT u.username, u.email, r.date_consultion, r.heure_consultation, r.libelle_consultation, r.hopitale_consultation 
            FROM rdv r 
            JOIN users u ON r.id_client = u.id_users
            WHERE r.date_consultion = :date AND r.heure_consultation = :heure
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':date' => $today,
            ':heure' => $targetHour
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}


