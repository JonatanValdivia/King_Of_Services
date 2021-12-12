<?php

use App\Core\Model;

Class Avaliacao{
  public $idAvaliacao;
  public $idPrestador;
  public $idCliente;
  public $estrelas;
  public $comentario;
  public $foto;

  public function buscarPeloIdDaAvaliacao($id){
    $sql = "SELECT idAvaliacao, idPrestador, idCliente, estrelas, comentario, foto from tblAvaliacoes where idAvaliacao = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute(); 
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return [];
    }
  }

  public function buscarPeloIdDoPrestador($id){
    $sql = "SELECT tblavaliacoes.idAvaliacao, 
    tblavaliacoes.idPrestador, 
    tblavaliacoes.idCliente, 
    tblclientes.nome,
    tblclientes.foto,
    tblavaliacoes.estrelas, 
    tblavaliacoes.comentario, 
    tblavaliacoes.foto as imagemServico
    from tblAvaliacoes inner join tblClientes
    on tblavaliacoes.idCliente = tblClientes.idCliente
    where idPrestador = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute(); 
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return [];
    }
  }

  public function criarAvalidacao(){
    $sql = "INSERT into tblavaliacoes (idPrestador, idCliente, estrelas, comentario, foto) 
    values (:idPrestador, :idCliente, :estrelas, :comentario, :foto);";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':idPrestador', $this->idPrestador);
    $stmt->bindValue(':idCliente', $this->idCliente);
    $stmt->bindValue(':estrelas', $this->estrelas);
    $stmt->bindValue(':comentario', $this->comentario);
    $stmt->bindValue(':foto', $this->foto);
    if($stmt->execute()){
      $this->idAvaliacao = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      return false;
    }

  }


}