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

    public function requireAuth()
    {
        if (!isset($_SESSION['token'])) {
            return $this->redirect('login');
        }
    }

    // Connexion
    public function login()
    {
        $bdd = new UsersBDD();

        // 🔁 Connexion par token si fourni
        if (isset($_SESSION['token'])) {
            $result = $bdd->getUserByToken($_SESSION['token']);
            if ($result) {
                $user = $result['users'];
                $userid = $result['users_id'];
                return $this->render('profil',
                    [
                        'user' => $user,
                        'userid' => $userid
                    ]
                );
            } else {
                unset($_SESSION['token']); // Supprimer le token invalide
                return $this->redirect('login');
            }
        }
        // 🔐 Connexion classique
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $username = isset(htmlspecialchars($_POST['username'])) ? htmlspecialchars($_POST['username']) : null;
            $mdp = isset(htmlspecialchars($_POST['mdp'])) ? htmlspecialchars($_POST['mdp']) : null;
            $result = $bdd->login($username, $mdp);
            if ($result) {
                // ✅ Générer un nouveau token
                $token = bin2hex(random_bytes(32));
                $bdd->updateToken($result['users_id'], $token);
                $user = $result['users'];
                $_SESSION['msg'] = 'Connexion réussie';
                $_SESSION['token'] = $token; // Stocker le token dans la session
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['telephone'] = $user->getTelephone();;
                return $this->requireAuth();
            } else {
                $_SESSION['msg'] = 'Identifiants invalides';
                return $this->redirect('login');
            }
        } else {
            return $this->redirect('login');
        }
    }

    /*   public function autoLogin()
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
            return $this->render('login');
        }
    }
*/
    public function monProfil()
    {
        $this->requireAuth();

        $bdd = new UsersBDD();
        $result = $bdd->mon_profil_utilisateur($_SESSION['user_id']);

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
