<?php

use App\Core\Model;

Class Solicitacao{

  public $idServicoPrestador;
  public $idPrestador;
  public $idCliente;
  public $descricao;
  public $statusServico;
  public $nome;
  public $idade;
  public $foto;
  public $criado;
  public $atualizado;

  //Métodos do prestador

  public function buscarPeloIdDaSolicitacao($id){
    $sql = "SELECT idServicoPrestador,
    idPrestador, 
    idCliente, 
    descricao, 
    statusServico 
    from tblservicosprestador 
    where idServicoPrestador = :id;";

    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
      $this->idServicoPrestador = $resultado->idServicoPrestador;
      $this->idPrestador = $resultado->idPrestador;
      $this->idCliente = $resultado->idCliente;
      $this->descricao = $resultado->descricao;
      $this->statusServico = $resultado->statusServico;
      return $this;
    }else{
      return [];
    }
  }

  public function listarSolicitacoesDeClientesPeloIdDoPrestador($id){
    $sql = "SELECT tblServicosPrestador.idServicoPrestador, 
    tblServicosPrestador.idPrestador,
    tblServicosPrestador.idCliente, 
    tblServicosPrestador.descricao, 
    tblServicosPrestador.statusServico,
    date_format(tblServicosPrestador.criado, '%d/%m/%Y') as criado,
    date_format(tblServicosPrestador.criado, '%H:%i:%S') as criadoHora,
    tblclientes.nome,
    YEAR(CURDATE()) - YEAR(tblclientes.dataNascimento) as idade,
    tblclientes.foto
    from tblservicosprestador inner join tblClientes
    on tblServicosPrestador.idCliente = tblClientes.idCliente
    where idPrestador = :id and tblServicosPrestador.statusServico = 'aceitar';";

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

  public function AndamentoPrestador($id){
    $sql = "SELECT tblServicosPrestador.idServicoPrestador, 
    tblServicosPrestador.idPrestador,
    tblServicosPrestador.idCliente, 
    tblServicosPrestador.descricao, 
    tblServicosPrestador.statusServico,
    date_format(tblServicosPrestador.criado, '%d/%m/%Y') as criado,
    date_format(tblServicosPrestador.criado, '%H:%i:%S') as criadoHora,
     date_format(tblServicosPrestador.atualizado, '%d/%m/%Y') as atualizado,
    date_format(tblServicosPrestador.atualizado, '%H:%i:%S') as atualizadoHora,
    tblclientes.nome,
    YEAR(CURDATE()) - YEAR(tblclientes.dataNascimento) as idade,
    tblclientes.foto
    from tblservicosprestador inner join tblClientes
    on tblServicosPrestador.idCliente = tblClientes.idCliente
    where idPrestador = :id and tblServicosPrestador.statusServico = 'pendente';";

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

  public function ConcluidoPrestador($id){
    $sql = "SELECT tblServicosPrestador.idServicoPrestador, 
    tblServicosPrestador.idPrestador,
    tblServicosPrestador.idCliente, 
    tblServicosPrestador.descricao, 
    tblServicosPrestador.statusServico,
    date_format(tblServicosPrestador.criado, '%d/%m/%Y') as criado,
    date_format(tblServicosPrestador.criado, '%H:%i:%S') as criadoHora,
     date_format(tblServicosPrestador.atualizado, '%d/%m/%Y') as atualizado,
    date_format(tblServicosPrestador.atualizado, '%H:%i:%S') as atualizadoHora,
    tblclientes.nome,
    YEAR(CURDATE()) - YEAR(tblclientes.dataNascimento) as idade,
    tblclientes.foto
    from tblservicosprestador inner join tblClientes
    on tblServicosPrestador.idCliente = tblClientes.idCliente
    where idPrestador = :id and tblServicosPrestador.statusServico = 'concluido';";

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

  public function atualizarsolicitacaoServicoAceitar_andamento(){
    $sql = "UPDATE tblservicosprestador set statusServico = 'pendente' where idServicoPrestador = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $this->idServicoPrestador);

    if($stmt->execute()){
      return $this;
    }else{
      return false;
    }
  }

  public function atualizarsolicitacaoServicoAndamento_concluido(){
    $sql = "UPDATE tblservicosprestador set statusServico = 'concluido' where idServicoPrestador = :id;";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':id', $this->idServicoPrestador);

    if($stmt->execute()){
      return $this;
    }else{
      return false;
    }
  }

  //Métodos do cliente

  public function criarSolicitacaoDoClienteParaOPrestador(){
    $sql = "INSERT into tblServicosPrestador (idPrestador, idCliente, descricao, StatusServico) values 
    (:idPrestador, :idCliente, :descricao, :statusServico);";
    $stmt = Model::getConn()->prepare($sql);
    $stmt->bindValue(':idPrestador', $this->idPrestador);
    $stmt->bindValue(':idCliente', $this->idCliente);
    $stmt->bindValue(':descricao', $this->descricao);
    $stmt->bindValue(':statusServico', $this->statusServico);
    if($stmt->execute()){
      $this->idServicoPrestador = Model::getConn()->lastInsertId();
      echo json_encode($this);
      return $this;
    }else{
      return false;
    }
  }

  public function visualizarAceitacaoCliente($id){
    $sql = "SELECT tblServicosPrestador.idServicoPrestador, 
    tblServicosPrestador.idPrestador,
    tblServicosPrestador.idCliente, 
    tblServicosPrestador.descricao, 
    tblServicosPrestador.statusServico,
    date_format(tblServicosPrestador.criado, '%d/%m/%Y') as criado,
    date_format(tblServicosPrestador.criado, '%H:%i:%S') as criadoHora,
     date_format(tblServicosPrestador.atualizado, '%d/%m/%Y') as atualizado,
    date_format(tblServicosPrestador.atualizado, '%H:%i:%S') as atualizadoHora,
    tblprestadores.nome,
    tblprofissao.nomeProfissao,
    YEAR(CURDATE()) - YEAR(tblprestadores.dataNascimento) as idade,
    tblprestadores.foto
    from tblservicosprestador inner join tblprestadores
    on tblServicosPrestador.idPrestador = tblprestadores.idPrestador
    inner join tblprofissao on tblprestadores.idprofissao = tblprofissao.idprofissao
    where idCliente = :id and tblServicosPrestador.statusServico = 'aceitar';";

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

  public function visualizarPendenteCliente($id){
    $sql = "SELECT tblServicosPrestador.idServicoPrestador, 
    tblServicosPrestador.idPrestador,
    tblServicosPrestador.idCliente, 
    tblServicosPrestador.descricao, 
    tblServicosPrestador.statusServico,
    date_format(tblServicosPrestador.criado, '%d/%m/%Y') as criado,
    date_format(tblServicosPrestador.criado, '%H:%i:%S') as criadoHora,
     date_format(tblServicosPrestador.atualizado, '%d/%m/%Y') as atualizado,
    date_format(tblServicosPrestador.atualizado, '%H:%i:%S') as atualizadoHora,
    tblprestadores.nome,
    tblprofissao.nomeProfissao,
    YEAR(CURDATE()) - YEAR(tblprestadores.dataNascimento) as idade,
    tblprestadores.foto
    from tblservicosprestador inner join tblprestadores
    on tblServicosPrestador.idPrestador = tblprestadores.idPrestador
    inner join tblprofissao on tblprestadores.idprofissao = tblprofissao.idprofissao
    where idCliente = :id and tblServicosPrestador.statusServico = 'pendente';";

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

  public function visualizarConcluidoCliente($id){
    $sql = "SELECT tblServicosPrestador.idServicoPrestador, 
    tblServicosPrestador.idPrestador,
    tblServicosPrestador.idCliente, 
    tblServicosPrestador.descricao, 
    tblServicosPrestador.statusServico,
    date_format(tblServicosPrestador.criado, '%d/%m/%Y') as criado,
    date_format(tblServicosPrestador.criado, '%H:%i:%S') as criadoHora,
     date_format(tblServicosPrestador.atualizado, '%d/%m/%Y') as atualizado,
    date_format(tblServicosPrestador.atualizado, '%H:%i:%S') as atualizadoHora,
    tblprestadores.nome,
    tblprofissao.nomeProfissao,
    YEAR(CURDATE()) - YEAR(tblprestadores.dataNascimento) as idade,
    tblprestadores.foto
    from tblservicosprestador inner join tblprestadores
    on tblServicosPrestador.idPrestador = tblprestadores.idPrestador
    inner join tblprofissao on tblprestadores.idprofissao = tblprofissao.idprofissao
    where idCliente = :id and tblServicosPrestador.statusServico = 'concluido';";

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

  
}