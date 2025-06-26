<?php 
namespace model;
class users{
    
    public $username;
    public $password;
    private $telephone;
    private $numero_peronne_rev;
    private $auth_token;

    public function __construct($username,$password,$telephone,$numero_peronne_rev,$auth_token){
        $this->username=$username;
        $this->password=$password;
        $this->numero_peronne_rev=$numero_peronne_rev;
        $this->telephone=$telephone ;
        $this->auth_token=$auth_token ;
    }

    public function getusername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getTelephone(){
        return $this->telephone;
    }
    
    public function numero_peronne_rev(){
        return $this->numero_peronne_rev;
    }

    public function get_Token(){
        return $this->auth_token ;
    }

}