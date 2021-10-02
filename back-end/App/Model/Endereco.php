<?php

use App\Core\Model;

Class Endereco{

  public $idEndereco;
  public $uf;
  public $cidade;
  public $bairro;
  public $rua;
  public $numero;
  public $complemento;
  public $cep;

  public function listarTodos(){
    $sql = "SELECT * FROM tblEndereco";
    $stmt = Model::getConn()->prepare($sql);
    if($stmt->execute()){
      $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);
      echo json_encode($resultado); 
      return $resultado;
    }else{
      return false;
    }
  }

  public function inserirEndereco(){
    $sql = "INSERT INTO tblEndereco (uf, cidade, bairro, rua, numero, complemento, cep) 
    values (:uf, :cidade, :bairro, :rua, :numero, :complemento, :cep);";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":uf", $this->uf);
    $stmt->bindValue(":cidade", $this->cidade);
    $stmt->bindValue(":bairro", $this->bairro);
    $stmt->bindValue(":rua", $this->rua);
    $stmt->bindValue(":numero", $this->numero);
    $stmt->bindValue(":complemento", $this->complemento);
    $stmt->bindValue(":cep", $this->cep);
    if($stmt->execute()){
      $this->idEndereco = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      echo "Erro";
    }
  }

  public function atualizar(){
    $sql = "UPDATE tblEndereco SET uf = :uf, cidade = :cidade, bairro = :bairro, rua = :rua, numero = :numero, complemento = :complemento, cep = :cep WHERE idEndereco = :idEndereco";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":uf", $this->uf);
    $stmt->bindValue(":cidade", $this->cidade);
    $stmt->bindValue(":bairro", $this->bairro);
    $stmt->bindValue(":rua", $this->rua);
    $stmt->bindValue(":numero", $this->numero);
    $stmt->bindValue(":complemento", $this->complemento);
    $stmt->bindValue(":cep", $this->cep);
    $stmt->bindValue(":idEndereco", $this->idEndereco);
    return $stmt->execute();
  }

  public function buscarPorId($id){
    $sql = "SELECT uf, cidade, bairro, rua, numero, complemento, cep FROM tblEndereco WHERE idEndereco = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->uf = $resultado->uf;
      $this->cidade = $resultado->cidade;
      $this->bairro = $resultado->bairro;
      $this->rua = $resultado->rua;
      $this->numero = $resultado->numero;
      $this->complemento = $resultado->complemento;
      $this->cep = $resultado->cep;
      return $this;
    }else{
      return [];
    }
  }
}