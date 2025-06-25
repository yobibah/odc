<?php 
namespace model;
use PDO;
use model\Clinique;
use config\Config;

class CliniqueBDD extends Clinique{

    private $pdo; 
    public function __construct(){
        $this->pdo = Config::getpdo()->getconnexion();
    }

    public function ajouter_clinique(Clinique $clinique){
        $stm = $this->pdo->prepare("INSERT INTO clinique (nom, numero, longitute, latitude, ville, quartier, rue, id_service) VALUES (:nom, :numero, :longitute, :latitude, :ville, :quartier, :rue, :id_service)");
        $stm->bindValue(":nom", $clinique->getNomC());
        $stm->bindValue(":numero", $clinique->getNumeroC());
        $stm->bindValue(":longitute", $clinique->getLongituteC());
        $stm->bindValue(":latitude", $clinique->getLatitudeC());
        $stm->bindValue(":ville", $clinique->getVilleC());
        $stm->bindValue(":quartier", $clinique->getQuartierC());
        $stm->bindValue(":rue", $clinique->getrueC());
        $stm->bindValue(":id_service", $clinique->getIDserviceC());
        $stm->execute();
    }
    public function get_cliniques(){
        $stm = $this->pdo->prepare("SELECT * FROM hospitale");
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($data as $rw) {
            $result[] = [
                'id_clinique' => $rw['id_clinique'],
                'clinique' => new Clinique(
                    $rw['nom'],
                    $rw['numero'],
                    $rw['longitute'],
                    $rw['latitude'],

                    $rw['ville'],
                    $rw['quartier'],
                    $rw['rue'],
                    $rw['id_service']
                )
            ];
        }
        return $result;
    }
    public function clinique_by_id($id){
        $stm = $this->pdo->prepare("SELECT * FROM clinique WHERE id_clinique = :id");
        $stm->bindValue(":id", $id);
        $stm->execute();
        $data = $stm->fetch(PDO::FETCH_ASSOC);  
        if ($data) {
            return new Clinique(
                $data['nom'],
                $data['numero'],
                $data['longitute'],
                $data['latitude'],
                $data['ville'],
                $data['quartier'],
                $data['rue'],   
                $data['id_service']
            );
        }
        return null;
    }

    public function get_clinique_par_quartier_ou_ville($lieux) {
        $stm = $this->pdo->prepare("SELECT * FROM hospitale WHERE quartier = :quartier OR ville = :quartier");
        $stm->bindValue(":quartier", $lieux);
        $stm->bindValue(":ville", $lieux);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($data as $rw) {
            $result[] = [
                'id_clinique' => $rw['id_clinique'],
                'clinique' => new Clinique(
                    $rw['nom'],
                    $rw['numero'],
                    $rw['longitute'],
                    $rw['latitude'],
                    $rw['ville'],
                    $rw['quartier'],
                    $rw['rue'],
                    $rw['id_service']
                )
            ];
        }
        return $result;
    }
    public function get_clinique_longitude_latitude($longitute, $latitude) {
        $stm = $this->pdo->prepare("SELECT * FROM hospitale WHERE longitute = :longitute AND latitude = :latitude");
        $stm->bindValue(":longitute", $longitute);
        $stm->bindValue(":latitude", $latitude);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($data as $rw) {
            $result[] = [
                'id_clinique' => $rw['id_clinique'],
                'clinique' => new Clinique(
                    $rw['nom'],
                    $rw['numero'],
                    $rw['longitute'],
                    $rw['latitude'],
                    $rw['ville'],
                    $rw['quartier'],
                    $rw['rue'],
                    $rw['id_service']
                )
            ];
        }   
        return $result;
    }
    
}
