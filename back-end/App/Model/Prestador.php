<?php

use App\Core\Model;
//
Class Prestador{

  public $idPrestadores;
  public $idSexo;
  public $idEndereco;
  public $idProfissao;
  public $nome;
  public $email;
  public $senha;
  public $descricao;
  public $telefone;
  public $dataNascimento;
  public $foto;

  public function listarTodos(){
    $sql = "SELECT tblPrestadores.idPrestadores as idPrestador, 
    tblsexo.descricacao as sexo, 
    tblPrestadores.nome as nome, 
    tblPrestadores.email as email, 
    tblPrestadores.descricao as descricao,
    tblendereco.uf as siglaEstado, 
    tblendereco.cidade as cidade, 
    tblendereco.bairro as bairro, 
    tblendereco.rua as rua, 
    tblendereco.numero as numero, 
    tblendereco.complemento as complemento, 
    tblendereco.cep as CEP, 
    tblPrestadores.telefone as telefone, 
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento,
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
    tblPrestadores.foto as foto
    FROM tblsexo inner join tblPrestadores
    on tblsexo.idSexo = tblPrestadores.idSexo
    left join tblendereco 
    on tblendereco.idEndereco = tblPrestadores.idEndereco;";
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
    $sql = "SELECT tblprestadores.idPrestadores as idPrestador, 
    tblsexo.descricacao as sexo, 
    tblprestadores.nome as nome,
    tblprestadores.email as email,
    tblPrestadores.descricao as descricao, 
    tblendereco.uf as uf, 
    tblendereco.cidade as cidade, 
    tblendereco.bairro as bairro, 
    tblendereco.rua as rua, 
    tblendereco.numero as numero, 
    tblendereco.complemento as complemento, 
    tblendereco.cep as CEP, 
    tblprestadores.telefone as telefone, 
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade, 
    tblprofissao.nomeProfissao as profissao, 
    tblprestadores.foto as foto
    FROM tblsexo inner join tblprestadores
    on tblsexo.idSexo = tblprestadores.idSexo
    left join tblendereco 
    on tblendereco.idEndereco = tblprestadores.idEndereco 
    left join tblprofissao
    on tblprofissao.idProfissao = tblprestadores.idProfissao
    WHERE tblprestadores.idPrestadores = :id;";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idPrestadores = $resultado->idPrestador;
      $this->idSexo = $resultado->sexo;
      $this->idEndereco = ["uf" => $resultado->uf, "cidade" =>  $resultado->cidade, "bairro" => $resultado->bairro, "rua" =>  $resultado->rua, "numero" => $resultado->numero, "complemento" => $resultado->complemento, "CEP" => $resultado->CEP];
      $this->idProfissao = $resultado->profissao;
      $this->nome = $resultado->nome;
      $this->descricao = $resultado->descricao;
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

  public function pesquisarProfissao($profissao){
    $sql = "SELECT tblprestadores.nome as nomePrestador, 
    tblprestadores.dataNascimento as dataNascimento, 
    tblsexo.descricacao as sexo,
    tblendereco.uf as estado,
    tblendereco.cidade as cidade,
    tblendereco.bairro as bairro, 
    tblendereco.rua as rua, 
    tblendereco.numero as numero, 
    tblendereco.complemento as complemento,
    tblendereco.cep as CEP, 
    tblprestadores.email as email,
    tblprestadores.telefone as Telefone,
    tblprofissao.nomeProfissao as nomeProfissao
    from tblprofissao left join tblprestadores
    on tblprofissao.idProfissao = tblprestadores.idProfissao
    left join tblendereco 
    on tblprestadores.idEndereco = tblendereco.idEndereco
    left join tblsexo
    on tblprestadores.idsexo = tblsexo.idsexo
    where tblprofissao.nomeProfissao like '%$profissao%';";

    $stmt = Model::getConn()->prepare($sql);
    // $stmt->bindValue(':profissao', $profissao);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);
      return $resultado;
    }else{
      return [];
    }

  }

  public function deletar(){
    $sql = "DELETE FROM tblPrestadores WHERE idPrestadores = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $this->idPrestadores);
    return $stmt->execute();
  }
  
}