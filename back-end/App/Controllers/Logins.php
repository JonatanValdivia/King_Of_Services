<?php

use App\Core\Controller;

Class Logins extends Controller{

  public function store(){
    $json = file_get_contents("php://input");
    $dadosComparacao = json_decode($json);
    $modelPrestador = $this->model("Prestador");
    $modelPrestador->email = $dadosComparacao->email;
    $modelPrestador->senha = $dadosComparacao->senha;
    if($modelPrestador->loginPrestador()){
      echo json_encode($modelPrestador);
      return true;
    }else{
      $modelCliente = $this->model("Cliente");
      $modelCliente->email = $dadosComparacao->email;
      $modelCliente->senha = $dadosComparacao->senha;
      if($modelCliente->loginCliente()){
        echo json_encode($modelCliente);
        return true;
      }else{
        $erro = ["Erro" => "E-mail e/ou senha inválido(s)"]; 
        echo json_encode($erro);
        //http_response_code(404);
        return false;
      }
    }
  }
}