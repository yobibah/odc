<?php 
//cette partie conerne la connexion et suivis du users 
namespace model;
use model\users;
use config\Config;
use PDO;

class UsersBDD extends Users{
    private $pdo;

    public function __construct(){
        $this->pdo= Config::getpdo()->getconnexion();
    }

public function login($telephone, $mdp) {
    $sql = "SELECT * FROM users WHERE telephone = :telephone";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':telephone', $telephone, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultats) > 0) {
            foreach ($resultats as $rs) {
                if ($rs['mdp'] === $mdp) {


                    $token = bin2hex(random_bytes(32));

                   
                    $update = $this->pdo->prepare("UPDATE users SET auth_token = :token WHERE id_users = :id");
                    $update->execute([
                        ':token' => $token,
                        ':id' => $rs['id_users']
                    ]);

                 
                    setcookie('auth_token', $token, time() + (86400 * 7), "/", "", false, true);

                    return [
                        'id_users' => $rs['id_users'],
                        'users' => new Users($rs['username'], $rs['mdp'], $rs['telephone'], $rs['ps_cas'],$rs['auth_token'])
                    ];
                }
            }
        }
    }

    return null;
}




    public function inscription(Users $users){
        $sql="INSERT INTO users (username,mdp,telephone,numero_peronne_rev) VALUES(:username,:mdp,:telephone,:numero_peronne_rev)";
        $smt=$this->pdo->prepare($sql);
        return $smt->execute([
            ':username'=>$users->getusername(),
            ':mdp'=>$users->getPassword(),
            ':telephone'=>$users->getTelephone(),
            ':numero_peronne_rev'=>$users->numero_peronne_rev()


        ]);
    }

    public function autoLogin() {
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
                'id_users' => $rs['id_users'],
                'users' => new users($rs['username'], $rs['mdp'], $rs['telephone'], $rs['ps_cas'],$rs['auth_token'])
            ];
        }
    }

    return null;
}


public function mon_profil_utilisateur($users_id){
    $sql="SELECT * FROM users WHERE users_id = :users_id";
    $smt= $this->pdo->prepare($sql);
    $smt->bindValue(':users_id',$users_id,PDO::PARAM_INT);
     if ($smt->execute()) {
        $resultats = $smt->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultats) > 0) {
            foreach ($resultats as $rs) {
                 return [
                'users_id' => $rs['users_id'],
                'users' => new users($rs['username'], $rs['mdp'], $rs['telephone'], $rs['num_pav'],$rs['auth_token'])
            ];
            }
}
     }
}

public function updateToken($id_users, $token) {
    $stmt = $this->pdo->prepare("UPDATE users SET token = :token WHERE id_users = :id_users");
    $stmt->execute([
        ':token' => $token,
        ':id_users' => $id_users
    ]);
}

public function getUserByToken($token) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
    $stmt->execute([':token' => $token]);
    $row = $stmt->fetch();

    if ($row) {
        $user = new users(
            $row['username'],
            $row['mdp'],
            $row['telephone'],
            $row['numero_personne_rev'],
            $row['token']
        );
        return ['id_users' => $row['id_users'], 'users' => $user];
    }

    return null;
}


}

