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
            $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null;
            $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : null;
            $telephone = isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : null;
            $mdp = isset($_POST['mdp']) ? htmlspecialchars($_POST['mdp']) : null;
            $mdp2 = isset($_POST['mdp2']) ? htmlspecialchars($_POST['mdp2']) : null;
            $role = isset($_POST['role']) ? htmlspecialchars($_POST['role']) : 'medecin'; // Par défaut, le rôle est 'medecin'
            $auth = null;
            if ($mdp === $mdp2) {
                $hash = password_hash($mdp, PASSWORD_DEFAULT);
            } else {
                $_SESSION['msg'] = 'Les mots de passe ne correspondent pas';
                return $this->render('auth/inscription', 
                [
                    'error' => $_SESSION['msg'],
                    'title' => 'Inscription échouée',
                    'content' => 'Veuillez corriger les erreurs ci-dessus.'
                ]);
            };
            $user = new users(
                $nom,
                $prenom,
                $telephone,
                $mdp,
                date('Y-m-d H:i:s'),
                $role,
                $auth
            );
            $bdd = new UsersBDD();
            $success = $bdd->inscription($user);
            if ($success) {
                $bdd->record($success['users_id'] ?? 0, date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']);
                $_SESSION['msg'] = 'Inscription réussie';
                return $this->render('auth/login',
                [
                    'success' => $_SESSION['msg'],
                    'title' => 'Connexion réussie',
                    'content' => 'Vous êtes maintenant connecté.'
                ]);
            } else {
                $_SESSION['msg'] = 'Erreur lors de l\'inscription';
                return $this->render('auth/inscription', 
                [
                    'error' => $_SESSION['msg'],
                    'title' => 'Inscription échouée',
                    'content' => 'Veuillez corriger les erreurs ci-dessus.'
                ]);
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
                $bdd->record($userid, date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']);
                return $this->monProfil($userid);
            } else {
                unset($_SESSION['token']); // Supprimer le token invalide
                return $this->requireAuth();
            }
        }
        // 🔐 Connexion classique
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $telephone = isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : null;
            $mdp = isset($_POST['mdp']) ? htmlspecialchars($_POST['mdp']) : null;
            $result = $bdd->login($telephone, $mdp);
            if ($result) {
                // ✅ Générer un nouveau token
                $user = $result['users'];
                $_SESSION['msg'] = 'Connexion réussie';
                $_SESSION['token'] = $user->getAuthToken(); // Stocker le token dans la session
                $_SESSION['nom'] = $user->getNom();
                $_SESSION['telephone'] = $user->getTelephone();
                $bdd->record($result['users_id'], date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']);
                return $this->monProfil($result['users_id']);
            } else {
                $_SESSION['msg'] = 'Identifiants invalides';
                return $this->render('auth/login', 
                [
                    'error' => $_SESSION['msg'],
                    'title' => 'Connexion échouée',
                    'content' => 'Veuillez vérifier vos identifiants et réessayer.'
                ]);
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
    public function monProfil($userid)
    {
        $this->requireAuth();
        $bdd = new UsersBDD();
        $result = $bdd->mon_profil_utilisateur($userid);
        if ($result) {
            $user = $result['users'];
            return $this->render('profil',
                [
                    'user' => $user,
                    'userid' => $result['users_id'],
                    'title' => 'Mon Profil',
                    'content' => 'Voici vos informations de profil.'
                ]
            );
        } else {
            $_SESSION['msg'] = 'Utilisateur non trouvé';
            return $this->render('profil'
                , [
                    'error' => $_SESSION['msg'],
                    'title' => 'Profil non trouvé',
                    'content' => 'Aucun profil trouvé pour cet utilisateur.'
                ]);
        }
    }
}
