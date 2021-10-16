<?php

use App\Core\Model;
//
class Cliente{

  public $idCliente;
  public $idSexo;
  public $nome;
  public $email;
  public $senha;
  public $telefone;
  public $Endereco;
  public $dataNascimento;
  public $idade;
  public $foto;

  public function listarTodos(){

    $slq = "SELECT tblclientes.idCliente, 
    tblclientes.nome,
    tblsexo.descricao as sexo,  
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
    tblclientes.email, 
    tblclientes.senha, 
    tblclientes.telefone, 
    tblEnderecoClientes.uf as uf, 
    tblEnderecoClientes.cidade as cidade, 
    tblEnderecoClientes.bairro as bairro, 
    tblEnderecoClientes.rua as rua, 
    tblEnderecoClientes.numero as numero, 
    tblEnderecoClientes.complemento as complemento, 
    tblEnderecoClientes.cep as CEP,
    tblclientes.foto from tblclientes inner join tblSexo on
    tblclientes.idSexo = tblsexo.idSexo
    inner join tblenderecoclientes on 
    tblenderecoclientes.idCliente = tblclientes.idCliente;";

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
    $sql = "SELECT tblclientes.idCliente, 
    tblclientes.nome,
    tblsexo.descricao as sexo,  
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
    tblclientes.email, 
    tblclientes.telefone, 
    tblEnderecoClientes.uf as uf, 
    tblEnderecoClientes.cidade as cidade, 
    tblEnderecoClientes.bairro as bairro, 
    tblEnderecoClientes.rua as rua, 
    tblEnderecoClientes.numero as numero, 
    tblEnderecoClientes.complemento as complemento, 
    tblEnderecoClientes.cep as CEP,
    tblclientes.foto from tblclientes inner join tblSexo on
    tblclientes.idSexo = tblsexo.idSexo
    inner join tblenderecoclientes on 
    tblenderecoclientes.idCliente = tblclientes.idCliente
    where tblClientes.idCliente = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idCliente = $resultado->idCliente;
      $this->idSexo = $resultado->sexo;
      $this->Endereco = ["uf" => $resultado->uf, "cidade" =>  $resultado->cidade, "bairro" => $resultado->bairro, "rua" =>  $resultado->rua, "numero" => $resultado->numero, "complemento" => $resultado->complemento, "CEP" => $resultado->CEP];
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

    $sql = "SELECT idCliente from tblclientes where email = :e";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":e", $this->email);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $erro = ["Erro" => "Esse email já está cadastrado"];
      echo json_encode($erro);
      return false;
    }else{
      $sql = "INSERT into tblclientes (idSexo, nome, email, senha, telefone, dataNascimento, foto) values 
      (:idSexo, :nome, :email, :senha, :telefone, :dataNascimento, :foto);";
      $stmt = Model::getConn()->prepare($sql);
      
      $stmt->bindValue(':idSexo', $this->idSexo);
      $stmt->bindValue(':nome', $this->nome);
      $stmt->bindValue(':email', $this->email);
      $stmt->bindValue(':senha', password_hash($this->senha, PASSWORD_DEFAULT));
      $stmt->bindValue(':telefone', $this->telefone);
      $stmt->bindValue(':dataNascimento', $this->dataNascimento);
      $stmt->bindValue(':foto', $this->foto);
      if($stmt->execute()){
        $this->idCliente = Model::getConn()->lastInsertId();
        echo json_encode($this);
        return $this;
      }else{
        return false;
      }
    }

    
  }

  public function atualizar(){
    $sql = "UPDATE tblclientes set idSexo = :idSexo, nome = :nome, email = :email, senha = :senha, telefone = :telefone, dataNascimento = :dataNascimento, foto = :foto where idCliente = :idCliente;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':idSexo', $this->idSexo);
    $stmt->bindValue(':nome', $this->nome);
    $stmt->bindValue(':email', $this->email);
    $stmt->bindValue(':senha', password_hash($this->senha, PASSWORD_DEFAULT));
    $stmt->bindValue(':telefone', $this->telefone);
    $stmt->bindValue(':dataNascimento', $this->dataNascimento);
    $stmt->bindValue(':foto', $this->foto);
    $stmt->bindValue(':idCliente', $this->idCliente);

    return $stmt->execute();

  }

  public function deletar(){
    $sql = "DELETE FROM tblClientes WHERE idCliente = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $this->idCliente);
    return $stmt->execute();
  }

  public function loginCliente(){
    $sql = "SELECT * from tblClientes where email = :email;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":email", $this->email);
    $stmt->execute();
    
    if($stmt->rowCount() > 0){
     
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      // echo json_encode($resultado);
      if(!password_verify($this->senha, $resultado->senha) || $this->email != $resultado->email){
        return false;
      }else{
        $this->idCliente = $resultado->idCliente;
        $this->senha = password_hash($resultado->senha, PASSWORD_DEFAULT);
        return $this;
      }
    }else{
      return false;
    }
  }
}