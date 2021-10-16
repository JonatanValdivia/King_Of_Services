<?php

use App\Core\Model;

Class EnderecoPrestador{

  public $idEnderecoPrestador;
  public $idPrestador;
  public $uf;
  public $cidade;
  public $bairro;
  public $rua;
  public $numero;
  public $complemento;
  public $cep;

  public function listarTodos(){
    $sql = "SELECT tblEnderecoPrestadores.idEnderecoPrestador, 
    tblEnderecoPrestadores.idPrestador, 
    tblprestadores.nome as nomePrestador, 
    tblEnderecoPrestadores.uf, 
    tblEnderecoPrestadores.cidade,
    tblEnderecoPrestadores.bairro, 
    tblEnderecoPrestadores.rua,
    tblEnderecoPrestadores.numero,
    tblEnderecoPrestadores.complemento,
    tblEnderecoPrestadores.cep
    from tblEnderecoPrestadores inner join tblprestadores
    on tblEnderecoPrestadores.idPrestador = tblprestadores.idPrestador;
    ";
    $stmt = Model::getConn()->prepare($sql);
    if($stmt->execute()){
      $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return false;
    }
  }

  public function inserirEnderecoPrestador(){
    $sql = "INSERT into tblEnderecoPrestadores (idPrestador, uf, cidade, bairro, rua, numero, complemento, cep) 
    values (:idPrestador, :uf, :cidade, :bairro, :rua, :numero, :complemento, :cep);";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idPrestador", $this->idPrestador);
    $stmt->bindValue(":uf", $this->uf);
    $stmt->bindValue(":cidade", $this->cidade);
    $stmt->bindValue(":bairro", $this->bairro);
    $stmt->bindValue(":rua", $this->rua);
    $stmt->bindValue(":numero", $this->numero);
    $stmt->bindValue(":complemento", $this->complemento);
    $stmt->bindValue(":cep", $this->cep);
    if($stmt->execute()){
      $this->idEnderecoPrestador = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      echo "Erro";
    }
  }

  public function atualizar(){
    $sql = "UPDATE tblEnderecoPrestadores set uf = :uf, cidade = :cidade, bairro = :bairro, rua = :rua, numero = :numero, complemento = :complemento, cep = :cep where idEnderecoPrestador = :idEnderecoPrestador;";
    $stmt = Model::getConn()->prepare($sql);
    // $stmt->bindValue(":idPrestador", $this->idPrestador);
    $stmt->bindValue(":uf", $this->uf);
    $stmt->bindValue(":cidade", $this->cidade);
    $stmt->bindValue(":bairro", $this->bairro);
    $stmt->bindValue(":rua", $this->rua);
    $stmt->bindValue(":numero", $this->numero);
    $stmt->bindValue(":complemento", $this->complemento);
    $stmt->bindValue(":cep", $this->cep);
    $stmt->bindValue(":idEnderecoPrestador", $this->idEnderecoPrestador);
    return $stmt->execute();
  }

  public function buscarPorId($id){
    $sql = "SELECT idEnderecoPrestador, idPrestador, uf, cidade, bairro, rua, numero, complemento, cep FROM tblEnderecoPrestadores WHERE idEnderecoPrestador = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idEnderecoPrestador = $resultado->idEnderecoPrestador;
      $this->idPrestador = $resultado->idPrestador;
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

  public function deletar(){
    $sql = "DELETE FROM tblEnderecoPrestadores WHERE idEnderecoPrestador = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $this->idEnderecoPrestador);
    $stmt->execute();
  }
}