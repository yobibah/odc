<?php
// Point d'entrée principal (front controller)
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App.php';

use src\App;
use routes\Router;
use controllers\HomeControllers;
use controllers\MedocControllers;
use controllers\RdvControllers;
use controllers\IpnControllers;
use controllers\UsersControllers;
use controllers\CliniqueControllers;

App::init();
// Gestion du chemin des assets pour test local (sans -t public) ou production
if (php_sapi_name() === 'cli-server' && basename(__DIR__) !== 'public') {
    // Mode test local sans -t public
    define('ASSET_PATH', '/public/assets/');
} else {
    // Production ou test avec -t public
    define('ASSET_PATH', '/assets/');
}
// Pour la production, on utilise un chemin absolu sécurisé pour les vues
define('VIEW_PATH', realpath(__DIR__ . '/../views/') . DIRECTORY_SEPARATOR);

$router = new Router();
// point d'entrée pour les routes
$router->register('/', ['controllers\UsersControllers', 'login']);
$router->register('/mes-medicaments', ['controllers\MedocControllers', 'mes_medicaments']);
$router->register('/supprimer-medicament', ['controllers\MedocControllers', 'supprimer']);
$router->register('/ajouter-medicament', ['controllers\MedocControllers', 'ajouter']);


$router->register('/les-cliniques', ['controllers\CliniqueControllers', 'show']);
$router->register('/clinique-localisation', ['controllers\CliniqueControllers', 'get_by_location']);
$router->register('/clinique-adresse', ['controllers\CliniqueControllers', 'get_by_quartier_ville']);
$router->register('/les-', ['controllers\CliniqueControllers', 'ajouter']);



$router->register('/ipn/paiement', ['controllers\IpnControllers', 'test']);



$router->register('/register', ['controllers\UsersControllers', 'inscription']);
$router->register('/mon-profil', ['controllers\UsersControllers', 'monProfil']);
$router->register('/login', ['controllers\UsersControllers', 'login']);
$router->register('/logout', ['controllers\UsersControllers', 'logout']);
$router->register('/mes-rendez-vous', ['controllers\RdvControllers', 'mesRdv']);
$router->register('/mes-supprimer-ce-rdv', ['controllers\RdvControllers', 'supprimerRdv']);

$router->register('/modifier-supprimer-ce-rdv', ['controllers\RdvControllers', 'modifierRdv']);



try {
    $router->resolve($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    echo $e->getMessage();
}
