<?php

use App\Core\Model;
//
class Cliente{

  public $idClientes;
  public $idSexo;
  public $idEndereco;
  public $nome;
  public $email;
  public $senha;
  public $telefone;
  public $dataNascimento;
  public $idade;
  public $foto;

  public function listarTodos(){

    $slq = "SELECT tblclientes.idClientes as idCliente, tblsexo.descricacao as sexo, tblClientes.nome as nome, tblClientes.email as email, tblendereco.uf as siglaEstado, tblendereco.cidade as cidade, tblendereco.bairro as bairro, 
    tblendereco.rua as rua, tblendereco.numero as numero, tblendereco.complemento as complemento, 
    tblendereco.cep as CEP, tblclientes.telefone as telefone, date_format(dataNascimento, '%d/%m/%Y') as dataNascimento,
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade, tblclientes.foto as foto
    FROM tblsexo inner join tblclientes
    on tblsexo.idSexo = tblclientes.idSexo
    left join tblendereco 
    on tblendereco.idEndereco = tblclientes.idEndereco;";

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
    $sql = "SELECT tblclientes.idClientes as idCliente, tblsexo.descricacao as sexo, tblClientes.nome as nome, tblclientes.email as email, tblendereco.uf as uf, tblendereco.cidade as cidade, tblendereco.bairro as bairro, 
    tblendereco.rua as rua, tblendereco.numero as numero, tblendereco.complemento as complemento, 
    tblendereco.cep as CEP, tblclientes.telefone as telefone, date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade, tblclientes.foto as foto
    FROM tblsexo inner join tblclientes
    on tblsexo.idSexo = tblclientes.idSexo
    left join tblendereco 
    on tblendereco.idEndereco = tblclientes.idEndereco 
    WHERE tblclientes.idClientes = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idClientes = $id;
      $this->idSexo = $resultado->sexo;
      $this->idEndereco = ["uf" => $resultado->uf, "cidade" =>  $resultado->cidade, "bairro" => $resultado->bairro, "rua" =>  $resultado->rua, "numero" => $resultado->numero, "complemento" => $resultado->complemento, "CEP" => $resultado->CEP];
      $this->nome = $resultado->nome;
      $this->email = $resultado->email;
      $this->telefone = $resultado->telefone;
      $this->dataNascimento = $resultado->dataNascimento;
      $this->idade = $resultado->idade;
      $this->foto = $resultado->foto;
      return $this;
    }else{
      return [];
    }
  }

  public function inserirCliente(){
    $selectIdEndereco = "SELECT idEndereco FROM tblendereco ORDER BY 1 DESC LIMIT 1;";
    $stmt = Model::getConn()->prepare($selectIdEndereco);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idEndereco = $resultado->idEndereco;
    }

    $sql = "INSERT into tblClientes (idSexo, idEndereco, nome, email, senha, telefone, dataNascimento, foto) 
    values (:idSexo, :idEndereco, :nome, :email, :senha, :telefone, :dataNascimento, :foto);";
    $stmt = Model::getConn()->prepare($sql);
    
    $stmt->bindValue(':idSexo', $this->idSexo);
    $stmt->bindValue(':idEndereco', $this->idEndereco);
    $stmt->bindValue(':nome', $this->nome);
    $stmt->bindValue(':email', $this->email);
    $stmt->bindValue(':senha', $this->senha);
    $stmt->bindValue(':telefone', $this->telefone);
    $stmt->bindValue(':dataNascimento', $this->dataNascimento);
    $stmt->bindValue(':foto', $this->foto);
    if($stmt->execute()){
      $this->id = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      return false;
    }
  }

  public function atualizar(){
    $sql = "UPDATE tblclientes SET idSexo = :idSexo, idEndereco = :idEndereco, nome = :nome, email = :email, senha = :senha, telefone = :telefone, dataNascimento = :dataNascimento, foto = :foto WHERE idClientes = :id;";
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

  public function deletar(){
    $sql = "DELETE FROM tblClientes WHERE idClientes = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $this->idClientes);
    return $stmt->execute();
  }
}