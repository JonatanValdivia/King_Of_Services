<?php
  namespace App\Controllers;
  Class Token{
    public static function gerarToken($iss, $name, $email){

      function base64ErlEncode($data){
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
      }

      $header = [
        'alg' => 'HS256',
        'typ' => 'JWT'
      ];

      $header = json_encode($header);
      $header = base64ErlEncode($header);
     
      $payload = [
          'iss' => $iss,
          'name' => $name,
          'email' => $email
      ];

      $payload = json_encode($payload);
      $payload = base64ErlEncode($payload);
      
      $signature = hash_hmac('sha256', "$header.$payload", 'minha-senha', true);
      $signature = base64ErlEncode($signature);
      
      return "$header.$payload.$signature";
    }

    public static function ValidarToken($token){
      // $token = file_get_contents("php://input");
      //Dividindo o token
      $part = explode(".",$token);
      $header = $part[0];
      $payload = $part[1];
      $signature = $part[2];

      $valid = hash_hmac('sha256',"$header.$payload",'minha-senha',true);
      $valid = base64_encode($valid);

      if($signature == $valid){
        echo "Token valid";
      } else{
        echo 'Token invalid';
      }

    }
  }