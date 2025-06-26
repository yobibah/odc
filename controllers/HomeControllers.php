<?php
namespace controllers;

use model\MedicammentBDD;
use model\Medicament;

class HomeControllers extends Controllers {

    // Page d'accueil JSON
    public function index() {
        $data = [
            'title' => 'Home',
            'content' => 'Bienvenue sur notre API'
        ];
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        return;
    }
    // Liste des pays africains avec indicatif
}
