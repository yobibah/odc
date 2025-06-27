<?php 
namespace model;
class users{
    
    private $nom;
    private $prenom;
    private $telephone;
    private $password;
    private $date_creation;
    private $role;
    private $auth_token;

    public function __construct($nom,$prenom,$telephone,$password,$date_creation,$role,$auth_token){
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->password=$password;
        $this->date_creation=$date_creation;
        $this->telephone=$telephone ;
        $this->role=$role;
        $this->auth_token=$auth_token ;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getTelephone(){
        return $this->telephone;
    }

    public function getDateCreation(){
        return $this->date_creation;
    }

    public function getRole(){
        return $this->role;
    }

    public function getAuthToken(){
        return $this->auth_token ;
    }

}