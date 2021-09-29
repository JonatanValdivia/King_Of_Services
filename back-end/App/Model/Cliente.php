<?php

use App\Core\Model;

class Cliente{

  public $idClientes;
  public $idSexo;
  public $idEndereco;
  public $nome;
  public $email;
  public $senha;
  public $telefone;
  public $dataNascimento;
  public $foto;

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

  public function buscarPorId($id){
    $sql = "SELECT idClientes, idSexo, idEndereco, nome, email, telefone, dataNascimento, foto FROM tblClientes WHERE idClientes = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idClientes = $resultado->idClientes;
      $this->idSexo = $resultado->idSexo;
      $this->idEndereco = $resultado->idEndereco;
      $this->nome = $resultado->nome;
      $this->email = $resultado->email;
      $this->telefone = $resultado->telefone;
      $this->dataNascimento = $resultado->dataNascimento;
      $this->foto = $resultado->foto;
      return $this;
    }else{
      return [];
    }
  }

  public function atualizar(){
    $sql = "UPDATE tblclientes SET idSexo = :idSexo, idEndereco = :idEndereco, nome = :nome, email = :email, senha = :senha, telefone = :telefone, dataNascimento = :dataNascimento, foto = :foto WHERE idClientes = :id; ";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':idSexo', $this->idSexo);
    $stmt->bindValue(':idEndereco', $this->idEndereco);
    $stmt->bindValue(':nome', $this->nome);
    $stmt->bindValue(':email', $this->email);
    $stmt->bindValue(':senha', $this->senha);
    $stmt->bindValue(':telefone', $this->telefone);
    $stmt->bindValue(':dataNascimento', $this->dataNascimento);
    $stmt->bindValue(':foto', $this->foto);
    $stmt->bindValue(':id', $this->idClientes);

    return $stmt->execute();

  }
}