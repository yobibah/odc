<?php
namespace controllers;

use model\Rdv;
use model\RdvBDD;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RdvControllers extends Controllers
{
    // 🔹 Ajouter un rendez-vous
    public function ajouterRdv()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input['heur_rdv'], $input['hopitale_rdv'], $input['date_rdv'], $input['id_client'])) {
            return $this->sendJson(['error' => 'Champs manquants'], 400);
        }

        $rdv = new Rdv(
            $input['heur_rdv'],
            $input['hopitale_rdv'],
            $input['date_rdv'],
            $input['id_client']
        );

        $bdd = new RdvBDD();
        $success = $bdd->add_rdv($rdv);

        return $this->sendJson(['status' => $success ? 'Rdv ajouté' : 'Échec'], $success ? 201 : 500);
    }

    // 🔹 Consulter les rendez-vous d’un client
public function mesRdv()
{
    if (!isset($_GET['users_id'])) {
        return $this->sendJson(['error' => 'users_id requis'], 400);
    }

    $id = $_GET['users_id'];
    $bdd = new RdvBDD();
    $rdvs = $bdd->mes_rdv($id);
    $rdvs_valides = [];
    $now_date = date('Y-m-d');
    $now_heure = date('H:i:s');

    foreach ($rdvs as $rdv) {
        $date_rdv = $rdv['date_rdv'];
        $heure_rdv = $rdv['heur_rdv'];

        // Si le rdv est dans le passé (date aujourd'hui mais heure dépassée)
        if ($date_rdv < $now_date || ($date_rdv == $now_date && $heure_rdv <= $now_heure)) {
            $bdd->supprimer_rdv_unique($id, $rdv['id_rdv']); // méthode à créer
            continue;
        }

        // Sinon, on garde ce rdv
        $rdvs_valides[] = $rdv;
    }

    return $this->sendJson($rdvs_valides);
}


    // 🔹 Supprimer les rdv d’un client
    public function supprimerRdv()
    {
        if (!isset($_SESSION['users_id'])) {
            return $this->sendJson(['error' => 'users_id requis'], 400);
        }

        $bdd = new RdvBDD();
        $id_rdv = $_GET['id_rdv'];
        $bdd->supprimer_rdv($_SESSION['users_id'],$id_rdv);

        return $this->sendJson(['status' => 'Rdv supprimé']);
    }

    // 🔹 Modifier un rdv existant
    public function modifierRdv()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['heur_rdv'], $input['hopitale_rdv'], $input['date_rdv'], $input['id_rdv'], $input['id_client'])) {
            return $this->sendJson(['error' => 'Champs requis manquants'], 400);
        }

        $rdv = new Rdv(
            $input['heur_rdv'],
            $input['hopitale_rdv'],
            $input['date_rdv'],
            $input['id_client']
        );

        $bdd = new RdvBDD();
        $success = $bdd->modifier_rdv($rdv, $input['id_rdv'], $input['users_id']);

        return $this->sendJson(['status' => $success ? 'Rdv modifié' : 'Échec de modification']);
    }

    // 🔹 Relancer les clients ayant un rdv aujourd’hui à 07h
    public function relancerRdv7h()
    {
        $bdd = new RdvBDD();
        $rdvs = $bdd->getRdvsDuJour7h();

        foreach ($rdvs as $rdv) {
            $this->envoyerMail(
                $rdv['email'],
                "Rappel de consultation",
                "Bonjour {$rdv['username']}, vous avez une consultation aujourd’hui à {$rdv['heur_rdv']} à {$rdv['hopitale_consultation']} pour {$rdv['libelle_consultation']}."
            );
        }

        return $this->sendJson(['status' => 'Mails envoyés']);
    }

    // 🔸 Envoi d'email (PHPMailer)
    private function envoyerMail()
    {
        $mail = new PHPMailer(true);
        if(isset($_SESSION['users_id'])){
            $email= new RdvBDD();
       
            $to =$email->getMail($_SESSION['users_id']);
            $mail->addAddress($to);
            
            $subject = 'Rappel de consultation';
            $body = 'Bonjour, vous avez une consultation aujourd’hui à 07h.';
        }

       
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com'; // 🔧 Adapter
            $mail->SMTPAuth   = true;
            $mail->Username   = 'votre_email@example.com';
            $mail->Password   = 'votre_mot_de_passe';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('votre_email@example.com', 'Nom App');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur mail : " . $mail->ErrorInfo);
        }
    }


        private function sendJson($data, $status = 200) {
        http_response_code($status);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }
}





