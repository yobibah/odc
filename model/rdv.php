<?php 
namespace model;
class Rdv {

    private $date_rdv;
    private $heure_rdv;

   private $hopitale_rdv;
   
    private $users_id;


    public function __construct($heure_rdv,$hopitale_rdv,$date_rdv,$users_id){
  
        $this->heure_rdv = $heure_rdv;
        $this->hopitale_rdv = $hopitale_rdv;
        $this->date_rdv= $date_rdv;
        $this->users_id = $users_id;
    }

    public function getDate(){
        return $this->date_rdv;
    }

    public function getHeure(){
        return $this->heure_rdv;
    }

    public function getId_user(){
        return $this->users_id;
    }
    public function getHopitale_rdv(){
        return $this->hopitale_rdv;
    }


    public function getId_client(){
        return $this->users_id;
    }
}
