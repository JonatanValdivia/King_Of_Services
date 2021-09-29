<?php

use App\Core\Model;

class Cliente{
  public function listarTodos(){
    $slq = "SELECT idClientes, idSexo, idEndereco, nome, email, senha, telefone, dataNascimento, foto FROM tblClientes;";
    $stmt = Model::getConn()->prepare($slq);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return [];
    }
  }
}