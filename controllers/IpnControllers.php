<?php 
namespace controllers;
use model\paiement;

class IpnControllers extends Controllers{

    public function IPN(){
        $api_key=$_ENV['API_KEY'];
        $input =  file_get_contents("php://input");
        $data = json_decode($input, true);
        $token = $data ['token'] ?? null;
        
        if($token){
            $curl = curl_init();
            curl_setopt_array($curl,[
                CURLOPT_URL => "https://api.ligdicash.com/v1/checkout/invoice/confirm/$token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER =>[
                    'Accept'=>'application/json',
                    'Apikey'=> " $api_key"
                ],
           
            ]);
            $reponse = curl_exec($curl);
        
            curl_close($curl);
            $result = json_decode($reponse,true);
            if($result['response_code']=="00" && $result['response_text']['status']=="completed"){
                file_put_contents("paiements.txt", "Paiement OK :{$token} \n",FILE_APPEND);
            }
            else{
                file_put_contents("paiements.txt", "Echec  :{$token} \n", FILE_APPEND);
            }
              
       
    }
       
}

public function test() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['token'] ?? null;
        if ($token) {
            // Simule une requête IPN avec ce token
            $json = json_encode(['token' => $token]);
            $context = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-Type: application/json\r\n",
                    'content' => $json
                ]
            ]);

            // Appelle le même contrôleur IPN en interne
            file_put_contents('php://input', $json); // Optionnel si appel direct
            $this->IPN();
        }
    } else {
        // Affiche le formulaire
        $this->render('form');
    }
}

}