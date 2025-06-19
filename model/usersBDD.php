<?php 
//cette partie conerne la connexion et suivis du users 

use model\users;
use config\Config;

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


public function mon_profil_utilisateur($id_utilisateur){
    $sql="SELECT * FROM users WHERE users_id = : id";
    $smt= $this->pdo->prepare($sql);
    $smt->bindValue(':id',$id_utilisateur,PDO::PARAM_INT);
     if ($smt->execute()) {
        $resultats = $smt->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultats) > 0) {
            foreach ($resultats as $rs) {
                 return [
                'id_users' => $rs['id_users'],
                'users' => new users($rs['username'], $rs['mdp'], $rs['telephone'], $rs['ps_cas'],$rs['auth_token'])
            ];
            }
}
     }
}


}

