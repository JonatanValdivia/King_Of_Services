<?php

use App\Core\Controller;
use \Firebase\JWT\JWT;

Class Logins extends Controller{

  public function store(){
    $json = file_get_contents("php://input");
    $dadosComparacao = json_decode($json);
    $modelPrestador = $this->model("Prestador");
    $modelPrestador->email = $dadosComparacao->email;
    $modelPrestador->senha = $dadosComparacao->senha;
    $secret_key = "owt1235";
    $iss = "kingofservices.com.br";
    $iat = time();
    $nbf = $iat + 10;
    $exp = $iat + 60;
    $aud = "my_user";
    if($modelPrestador->loginPrestador()){

      $login = "prestador";
      $user_arr_data = array(
        "id"    => $modelPrestador->idPrestador,
        "name"  => $modelPrestador->nome,
        "email" => $modelPrestador->email,
      ); 

      $payload_info = array(
        "iss"  => $iss,
        "iat"  => $iat,
        "nbf"  => $nbf,
        "exp"  => $exp,
        "aud"  => $aud,
        "data" => $user_arr_data
      );

      echo json_encode([
          "login" => $login,
          "token" => JWT::encode($payload_info, $secret_key, 'HS512')
        ]);

    }else{
      
      $modelCliente = $this->model("Cliente");
      $modelCliente->email = $dadosComparacao->email;
      $modelCliente->senha = $dadosComparacao->senha;
      if($modelCliente->loginCliente()){
        
        $login = "cliente";
        $user_arr_data2 = array(
          "id"    => $modelCliente->idCliente,
          "name"  => $modelCliente->nome,
          "email" => $modelCliente->email,
        );

        $payload_info = array(
          "iss"  => $iss,
          "iat"  => $iat,
          "nbf"  => $nbf,
          "exp"  => $exp,
          "aud"  => $aud,
          "data" => $user_arr_data2
        );

        echo json_encode([
          "login" => $login,
          "token" => JWT::encode($payload_info, $secret_key, 'HS512')
        ]);

      }else{
        $erro = ["Erro" => "E-mail e/ou senha inválido(s)"]; 
        echo json_encode($erro);
        http_response_code(404);
        return false;
      }
    }
  }
}