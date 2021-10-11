<?php

use App\Core\Model;
//
class Profissao{

  public $idProfissao;
  public $nomeProfissao;

  public function listarTodasProfissoes(){
    $sql = "SELECT idProfissao, nomeProfissao FROM tblProfissao";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetchALl(\PDO::FETCH_OBJ);
      echo json_encode($resultado);
      return $resultado;
    }else{
      return [];
    }
  }

  public function buscarPorId($id){
    $sql = "SELECT idProfissao, nomeProfissao FROM tblProfissao WHERE idProfissao = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    if($stmt->rowCount() >  0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idProfissao = $resultado->idProfissao;
      $this->nomeProfissao = $resultado->nomeProfissao;
      return $this;
    }else{
      return [];
    }
  }

  public function inserirProfissao(){
    $sql = "INSERT INTO tblProfissao (nomeProfissao) value (:nomeProfissao)";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":nomeProfissao", $this->nomeProfissao);
    if($stmt->execute()){
      $this->idProfissao = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      echo "Erro";
    }
  }

  public function atualizar(){
    $sql = "UPDATE tblProfissao SET nomeProfissao = :nomeProfissao WHERE idProfissao = :idProfissao";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":nomeProfissao", $this->nomeProfissao);
    $stmt->bindValue(":idProfissao", $this->idProfissao);
    return $stmt->execute();
  }

  public function deletar(){
    $sql = "DELETE FROM tblProfissao WHERE idProfissao = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $this->idProfissao);
    $stmt->execute();
  }
}