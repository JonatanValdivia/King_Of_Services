<?php

use App\Core\Model;
//
Class Prestador{

  public $idPrestador;
  public $idSexo;
  public $nome;
  public $email;
  public $senha;
  public $Endereco;
  public $descricao;
  public $telefone;
  public $dataNascimento;
  public $foto;

  public function listarTodos(){
    $sql = "SELECT tblprestadores.idPrestador as idPrestador,
    tblprestadores.nome as nome,
    tblsexo.descricao as sexo, 
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
    tblprestadores.email as email,
    tblprestadores.telefone as telefone,
    tblEnderecoPrestadores.uf as uf, 
    tblEnderecoPrestadores.cidade as cidade, 
    tblEnderecoPrestadores.bairro as bairro, 
    tblEnderecoPrestadores.rua as rua, 
    tblEnderecoPrestadores.numero as numero, 
    tblEnderecoPrestadores.complemento as complemento, 
    tblEnderecoPrestadores.cep as CEP,
    tblprofissao.nomeProfissao as profissao,
    tblprestadores.descricao as descricao,
    tblPrestadores.foto as foto
    from tblprestadores 
    inner join tblsexo
    on tblsexo.idSexo = tblprestadores.idSexo
    inner join tblEnderecoPrestadores
    on tblprestadores.idPrestador = tblEnderecoPrestadores.idPrestador
    inner join tblprofissao
    on tblprestadores.idPrestador = tblprofissao.idPrestador;";
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
    $sql = "SELECT tblprestadores.idPrestador as idPrestador,
    tblprestadores.nome as nome,
    tblsexo.descricao as sexo, 
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
    tblprestadores.email as email,
    tblprestadores.telefone as telefone,
    tblEnderecoPrestadores.uf as uf, 
    tblEnderecoPrestadores.cidade as cidade, 
    tblEnderecoPrestadores.bairro as bairro, 
    tblEnderecoPrestadores.rua as rua, 
    tblEnderecoPrestadores.numero as numero, 
    tblEnderecoPrestadores.complemento as complemento, 
    tblEnderecoPrestadores.cep as CEP,
    tblprofissao.nomeProfissao as profissao,
    tblprestadores.descricao as descricao,
    tblPrestadores.foto as foto
    from tblprestadores 
    inner join tblsexo
    on tblsexo.idSexo = tblprestadores.idSexo
    inner join tblEnderecoPrestadores
    on tblprestadores.idPrestador = tblEnderecoPrestadores.idPrestador
    inner join tblprofissao
    on tblprestadores.idPrestador = tblprofissao.idPrestador
    where tblprestadores.idPrestador = :id;";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idPrestador = $resultado->idPrestador;
      $this->idSexo = $resultado->sexo;
      $this->Endereco = ["uf" => $resultado->uf, "cidade" =>  $resultado->cidade, "bairro" => $resultado->bairro, "rua" =>  $resultado->rua, "numero" => $resultado->numero, "complemento" => $resultado->complemento, "CEP" => $resultado->CEP];
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

    $sql = "SELECT idPrestador from tblPrestadores where email = :e";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":e", $this->email);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $erro = ["Erro" => "Esse email já está cadastrado"];
      echo json_encode($erro);
      return false;
    }else{
      $sql = "INSERT INTO tblPrestadores (idSexo, nome, email, senha, descricao, telefone, dataNascimento, foto) VALUES (:idSexo, :nome, :email, :senha, :descricao, :telefone, :dataNascimento, :foto)";

      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindValue(":idSexo", $this->idSexo);
      $stmt->bindValue(":nome", $this->nome);
      $stmt->bindValue(":email", $this->email);
      $stmt->bindValue(":senha", password_hash($this->senha, PASSWORD_DEFAULT));
      $stmt->bindValue(":descricao", $this->descricao);
      $stmt->bindValue(":telefone", $this->telefone);
      $stmt->bindValue(":dataNascimento", $this->dataNascimento);
      $stmt->bindValue(":foto", $this->foto);

      if($stmt->execute()){
        $this->idPrestador = Model::getConn()->lastInsertId();
        echo json_encode($this);
        return $this;
      }else{
        return false;
      }
    }

    
  }
  
  public function atualizar(){
    $sql = "UPDATE tblprestadores set idSexo = :idSexo, nome = :nome, email = :email, senha = :senha, descricao = :descricao, telefone = :telefone, dataNascimento = :dataNascimento, foto = :foto
    where idPrestador = :idPrestador;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idSexo", $this->idSexo);
    $stmt->bindValue(":nome", $this->nome);
    $stmt->bindValue(":email", $this->email);
    $stmt->bindValue(":senha", password_hash($this->senha, PASSWORD_DEFAULT));
    $stmt->bindValue(":descricao", $this->descricao);
    $stmt->bindValue(":telefone", $this->telefone);
    $stmt->bindValue(":dataNascimento", $this->dataNascimento);
    $stmt->bindValue(":foto", $this->foto);
    $stmt->bindValue(":idPrestador", $this->idPrestador);

    if($stmt->execute()){
      return $this;
    }else{
      return false;
    }
  }


  public function pesquisarProfissao($profissao){
    $sql = "SELECT tblprestadores.nome as nome, 
    tblprestadores.dataNascimento as dataNascimento, 
    tblsexo.descricao as sexo,
    tblEnderecoPrestadores.uf as estado,
    tblEnderecoPrestadores.cidade as cidade,
    tblEnderecoPrestadores.bairro as bairro, 
    tblEnderecoPrestadores.rua as rua, 
    tblEnderecoPrestadores.numero as numero, 
    tblEnderecoPrestadores.complemento as complemento,
    tblEnderecoPrestadores.cep as CEP, 
    tblprestadores.email as email,
    tblprestadores.telefone as Telefone,
    tblprofissao.nomeProfissao as nomeProfissao
    from tblprestadores left join tblprofissao
	on tblprestadores.idPrestador = tblprofissao.idPrestador
    left join tblEnderecoPrestadores 
    on tblprestadores.idPrestador = tblEnderecoPrestadores.idPrestador
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
    $sql = "DELETE FROM tblPrestadores WHERE idPrestador = :id";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $this->idPrestador);
    return $stmt->execute();
  }

  public function loginPrestador(){
    $sql = "SELECT * from tblPrestadores where email = :email;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":email", $this->email);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      if(!password_verify($this->senha, $resultado->senha) || $this->email != $resultado->email){
        return false;
      }else{
        $this->idPrestador = $resultado->idPrestador;
        $this->senha = password_hash($resultado->senha, PASSWORD_DEFAULT);
        return $this;
      }
    }else{
      return false;
    }
  }
}