<?php

use App\Core\Model;

Class Sexo{
  public $idSexo;
  public $sigla;
  public $descricao;
  
  public function listarTodosOsSexos(){
    $sql = "SELECT * from tblsexo";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetchALl(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return [];
    }
  }

  public function criarSexo(){
    $sql = "INSERT into tblSexo (sigla, descricao) values (:sigla, :descricao);";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":sigla", $this->sigla);
    $stmt->bindValue(":descricao", $this->descricao);
    if($stmt->execute()){
      $this->idSexo = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }
  }

  public function buscarSexoPeloId(){
    
  }
}