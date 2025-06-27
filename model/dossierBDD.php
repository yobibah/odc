<?php 
namespace model;
use model\Dossier;
use config\Config;

class DossierBDD extends Dossier
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Config::getPDO()->getconnexion();
      
    }

    // recuperer un dossier par son identifiant !!!!
    public function getDossierById($id_dossier)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dossier WHERE id_dossier = :id_dossier");
        $stmt->bindParam(':id_dossier', $id_dossier, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if ($data) {
            $dossier=[];
            foreach ($data as $row) {
                $dossier[] = [
                    'id_dossier' => $row['id_dossier'],
                    'dossier' => new Dossier(
                        $row['numero_dossier'],
                        $row['date_creation'],
                        $row['id_patient'],
                        $row['motif'],
                        $row['statut']
                    )
                ];
            }
            return $dossier;
        }
        return null;
    }
   

    //recuperer un dossier par id__patient
    public function getDossierByIdPatient($id_patient)
    {
        $stmt = $this->pdo->prepare("SELECT d:*,p.* 
        FROM dossier 
        INNER JOIN patients p ON d.id_patient = p.id_patient
        WHERE id_patient = :id_patient");
        $stmt->bindParam(':id_patient', $id_patient, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if ($data) {
            $dossier=[];
            foreach ($data as $row) {
                $dossier[] = [
                    'id_dossier' => $row['id_dossier'],
                    'dossier' => new Dossier(
                        $row['numero_dossier'],
                        $row['date_creation'],
                        $row['id_patient'],
                        $row['motif'],
                        $row['statut']
                    ),
                    'patient'=> new patients(
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
                     $data['adresse']

                    )
                ];
            }
            return $dossier;
        }
        return null;
    }

    
    public function getDossierBynumeroDossier($numero_dossier)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dossier WHERE numero_dossier = :numero_dossier");
        $stmt->bindParam(':numero_dossier', $numero_dossier, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if ($data) {
            $dossier=[];
            foreach ($data as $row) {
                $dossier[] = [
                    'id_dossier' => $row['id_dossier'],
                    'dossier' => new Dossier(
                        $row['numero_dossier'],
                        $row['date_creation'],
                        $row['id_patient'],
                        $row['motif'],
                        $row['statut']
                    )
                ];
            }
            return $dossier;
        }
        return null;
    }

    // ajouter un dossier
    public function addDossier(Dossier $dossier)
    {
        $stmt = $this->pdo->prepare("INSERT INTO dossier (numero_dossier, date_creation, id_patient, motif, statut) VALUES (:numero_dossier, :date_creation, :id_patient, :motif, :statut)");
   
        return $stmt->execute([
            'numero_dossier' => $dossier->getNumeroDossier(),
            'date_creation' => $dossier->getDateCreation(),
            'id_patient' => $dossier->getIdPatient(),
            'motif' => $dossier->getMotif(),
            'statut' => $dossier->getStatut()
        ]);        
       
    }

    // modifier un dossier
    public function updateDossier(Dossier $dossier)
    {
        $stmt = $this->pdo->prepare("UPDATE dossier SET numero_dossier = :numero_dossier, date_creation = :date_creation, id_patient = :id_patient, motif = :motif, statut = :statut WHERE id_dossier = :id_dossier");      
        return $stmt->execute([
            'numero_dossier' => $dossier->getNumeroDossier(),
            'date_creation' => $dossier->getDateCreation(),
            'id_patient' => $dossier->getIdPatient(),
            'motif' => $dossier->getMotif(),
            'statut' => $dossier->getStatut(),
            
        ]);
    }

    // verifier un dossier par un numero de patient 
    public function verifierDossierParNumeroPatient($telephone){
        $sql = "SELECT d.*,p.telephone, p.nom   
        FROM dossier d
        INNER JOIN patient p ON d.id_patient = p.id_patient
        WHERE p.telephone = :telephone
          ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':telephone', $telephone, \PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(mode: \PDO::FETCH_ASSOC);
        if(count($data) > 0){
            return $data;
        }
        return null;
    }


    public function getAlldossier()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dossier");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if ($data) {
            $dossiers = [];
            foreach ($data as $row) {
                $dossiers[] = [
                    'id_dossier' => $row['id_dossier'],
                    'dossier' => new Dossier(
                        $row['numero_dossier'],
                        $row['date_creation'],
                        $row['id_patient'],
                        $row['motif'],
                        $row['statut']
                    )
                ];
            }
            return $dossiers;
        }
        return null;
    }
    // version limite a cette partie pour l'instant
}
