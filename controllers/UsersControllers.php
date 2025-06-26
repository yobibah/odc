<?php

namespace controllers;

use model\users;
use model\UsersBDD;

class UsersControllers extends HomeControllers
{
    //inscription
    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : null;
            $mdp = isset($_POST['mdp']) ? htmlspecialchars($_POST['mdp']) : null;
            $mdp2 = isset($_POST['mdp2']) ? htmlspecialchars($_POST['mdp2']) : null;
            $telephone = isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : null;
            $num_pav = isset($_POST['num_pav']) ? htmlspecialchars($_POST['num_pav']) : null;
            $auth = null;
            if ($mdp === $mdp2) {
                $hash = password_hash($mdp, PASSWORD_DEFAULT);
            } else {
                $_SESSION['msg'] = 'Les mots de passe ne correspondent pas';
                return $this->render('auth/inscription', ['error' => $_SESSION['msg']]);
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
                $bdd->record($success['users_id'] ?? 0, date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']);
                $_SESSION['msg'] = 'Inscription réussie';
                return $this->render('auth/login', ['success' => $_SESSION['msg']]);
            } else {
                $_SESSION['msg'] = 'Erreur lors de l\'inscription';
                return $this->render('auth/inscription', ['error' => $_SESSION['msg']]);
            }
        }
        $this->render('auth/inscription'
            , [
                'title' => 'Inscription',
                'content' => 'Veuillez vous inscrire'
            ]);
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
                return $this->requireAuth();
            }
        }
        // 🔐 Connexion classique
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : null;
            $mdp = isset($_POST['mdp']) ? htmlspecialchars($_POST['mdp']) : null;
            $result = $bdd->login($username, $mdp);
            if ($result) {
                // ✅ Générer un nouveau token
                $user = $result['users'];
                $_SESSION['msg'] = 'Connexion réussie';
                $_SESSION['token'] = $user->get_Token(); // Stocker le token dans la session
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['telephone'] = $user->getTelephone();
                return $this->render('profil',
                    [
                        'user' => $user,
                        'userid' => $result['users_id']
                    ]
                );
            } else {
                $_SESSION['msg'] = 'Identifiants invalides';
                return $this->render('auth/login', ['error' => $_SESSION['msg']]);
            }
        } else {
            return $this->render('auth/login'
                , [
                    'title' => 'Connexion',
                    'content' => 'Veuillez vous connecter'
                ]);
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
            return $this->render('profil',
                [
                    'user' => $user,
                    'userid' => $result['users_id']
                ]
            );
        } else {
            $_SESSION['msg'] = 'Utilisateur non trouvé';
            return $this->render('profil');
        }
    }
}
