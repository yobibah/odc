<?php
namespace controllers;

use FasoDev\SDK\OM\OMClient;
use Rinvex\Country\CountryLoader;

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
    public function test() {
        $countries = countries(); // Charge tous les pays
        $data = [];

       echo '<pre>';
var_dump($countries[0]);
        


        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        return;
    }


}
