<?php

use App\Core\Model;

Class Prestador{

  public $idPrestadores;
  public $idSexo;
  public $idEndereco;
  public $idProfissao;
  public $nome;
  public $email;
  public $senha;
  public $telefone;
  public $dataNascimento;
  public $foto;

  public function listarTodos(){
    $sql = 'SELECT idPrestadores, idSexo, idEndereco, idProfissao, nome, email, telefone, dataNascimento, foto FROM tblPrestadores;';
    $stmt = Model::getConn()->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return [];
    }
  }

  public function procurarPorId($id){
    $sql = "SELECT idPrestadores, idSexo, idEndereco, idProfissao, nome, email, telefone, dataNascimento, foto from tblprestadores where idPrestadores = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idPrestadores = $resultado->idPrestadores;
      $this->idSexo = $resultado->idSexo;
      $this->idEndereco = $resultado->idEndereco;
      $this->idProfissao = $resultado->idProfissao;
      $this->nome = $resultado->nome;
      $this->email = $resultado->email;
      $this->telefone = $resultado->telefone;
      $this->dataNascimento = $resultado->dataNascimento;
      $this->foto = $resultado->foto;
      return $this;
    }else{
      return false;
    }
  }
  
}