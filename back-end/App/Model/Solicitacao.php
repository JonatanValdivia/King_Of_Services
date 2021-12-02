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

  //Métodos do prestador

  public function listarSolicitacoesDeClientesPeloIdDoPrestador($id){
    $sql = "SELECT tblServicosPrestador.idServicoPrestador, 
    tblServicosPrestador.idPrestador,
    tblServicosPrestador.idCliente, 
    tblServicosPrestador.descricao, 
    tblServicosPrestador.statusServico,
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