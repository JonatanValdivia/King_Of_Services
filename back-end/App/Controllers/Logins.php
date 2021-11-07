<?php

use App\Core\Controller;
use BrunoMoraisTI\JwtToken;

Class Logins extends Controller{

  public function store(){
    $json = file_get_contents("php://input");
    $dadosComparacao = json_decode($json);
    $modelPrestador = $this->model("Prestador");
    $modelPrestador->email = $dadosComparacao->email;
    $modelPrestador->senha = $dadosComparacao->senha;
    if($modelPrestador->loginPrestador()){
      $jwtToken = new JwtToken("12345","localhost");
      // echo json_encode($modelPrestador);
      $horas = 2;
      echo $jwtToken->encode($modelPrestador, $horas);
      return true;
    }else{
      $modelCliente = $this->model("Cliente");
      $modelCliente->email = $dadosComparacao->email;
      $modelCliente->senha = $dadosComparacao->senha;
      if($modelCliente->loginCliente()){
        $jwtToken = new JwtToken("12345","localhost");
        // echo json_encode($modelCliente);
        echo $jwtToken->encode($modelPrestador, 1);
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