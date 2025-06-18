<?php
namespace controllers;
class HomeControllers extends Controllers{
   public function index(){
        $data = [
            'title' => 'Home',
            'content' => 'Home'
        ];
        json_encode($data);
        return;
    }


}