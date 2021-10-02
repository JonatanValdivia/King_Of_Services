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

  public function criarPrestador(){
    $selectIdEndereco = "SELECT idEndereco FROM tblendereco ORDER BY 1 DESC LIMIT 1;";
    $stmt = Model::getConn()->prepare($selectIdEndereco);
    $stmt->execute();

    if($stmt->rowCount()){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idEndereco = $resultado->idEndereco;
    }
    
    $sql = "INSERT INTO tblPrestadores (idSexo, idEndereco, idProfissao, nome, email, senha, telefone, dataNascimento, foto) VALUES (:idSexo, :idEndereco, :idProfissao, :nome, :email, :senha, :telefone, :dataNascimento, :foto)";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idSexo", $this->idSexo);
    $stmt->bindValue(":idEndereco", $this->idEndereco);
    $stmt->bindValue(":idProfissao", $this->idProfissao);
    $stmt->bindValue(":nome", $this->nome);
    $stmt->bindValue(":email", $this->email);
    $stmt->bindValue(":senha", $this->senha);
    $stmt->bindValue(":telefone", $this->telefone);
    $stmt->bindValue(":dataNascimento", $this->dataNascimento);
    $stmt->bindValue(":foto", $this->foto);

    if($stmt->execute()){
      $this->idPrestadores = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      return false;
    }
  }

  public function atualizar(){
    $sql = "UPDATE tblPrestadores SET idSexo = :idSexo, nome = :nome, email = :email, senha = :senha, telefone = :telefone, dataNascimento = :dataNascimento, foto = :foto WHERE idPrestadores = :idPrestadores;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idSexo", $this->idSexo);
    $stmt->bindValue(":nome", $this->nome);
    $stmt->bindValue(":email", $this->email);
    $stmt->bindValue(":senha", $this->senha);
    $stmt->bindValue(":telefone", $this->telefone);
    $stmt->bindValue(":dataNascimento", $this->dataNascimento);
    $stmt->bindValue(":foto", $this->foto);
    $stmt->bindValue(":idPrestadores", $this->idPrestadores);

    if($stmt->execute()){
      return $this;
    }else{
      return false;
    }

  }
  
}