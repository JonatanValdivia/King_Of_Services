<?php
//
Class InfoCadastroOuLogin{
  public function index(){
    $info = ["Info" => [
      "Cadastro" => "Cadastre-se", 
      "Login" => "Login"
      ]
    ];
    echo json_encode($info);
  }
}