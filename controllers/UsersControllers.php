<?php
namespace controllers;

use model\users;
use model\UsersBDD;

class UsersControllers {

    public function inscription() {
         header("Access-Control-Allow-Origin: POST");
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['username'], $input['mdp'], $input['telephone'], $input['num_pav'])) {
            return $this->sendJson(['error' => 'Champs requis manquants'], 400);
        }
        $auth=null;
        $user = new users(
            $input['username'],
            $input['mdp'],
            $input['telephone'],
            $input['num_pav'],
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
    header("Access-Control-Allow-Origin: POST");
    $input = json_decode(file_get_contents('php://input'), true);
    $bdd = new UsersBDD();

    // 🔁 Connexion par token si fourni
    if (isset($input['token'])) {
        $result = $bdd->getUserByToken($input['token']); // méthode à créer dans UsersBDD
        if ($result) {
            $user = $result['users'];
            return $this->sendJson([
                'status' => 'success',
                'users_id' => $result['users_id'],
                'username' => $user->getUsername(),
                'telephone' => $user->getTelephone(),
                'numero_personne_rev' => $user->numero_peronne_rev(),
                'token' => $user->get_Token()
            ]);
        } else {
            return $this->sendJson(['error' => 'Token invalide'], 401);
        }
    }

    // 🔐 Connexion classique
    if (!isset($input['telephone'], $input['mdp'])) {
        return $this->sendJson(['error' => 'Téléphone et mot de passe requis'], 400);
    }

    $result = $bdd->login($input['telephone'], $input['mdp']);

    if ($result) {
        $user = $result['users'];

        // ✅ Générer un nouveau token
        $token = bin2hex(random_bytes(32));
     
        $bdd->updateToken($result['users_id'], $token); // méthode à créer

        return $this->sendJson([
            'status' => 'success',
            'users_id' => $result['users_id'],
            'username' => $user->getUsername(),
            'telephone' => $user->getTelephone(),
            'numero_personne_rev' => $user->numero_peronne_rev(),
            'auth_token' => $token
        ]);
    } else {
        return $this->sendJson(['error' => 'Identifiants invalides'], 401);
    }
}


    public function autoLogin() {
        header("Access-Control-Allow-Origin: GET");
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
        header("Access-Control-Allow-Origin: GET");
        /*
        if (!isset($_GET['id'])) {
            return $this->sendJson(['error' => 'ID utilisateur manquant'], 400);
        }
            */
        $id= 1;

        $bdd = new UsersBDD();
        $result = $bdd->mon_profil_utilisateur($id);

        if ($result) {
            $user = $result['users'];
            return $this->sendJson([
                'status' => 'ok',
                'id_users' => $result['users_id'],
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