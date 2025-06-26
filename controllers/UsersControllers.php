<?php

namespace controllers;

use model\users;
use model\UsersBDD;

class UsersControllers extends HomeControllers
{
    //inscription
    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $username = isset(htmlspecialchars($_POST['username'])) ? htmlspecialchars($_POST['username']) : null;
            $mdp = isset(htmlspecialchars($_POST['mdp'])) ? htmlspecialchars($_POST['mdp']) : null;
            $mdp2 = isset(htmlspecialchars($_POST['mdp2'])) ? htmlspecialchars($_POST['mdp2']) : null;
            $telephone = isset(htmlspecialchars($_POST['telephone'])) ? htmlspecialchars($_POST['telephone']) : null;
            $num_pav = isset(htmlspecialchars($_POST['num_pav'])) ? htmlspecialchars($_POST['num_pav']) : null;
            $auth = null;
            if ($mdp === $mdp2) {
                $hash = password_hash($mdp, PASSWORD_DEFAULT);
            } else {
                $_SESSION['msg'] = 'Les mots de passe ne correspondent pas';
                return $this->render('inscription', ['error' => $_SESSION['msg']]);
            };
            $user = new users(
                $username,
                $hash,
                $telephone,
                $num_pav,
                $auth
            );
            $bdd = new UsersBDD();
            $success = $bdd->inscription($user);
            if ($success) {
                $_SESSION['msg'] = 'Inscription réussie';
                return $this->render('inscription', ['success' => $_SESSION['msg']]);
            } else {
                $_SESSION['msg'] = 'Erreur lors de l\'inscription';
                return $this->render('inscription', ['error' => $_SESSION['msg']]);
            }
        }
        $this->render('inscription');
    }

    // Connexion
    public function login()
    {
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


    public function autoLogin()
    {
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

    public function monProfil()
    {
        header("Access-Control-Allow-Origin: GET");
        /*
        if (!isset($_GET['id'])) {
            return $this->sendJson(['error' => 'ID utilisateur manquant'], 400);
        }
            */
        $id = 1;

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
            return $result;
        }
    }
}
