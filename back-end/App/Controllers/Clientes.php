<?php

use App\Core\Controller;

Class Clientes extends Controller{

  public function index(){
    $modelCliente = $this->model("Cliente");
    $dados = $modelCliente->listarTodos();
    echo "<pre>";
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    echo "</pre>";
    return $dados;
  }

  public function find($id){
    $modelCliente = $this->model("Cliente");
    $dado = $modelCliente->buscarPorId($id);
    if($dado){
      echo json_encode($dado, JSON_UNESCAPED_UNICODE);
    }else{
      http_response_code(404);
      $erro = ["Erro" => "Cliente não encontrado"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }
    return $dado;
  }

  public function update($id){
    $json = file_get_contents("php://input");
    $modelCliente = $this->model("Cliente");
    $dadosEdicao = json_decode($json);
    $modelCliente = $modelCliente->buscarPorId($id);

    if(!$modelCliente){
      http_response_code(404);
      $erro = ["erro" => "Cliente não encontrado"];
      echo json_encode($erro);
      exit;
    }

    $modelCliente->idSexo = $dadosEdicao->idSexo;
    $modelCliente->idEndereco = $dadosEdicao->idEndereco;
    $modelCliente->nome = $dadosEdicao->nome;
    $modelCliente->email = $dadosEdicao->email;
    $modelCliente->senha = $dadosEdicao->senha;
    $modelCliente->telefone = $dadosEdicao->telefone;
    $modelCliente->dataNascimento = $dadosEdicao->dataNascimento;
    $modelCliente->foto = $dadosEdicao->foto;

    if($modelCliente->atualizar()){
      http_response_code(204);
    }else{
      http_response_code(500);
      $erro = ["erro" => "Problemas ao editar o cliente"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }


  }
}