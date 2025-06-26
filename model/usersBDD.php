<?php
//cette partie conerne la connexion et suivis du users 
namespace model;

use model\users;
use config\Config;
use PDO;

class UsersBDD extends Users
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Config::getpdo()->getconnexion();
    }

    public function login($username, $mdp)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultats) > 0) {
                foreach ($resultats as $rs) {
                    if (password_verify($mdp, $rs['mdp'])) {
                        $token = bin2hex(random_bytes(32));
                        $this->updateToken($rs['users_id'], $token);
                        setcookie('auth_token', $token, time() + (86400 * 7), "/", "", false, true);
                        return [
                            'users_id' => $rs['users_id'],
                            'users' => new Users($rs['username'], $rs['mdp'], $rs['username'], $rs['ps_cas'], $rs['auth_token'])
                        ];
                    }
                }
            }
        }
        return null;
    }
    public function inscription(Users $users)
    {
        $sql = "INSERT INTO users (username,mdp,telephone,num_pav) VALUES(:username,:mdp,:telephone,:num_pav)";
        $smt = $this->pdo->prepare($sql);
        return $smt->execute([
            ':username' => $users->getusername(),
            ':mdp' => $users->getPassword(),
            ':telephone' => $users->getTelephone(),
            ':num_pav' => $users->numero_peronne_rev()
        ]);
    }

    public function autoLogin()
    {
        if (!isset($_COOKIE['auth_token'])) {
            return null;
        }

        $token = $_COOKIE['auth_token'];

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE auth_token = :token");
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rs) {
                return [
                    'users_id' => $rs['users_id'],
                    'users' => new users($rs['username'], $rs['mdp'], $rs['telephone'], $rs['num_pav'], $rs['auth_token'])
                ];
            }
        }

        return null;
    }


    public function mon_profil_utilisateur($users_id)
    {
        $sql = "SELECT * FROM users WHERE users_id = :users_id";
        $smt = $this->pdo->prepare($sql);
        $smt->bindValue(':users_id', $users_id, PDO::PARAM_INT);
        if ($smt->execute()) {
            $resultats = $smt->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultats) > 0) {
                foreach ($resultats as $rs) {
                    return [
                        'users_id' => $rs['users_id'],
                        'users' => new users($rs['username'], $rs['mdp'], $rs['telephone'], $rs['num_pav'], $rs['auth_token'])
                    ];
                }
            }
        }
    }

    public function updateToken($users_id, $token)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET auth_token = :token WHERE users_id = :users_id");
        $stmt->execute([
            ':token' => $token,
            ':users_id' => $users_id
        ]);
    }

    public function getUserByToken($token)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE auth_token = :token");
        $stmt->execute([':token' => $token]);
        $row = $stmt->fetch();

        if ($row) {
            $user = new users(
                $row['username'],
                $row['mdp'],
                $row['telephone'],
                $row['numero_personne_rev'],
                $row['auth_token']
            );
            return ['users_id' => $row['users_id'], 'users' => $user];
        }

        return null;
    }
}
