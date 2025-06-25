<?php 
namespace model;
class paiement {
    private $api_key;
    private $id_marchand;
    private $url_notifi;
    private $return_url;

    public function __construct($api_key, $id_marchand, $url_notifi, $return_url) {
        $this->api_key = $_ENV['API_KEY'];
        $this->id_marchand = $_ENV['ID_MARCHAND'];
        $this->url_notifi = $_ENV['URL_NOTIFI'];
        $this->return_url = $_ENV['RETURN_URL'];
    }
    public function demarrer_paiment($montant ,$nom,$email){
        $commande_id = uniqid();
        $data= [
            "commande"=>[
                "invoice"=>$commande_id,
                "description"=>"paiement de consultation",
                "total_monatant"=>$montant
            ],
            "client"=>[
                "name"=>$nom,
                "email"=>$email
            ],
            "config"=> [
                "callback_url"=>$this->url_notifi,
                "return_url"=>$this->return_url,
         
            ],
           
        ];
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL=> "https://api.ligdicash.com/v1/checkout/invoice/create",
            CURLOPT_RETURNTRANSFER=>true,

            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>json_encode($data),
            CURLOPT_HTTPHEADER=> [
                "Accept"=> "application/json",
                "Content-Type"=> "application/json",
                "Apikey"=> "{$this->api_key}"
            ]
        ]);

        $reponse= curl_exec($curl);
        curl_error($curl);
        $result= json_decode($reponse,true);
        if(isset($result['reponse_code']) && $result['response_code']==="00"){
            return $result['response_text']['payment_url'];
        }
        return null;
    }
}