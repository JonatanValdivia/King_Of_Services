<?php

use App\Core\Model;
//
Class Prestador{

  public $idPrestador;
  public $idProfissao;
  public $idSexo;
  public $nome;
  public $primeiroNome;
  public $email;
  public $senha;
  public $sexo;
  public $profissao;
  public $idEndereco;
  public $uf;
  public $cidade;
  public $bairro;
  public $rua;
  public $numero;
  public $complemento;
  public $cep;
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
    on tblprofissao.idprofissao = tblprestadores.idProfissao;";
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
    SUBSTRING_INDEX(tblprestadores.nome, ' ', 1) AS primeironome,
    tblsexo.descricao as sexo, 
    tblsexo.idSexo as idSexo,
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
    YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
    tblprestadores.email as email,
    tblprestadores.telefone as telefone,
    tblEnderecoPrestadores.idEnderecoPrestador as idEndereco,
    tblEnderecoPrestadores.uf as uf, 
    tblEnderecoPrestadores.cidade as cidade, 
    tblEnderecoPrestadores.bairro as bairro, 
    tblEnderecoPrestadores.rua as rua, 
    tblEnderecoPrestadores.numero as numero, 
    tblEnderecoPrestadores.complemento as complemento, 
    tblEnderecoPrestadores.cep as CEP,
    tblprofissao.nomeProfissao as profissao,
    tblProfissao.idProfissao as idProfissao,
    tblprestadores.descricao as descricao,
    tblPrestadores.foto as foto
    from tblprestadores 
    inner join tblsexo
    on tblsexo.idSexo = tblprestadores.idSexo
    inner join tblEnderecoPrestadores
    on tblprestadores.idPrestador = tblEnderecoPrestadores.idPrestador
    inner join tblprofissao
    on tblprofissao.idprofissao = tblprestadores.idProfissao
    where tblprestadores.idPrestador = :id;";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idPrestador = $resultado->idPrestador;
      $this->sexo = $resultado->sexo;
      $this->idSexo = $resultado->idSexo;
      $this->idEndereco = $resultado->idEndereco;
      $this->uf = $resultado->uf;
      $this->cidade = $resultado->cidade;
      $this->bairro = $resultado->bairro;
      $this->rua = $resultado->rua;
      $this->numero = $resultado->numero;
      $this->complemento = $resultado->complemento;
      $this->cep = $resultado->CEP;
      $this->profissao = $resultado->profissao;
      $this->idProfissao = $resultado->idProfissao;
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
      $sql = "INSERT INTO tblPrestadores (idProfissao, idSexo, nome, email, senha, descricao, telefone, dataNascimento, foto) VALUES (:idProfissao, :idSexo, :nome, :email, :senha, :descricao, :telefone, :dataNascimento, :foto)";

      $stmt = Model::getConn()->prepare($sql);
      $stmt->bindValue(":idProfissao", $this->idProfissao);
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
        return $this;
      }else{
        return false;
      }
    } 
  }
  
  public function atualizar(){

    $sql = "UPDATE tblprestadores set idProfissao = :idProfissao, idSexo = :idSexo, nome = :nome, email = :email, descricao = :descricao, telefone = :telefone, dataNascimento = :dataNascimento
    where idPrestador = :idPrestador;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":idProfissao", $this->idProfissao);
    $stmt->bindValue(":idSexo", $this->idSexo);
    $stmt->bindValue(":nome", $this->nome);
    $stmt->bindValue(":email", $this->email);
    // $stmt->bindValue(":senha", password_hash($this->senha, PASSWORD_DEFAULT));
    $stmt->bindValue(":descricao", $this->descricao);
    $stmt->bindValue(":telefone", $this->telefone);
    $stmt->bindValue(":dataNascimento", $this->dataNascimento);
    $stmt->bindValue(":idPrestador", $this->idPrestador);

    if($stmt->execute()){
      return $this;
    }else{
      return false;
    }
  }

  public function atualizarFoto(){

    $sql = "UPDATE tblprestadores set foto = :foto
    where idPrestador = :idPrestador;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":foto", $this->foto);
    $stmt->bindValue(":idPrestador", $this->idPrestador);

    if($stmt->execute()){
      return $this;
    }else{
      return false;
    }
  }

  public function pesquisarProfissao($profissao){
    $sql = "SELECT tblprestadores.idPrestador as idPrestador,
    tblprestadores.nome as nome, 
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
	  YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
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
    tblprofissao.nomeProfissao as nomeProfissao,
    tblPrestadores.descricao as descricao,
    tblPrestadores.foto as foto
    from tblprestadores left join tblprofissao
	  on tblprofissao.idProfissao = tblPrestadores.idProfissao
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
    $sql = "SELECT idPrestador, nome, SUBSTRING_INDEX(nome, ' ', 1) AS primeiroNome, email, senha, foto from tblPrestadores where email = :email;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":email", $this->email);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      if(!password_verify($this->senha, $resultado->senha) || $this->email != $resultado->email){
        return false;
      }else{
        $this->idPrestador = $resultado->idPrestador;
        $this->nome = $resultado->nome;
        $this->primeiroNome = $resultado->primeiroNome;
        $this->senha = password_hash($resultado->senha, PASSWORD_DEFAULT);
        $this->foto = $resultado->foto;
        return $this;
        
      }
    }else{
      return false;
    }
  }
}