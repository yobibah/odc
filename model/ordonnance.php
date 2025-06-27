<?php
namespace model;

class ordonnance{
    private $consultation_id;
    private $contenu;
    private $date_emission;

    public function __construct($consultation_id, $contenu, $date_emission){
        $this->consultation_id = $consultation_id;
        $this->contenu = $contenu;
        $this->date_emission = $date_emission;
    }
    
    public function getConsultationId(){
        return $this->consultation_id;
    }

    public function getContenu(){
        return $this->contenu;
    }

    public function getDateEmission(){
        return $this->date_emission;
    }
}