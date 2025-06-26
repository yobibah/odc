<?php
namespace controllers;

use model\MedicammentBDD;
use model\Medicament;

class HomeControllers extends Controllers {

    // Page d'accueil 
    public function index() {
        $this->render('home',
        [
            'title' => 'Home',
            'content' => 'Bienvenue sur notre API'
        ]);
    }
    // Liste des pays africains avec indicatif
}
