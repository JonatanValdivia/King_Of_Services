<?php

use App\Core\Controller;

class EnderecosClientes extends Controller{
  
  public function index(){
    $modelEnderecoCLiente = $this->model("EnderecoCLiente");
    $dados = $modelEnderecoCLiente->listarTodosEnderecosCLientes();
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    return $dados;
  }

  public function find($id){
    $modelEnderecoCLiente = $this->model("EnderecoCliente");
    $dado = $modelEnderecoCLiente->buscarEnderecoCLientePeloId($id);
    if($dado){
      echo json_encode($dado, JSON_UNESCAPED_UNICODE);
    }else{
      http_response_code(404);
      $erro = ["Erro" => "Endereço do cliente não encontrado"];
      echo json_encode($erro);
    }
    return $dado;
  }

  public function store(){
    $json = file_get_contents("php://input");
    $dadosInsercao = json_decode($json);
    $modelEnderecoCLiente = $this->model("EnderecoCliente");
    $modelEnderecoCLiente->idCliente = $dadosInsercao->idCliente;
    $modelEnderecoCLiente->uf = $dadosInsercao->uf;
    $modelEnderecoCLiente->cidade = $dadosInsercao->cidade;
    $modelEnderecoCLiente->bairro = $dadosInsercao->bairro;
    $modelEnderecoCLiente->rua = $dadosInsercao->rua;
    $modelEnderecoCLiente->numero = $dadosInsercao->numero;
    $modelEnderecoCLiente->complemento = $dadosInsercao->complemento;
    $modelEnderecoCLiente->cep = $dadosInsercao->cep;
    $modelEnderecoCLiente->inserirEnderecoCliente();
    return $modelEnderecoCLiente;
  }

  public function update($id){
    $json = file_get_contents("php://input");
    $dadosEdicao = json_decode($json);
    $modelEnderecoCLiente = $this->model("EnderecoCliente");
    $modelEnderecoCLiente->buscarEnderecoCLientePeloId($id);
    if(!$modelEnderecoCLiente){
      http_response_code(404);
      $erro = ["erro" => "Cliente não encontrado"];
      echo json_encode($erro);
      exit;
    }
    $modelEnderecoCLiente->idCliente = $dadosEdicao->idCliente;
    $modelEnderecoCLiente->uf = $dadosEdicao->uf;
    $modelEnderecoCLiente->cidade = $dadosEdicao->cidade;
    $modelEnderecoCLiente->bairro = $dadosEdicao->bairro;
    $modelEnderecoCLiente->rua = $dadosEdicao->rua;
    $modelEnderecoCLiente->numero = $dadosEdicao->numero;
    $modelEnderecoCLiente->complemento = $dadosEdicao->complemento;
    $modelEnderecoCLiente->cep = $dadosEdicao->cep;
   if($modelEnderecoCLiente->updateEnderecoCliente()){
    http_response_code(204);
   }else{
    http_response_code(500);
    $erro = ["erro" => "Problemas ao editar o cliente"];
    echo json_encode($erro, JSON_UNESCAPED_UNICODE);
   }
  }

  public function delete($id){
    $modelEnderecoCLiente = $this->model("EnderecoCliente");
    $modelEnderecoCLiente->buscarEnderecoCLientePeloId($id);
    if(!$modelEnderecoCLiente){
      http_response_code(404);
      $erro = ["erro" => "Endereço de cliente não encontrado"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
      exit;
    }
    if($modelEnderecoCLiente->deletarEnderecoCliente()){
      http_response_code(204);
    }else{
      http_response_code(500);
      $erro = ["erro" => "Problemas ao deletar cliente"];
      echo json_encode($erro);
    }
    
  }
}