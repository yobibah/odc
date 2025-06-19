<?php
namespace controllers;

use model\ConsultationBDD;
use model\consultation;

class ConsultationsControllers extends Controllers {

    // ➕ Ajouter une consultation
    public function ajouter() {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['id_client'], $input['date'], $input['heure'], $input['nom_medecin'], $input['nom_hopital'])) {
            return $this->sendJson(['error' => 'Champs manquants'], 400);
        }

        $consultation = new consultation(
            $input['id_client'],
            $input['date'],
            $input['heure'],
            $input['nom_medecin'],
            $input['nom_hopital']
        );

        $bdd = new ConsultationBDD();
        $id = $bdd->addConsultation($consultation);

        return $this->sendJson([
            'status' => 'Consultation enregistrée',
            'id_consultation' => $id
        ]);
    }

    // 📋 Consulter une consultation par son ID
    public function consulter() {
        if (!isset($_GET['id'])) {
            return $this->sendJson(['error' => 'ID requis'], 400);
        }

        $bdd = new ConsultationBDD();
        $result = $bdd->getConsultation((int)$_GET['id']);

        if ($result) {
            $consultation = $result['consulation'];
            return $this->sendJson([
                'id_client' => $consultation->getId_client(),
                'date' => $consultation->getDate(),
                'heure' => $consultation->getHeure(),
                'nom_medecin' => $consultation->getNom_medecin(),
                'nom_hopital' => $consultation->getHoiptal() // respect de ton modèle
            ]);
        } else {
            return $this->sendJson(['error' => 'Consultation non trouvée'], 404);
        }
    }

    // ❌ Supprimer une consultation
    

    // Méthode utilitaire JSON
    private function sendJson($data, $status = 200) {
        http_response_code($status);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }
}
