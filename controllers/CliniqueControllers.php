<?php
namespace controllers;

use model\Clinique;
use model\CliniqueBDD;

class CliniqueControllers extends Controllers
{
    public function ajouter()
    {
        header("Access-Control-Allow-Origin: POST");
        $input = json_decode(file_get_contents('php://input'), true);

        // Vérification des champs obligatoires
        $required = ['nom', 'numero', 'longitude', 'latitude', 'ville', 'quartier', 'rue', 'id_service'];
        foreach ($required as $field) {
            if (!isset($input[$field])) {
                return $this->sendJson(['error' => "Champ manquant: $field"], 400);
            }
        }

        $clinique = new Clinique(
            $input['nom'],
            $input['numero'],
            $input['longitude'],
            $input['latitude'],
            $input['ville'],
            $input['quartier'],
            $input['rue'],
            (int)$input['id_service']
        );

        $bdd = new CliniqueBDD();
        $bdd->ajouter_clinique($clinique);

        return $this->sendJson(['status' => 'Clinique ajoutée avec succès'], 201);
    }

    public function toutes()
    {
        header("Access-Control-Allow-Origin: GET");
        $bdd = new CliniqueBDD();
        $result = $bdd->get_cliniques();

        $data = array_map(function($item) {
            /** @var Clinique $c */
            $c = $item['clinique'];
            return [
                'id_clinique' => $item['id_clinique'],
                'nom'         => $c->getNomC(),
                'numero'      => $c->getNumeroC(),
                'longitude'   => $c->getLongituteC(),
                'latitude'    => $c->getLatitudeC(),
                'ville'       => $c->getVilleC(),
                'quartier'    => $c->getQuartierC(),
                'rue'         => $c->getRueC(),
                'id_service'  => $c->getIDserviceC(),
            ];
        }, $result);

        return $this->sendJson($data);
    }

    public function show()
    {
    

        $bdd = new CliniqueBDD();
        $results = $bdd->get_cliniques();
       
        $data = array_map(function($item) {
            $c = $item['clinique'];
            return [
                'id_clinique' => $item['id_clinique'],
                'nom'         => $c->getNomC(),
                'numero'      => $c->getNumeroC(),
                'longitude'   => $c->getLongituteC(),
                'latitude'    => $c->getLatitudeC(),
                'ville'       => $c->getVilleC(),
                'quartier'    => $c->getQuartierC(),
                'rue'         => $c->getRueC(),
                'id_service'  => $c->getIDserviceC(),
            ];
        }, $results);

        return $this->sendJson($data);
    }

    public function search()
    {
        header("Access-Control-Allow-Origin: GET");
        $quartier = $_GET['quartier'] ?? '';
        $ville    = $_GET['ville']    ?? '';
        if ($quartier === '' && $ville === '') {
            return $this->sendJson(['error' => 'Quartier ou ville requis'], 400);
        }

        $bdd = new CliniqueBDD();
        $results = $bdd->get_clinique_par_quartier_ou_ville($quartier);

        $data = array_map(function($item) {
            $c = $item['clinique'];
            return [
                'id_clinique' => $item['id_clinique'],
                'nom'         => $c->getNomC(),
                'numero'      => $c->getNumeroC(),
                'longitude'   => $c->getLongituteC(),
                'latitude'    => $c->getLatitudeC(),
                'ville'       => $c->getVilleC(),
                'quartier'    => $c->getQuartierC(),
                'rue'         => $c->getRueC(),
                'id_service'  => $c->getIDserviceC(),
            ];
        }, $results);

        return $this->sendJson($data);
    }

    /*
    public function delete()
    {
        header("Access-Control-Allow-Origin: DELETE");
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['id_clinique'])) {
            return $this->sendJson(['error' => 'ID clinique manquant'], 400);
        }

        $bdd = new CliniqueBDD();
        $bdd->supprimer_clinique((int)$input['id_clinique']); // à créer dans CliniqueBDD
        return $this->sendJson(['status' => 'Clinique supprimée']);
    }
        */


    public function get_by_location()
     {
        $input = json_decode(file_get_contents('php://input'), true);
      
        $bdd = new CliniqueBDD();
        $logla=$bdd->get_clinique_longitude_latitude($input['longitude'], $input['latitude']); // à créer dans CliniqueBDD
        if ($logla){
            foreach ($logla as $item) {
                $c = $item['clinique'];
                $data[] = [
                    'id_clinique' => $item['id_clinique'],
                    'nom'         => $c->getNomC(),
                    'numero'      => $c->getNumeroC(),
                    'longitude'   => $c->getLongituteC(),
                    'latitude'    => $c->getLatitudeC(),
                    'ville'       => $c->getVilleC(),
                    'quartier'    => $c->getQuartierC(),
                    'rue'         => $c->getRueC(),
                    'id_service'  => $c->getIDserviceC(),
                ];
            }
            return $this->sendJson($data);
        } 
         
    }

    public function get_by_quartier_ville(){
        header("Access-Control-Allow-Origin: GET");
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['quartier'])) {
            return $this->sendJson(['error' => 'Quartier ou ville requis'], 400);
        }
        $bdd = new CliniqueBDD();
        $quartier = $input['quartier'] ?? '';
       
        $results = $bdd->get_clinique_par_quartier_ou_ville($quartier);
        if (!$results) {
            return $this->sendJson(['error' => 'Aucune clinique trouvée'],
            404);
        }
        $data = array_map(function($item) {
            $c = $item['clinique'];
            return [    
                'id_clinique' => $item['id_clinique'],
                'nom'         => $c->getNomC(),
                'numero'      => $c->getNumeroC(),
                'longitude'   => $c->getLongituteC(),
                'latitude'    => $c->getLatitudeC(),
                'ville'       => $c->getVilleC(),
                'quartier'    => $c->getQuartierC(),
                'rue'         => $c->getRueC(),
                'id_service'  => $c->getIDserviceC(),
            ];
        }, $results)
        ;

        return $this->render('clinique', ['data' => $data]);
    }
}
