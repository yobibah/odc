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
    public function record($id, $action, $time, $ip_adress )
    {
        $sql = "INSERT INTO login (user_id,action, time, ip_adress) VALUES (:user_id, :action, :time, :ip_adress)";
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':user_id', $id, PDO::PARAM_INT);
        $stm->bindValue(':action', $action, PDO::PARAM_STR);
        $stm->bindValue(':time', $time, PDO::PARAM_STR);
        $stm->bindValue(':ip_adress', $ip_adress, PDO::PARAM_STR);
        return $stm->execute();
    }
    public function login($telephone, $mdp)
    {
        $sql = "SELECT * FROM users WHERE telephone = :telephone";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':telephone', $telephone, PDO::PARAM_STR);

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
                            'users' => new Users($rs['nom'], $rs['prenom'], $rs['telephone'], $rs['mdp'], $rs['date_creation'], $rs['role'], $rs['auth_token'])
                        ];
                    }
                }
            }
        }
        return null;
    }
    public function inscription(Users $users)
    {
        $sql = "INSERT INTO users (nom,prenom,mdp,telephone,date_creation,role) VALUES(:nom,:prenom,:mdp,:telephone,:date_creation,:role)";
        $smt = $this->pdo->prepare($sql);
        return $smt->execute([
            ':nom' => $users->getNom(),
            ':prenom' => $users->getPrenom(),
            ':mdp' => $users->getPassword(),
            ':telephone' => $users->getTelephone(),
            ':date_creation' => $users->getDateCreation(),
            ':role' => $users->getRole(),
        ]);
    }

 /*   public function autoLogin()
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

*/
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
                        'users' => new users($rs['nom'], $rs['prenom'], $rs['telephone'], $rs['mdp'], $rs['date_creation'], $rs['role'], $rs['auth_token'])
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
                $row['nom'],
                $row['prenom'],
                $row['telephone'],
                $row['mdp'],
                $row['date_creation'],
                $row['role'],
                $row['auth_token']
            );
            return ['users_id' => $row['users_id'], 'users' => $user];
        }

        return null;
    }
}
