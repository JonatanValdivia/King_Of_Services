<?php

use App\Core\Model;

class Profissao{

  public $idProfissao;
  public $nome;

  public function listarTodasProfissoes(){
    $sql = "SELECT idProfissao, nome FROM tblProfissao";
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
    $sql = "SELECT idProfissao, nome FROM tblProfissao WHERE idProfissao = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    if($stmt->rowCount() >  0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idProfissao = $resultado->idProfissao;
      $this->nome = $resultado->nome;
      return $this;
    }else{
      return [];
    }
  }

  public function inserirProfissao(){
    $sql = "INSERT INTO tblProfissao (nome) value (:nome)";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":nome", $this->nome);
    if($stmt->execute()){
      $this->idProfissao = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      echo "Erro";
    }
  }

  public function atualizar(){
    $sql = "UPDATE tblProfissao SET nome = :nome WHERE idProfissao = :idProfissao";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":nome", $this->nome);
    $stmt->bindValue(":idProfissao", $this->idProfissao);
    return $stmt->execute();
  }
}