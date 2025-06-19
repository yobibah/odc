<?php 
namespace controllers;
use model\RdvBDD;
use model\Rdv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use model\Config;
class RdvControllers extends Controllers{


public function relancer() {
        $rdvModel = new RdvBDD();
        $rdvs = $rdvModel->getRdvsDuJour7h();

        $sent = 0;
        $errors = [];

        foreach ($rdvs as $rdv) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tonemail@gmail.com';          // Remplace par ton email
                $mail->Password = 'mot_de_passe_app';            // Mot de passe d'application Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('tonemail@gmail.com', 'Santé App');
                $mail->addAddress($rdv['email'], $rdv['username']);
                $mail->isHTML(true);
                $mail->Subject = '⏰ Rappel : votre consultation aujourd\'hui à 07h00';

                $mail->Body = "
                    <p>Bonjour <strong>{$rdv['username']}</strong>,</p>
                    <p>Nous vous rappelons votre consultation prévue aujourd'hui à <strong>{$rdv['heure_consultation']}</strong> à <strong>{$rdv['hopitale_consultation']}</strong>.</p>
                    <p>Libellé : <em>{$rdv['libelle_consultation']}</em></p>
                    <p>Merci de vous présenter à l'heure.</p>
                ";

                $mail->send();
                $sent++;

            } catch (Exception $e) {
                $errors[] = "Erreur avec {$rdv['email']}: {$mail->ErrorInfo}";
            }
        }

        return $this->sendJson([
            'status' => 'ok',
            'emails_envoyes' => $sent,
            'erreurs' => $errors
        ]);
    }

    private function sendJson($data, $status = 200) {
        http_response_code($status);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }

}

