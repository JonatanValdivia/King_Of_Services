<?php

use App\Core\Model;
  
Class EnderecoCliente{

  public $idEnderecoCliente;
  public $idCliente;
  public $nome;
  public $uf;
  public $cidade;
  public $bairro;
  public $rua;
  public $numero;
  public $complemento;
  public $cep;

  public function listarTodosEnderecosCLientes(){
    $sql = "SELECT tblEnderecoClientes.idEnderecoCliente, 
    tblEnderecoClientes.idCliente, 
    tblClientes.nome, 
    tblEnderecoClientes.uf, 
    tblEnderecoClientes.cidade,
    tblEnderecoClientes.bairro, 
    tblEnderecoClientes.rua,
    tblEnderecoClientes.numero,
    tblEnderecoClientes.complemento,
    tblEnderecoClientes.cep
    from tblEnderecoClientes inner join tblClientes
    on tblEnderecoClientes.idCliente = tblClientes.idCliente;";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return [];
    }
  }

  public function buscarEnderecoCLientePeloId($id){
    $sql = "SELECT tblEnderecoClientes.idEnderecoCliente, 
    tblEnderecoClientes.idCliente, 
    tblClientes.nome, 
    tblEnderecoClientes.uf, 
    tblEnderecoClientes.cidade,
    tblEnderecoClientes.bairro, 
    tblEnderecoClientes.rua,
    tblEnderecoClientes.numero,
    tblEnderecoClientes.complemento,
    tblEnderecoClientes.cep
    from tblEnderecoClientes 
    inner join tblClientes
    on tblEnderecoClientes.idCliente = tblClientes.idCliente
    where tblenderecoclientes.idEnderecoCliente = :idEnderecoCliente;";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idEnderecoCliente", $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idEnderecoCliente = $resultado->idEnderecoCliente;
      $this->idCliente = $resultado->idCliente;
      $this->nome = $resultado->nome;
      $this->uf = $resultado->uf;
      $this->cidade = $resultado->cidade;
      $this->bairro = $resultado->bairro;
      $this->rua = $resultado->rua;
      $this->numero = $resultado->numero;
      $this->complemento = $resultado->complemento;
      $this->cep = $resultado->cep;
      return $this;
    }
  }

  public function inserirEnderecoCliente(){
    $sql = "INSERT into tblenderecoclientes (idCliente, uf, cidade, bairro, rua, numero, complemento, cep) values (:idCliente, :uf, :cidade, :bairro, :rua, :numero, :complemento, :cep);";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idCliente", $this->idCliente);
    $stmt->bindValue(":uf", $this->uf);
    $stmt->bindValue(":cidade", $this->cidade);
    $stmt->bindValue(":bairro", $this->bairro);
    $stmt->bindValue(":rua", $this->rua);
    $stmt->bindValue(":numero", $this->numero);
    $stmt->bindValue(":complemento", $this->complemento);
    $stmt->bindValue(":cep", $this->cep);

    if($stmt->execute()){
      $this->idEnderecoCliente = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      return false;
    }
  }

  public function updateEnderecoCliente(){
    $sql = "UPDATE tblEnderecoClientes set uf = :uf, cidade = :cidade, bairro = :bairro,
    rua = :rua, numero = :numero, complemento = :complemento, cep = :cep 
    where idEnderecoCliente = :idEnderecoCliente;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":uf", $this->uf);
    $stmt->bindValue(":cidade", $this->cidade);
    $stmt->bindValue(":bairro", $this->bairro);
    $stmt->bindValue(":rua", $this->rua);
    $stmt->bindValue(":numero", $this->numero);
    $stmt->bindValue(":complemento", $this->complemento);
    $stmt->bindValue(":cep", $this->cep);
    $stmt->bindValue(":idEnderecoCliente", $this->idEnderecoCliente);
    if($stmt->execute()){
      return $this;
    }else{
      return [];
    }
  }

  public function deletarEnderecoCliente(){
    $sql = "DELETE from tblEnderecoClientes where idEnderecoCliente = :idEnderecoCliente";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idEnderecoCliente", $this->idEnderecoCliente);
    return $stmt->execute();
  }
}

