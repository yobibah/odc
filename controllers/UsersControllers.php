<?php
namespace controllers;

use model\users;
use UsersBDD;

class UsersControllers {

    public function inscription() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['username'], $input['mdp'], $input['telephone'], $input['numero_personne_rev'])) {
            return $this->sendJson(['error' => 'Champs requis manquants'], 400);
        }
        $auth=null;
        $user = new users(
            $input['username'],
            $input['mdp'],
            $input['telephone'],
            $input['numero_personne_rev'],
            $auth
        );

        $bdd = new UsersBDD();
        $success = $bdd->inscription($user);

        if ($success) {
            return $this->sendJson(['status' => 'inscription réussie'], 201);
        } else {
            return $this->sendJson(['error' => 'Échec de l\'inscription'], 500);
        }
    }

    public function login() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['telephone'], $input['mdp'])) {
            return $this->sendJson(['error' => 'Téléphone et mot de passe requis'], 400);
        }

        $bdd = new UsersBDD();
        $result = $bdd->login($input['telephone'], $input['mdp']);

        if ($result) {
            $user = $result['users'];
            return $this->sendJson([
                'status' => 'success',
                'id_users' => $result['id_users'],
                'username' => $user->getUsername(),
                'telephone' => $user->getTelephone(),
                'numero_personne_rev' => $user->numero_peronne_rev(),
                'token' => $user->get_Token()
            ]);
        } else {
            return $this->sendJson(['error' => 'Identifiants invalides'], 401);
        }
    }

    public function autoLogin() {
        $bdd = new UsersBDD();
        $result = $bdd->autoLogin();

        if ($result) {
            $user = $result['users'];
            return $this->sendJson([
                'status' => 'connected',
                'id_users' => $result['id_users'],
                'username' => $user->getUsername(),
                'telephone' => $user->getTelephone(),
                'numero_personne_rev' => $user->numero_peronne_rev(),
                'token' => $user->get_Token()
            ]);
        } else {
            return $this->sendJson(['status' => 'not_connected']);
        }
    }

    public function monProfil() {
        if (!isset($_GET['id'])) {
            return $this->sendJson(['error' => 'ID utilisateur manquant'], 400);
        }

        $bdd = new UsersBDD();
        $result = $bdd->mon_profil_utilisateur((int)$_GET['id']);

        if ($result) {
            $user = $result['users'];
            return $this->sendJson([
                'status' => 'ok',
                'id_users' => $result['id_users'],
                'username' => $user->getUsername(),
                'telephone' => $user->getTelephone(),
                'numero_personne_rev' => $user->numero_peronne_rev(),
                'token' => $user->get_Token()
            ]);
        } else {
            return $this->sendJson(['error' => 'Utilisateur non trouvé'], 404);
        }
    }

    // Méthode utilitaire JSON
    private function sendJson($data, $status = 200) {
        http_response_code($status);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }
}
