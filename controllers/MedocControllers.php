<?php
namespace controllers;


use model\Medicament;
use model\MedicammentBDD;

class MedocControllers extends Controllers{


         public function ajouter() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id_client'], $input['libelle'], $input['heur_prise'])) {
            return $this->sendJson(['error' => 'Champs manquants'], 400);
        }

        $medicament = new Medicament(
            $input['id_client'],
            $input['libelle'],
            $input['heur_prise']
        );

        $bdd = new MedicammentBDD();
        $bdd->ajouter_medicament($medicament);

        return $this->sendJson(['status' => 'Médicament ajouté avec succès']);
    }

public function mes_medicaments() {
    // Pour test, id_client en dur
    $id_client = 1;

    $bdd = new MedicammentBDD();
    $result = $bdd->mes_medicaments($id_client);

    if ($result && count($result) > 0) {
        $data = [];

        foreach ($result as $rs) {
            $data[] = [
                'id_medicament' => $rs['id_medicament'],
                'libelle' => $rs['medicament']->getLibelle(),
                'heure_prise' => $rs['medicament']->getHeureprise()
            ];
        }

        return $this->sendJson($data);
    } else {
        return $this->sendJson(['message' => 'Aucun médicament trouvé'], 204);
    }
}


    public function supprimer() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['id_medicament'])) {
            return $this->sendJson(['error' => 'ID médicament manquant'], 400);
        }

        $bdd = new MedicammentBDD();
        $bdd->supprimer_medicament((int)$input['id_medicament']);

        return $this->sendJson(['status' => 'Médicament supprimé']);
    }

 
    private function sendJson($data, $status = 200) {
        http_response_code($status);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }
}
