<?php

use App\Core\Controller;
//
Class Clientes extends Controller{

  public function index(){
    $modelCliente = $this->model("Cliente");
    $dados = $modelCliente->listarTodos();
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
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

  public function store(){
    $json = file_get_contents("php://input");
    $dadosInsercao = json_decode($json);
    $modelCliente = $this->model('Cliente');
    $modelCliente->idSexo = $dadosInsercao->idSexo;
    $modelCliente->nome = $dadosInsercao->nome;
    $modelCliente->email = $dadosInsercao->email;
    $modelCliente->senha = $dadosInsercao->senha;
    $modelCliente->telefone = $dadosInsercao->telefone;
    $modelCliente->dataNascimento = $dadosInsercao->dataNascimento;
    $modelCliente->foto = $dadosInsercao->foto;
    $modelCliente->inserirCliente();

    $modelEnderecoCLiente = $this->model("EnderecoCliente");
    $modelEnderecoCLiente->idCliente = $modelCliente->idCliente;
    $modelEnderecoCLiente->uf = $dadosInsercao->uf;
    $modelEnderecoCLiente->cidade = $dadosInsercao->cidade;
    $modelEnderecoCLiente->bairro = $dadosInsercao->bairro;
    $modelEnderecoCLiente->rua = $dadosInsercao->rua;
    $modelEnderecoCLiente->numero = $dadosInsercao->numero;
    $modelEnderecoCLiente->complemento = $dadosInsercao->complemento;
    $modelEnderecoCLiente->cep = $dadosInsercao->cep;
    $modelEnderecoCLiente->inserirEnderecoCliente();
    return $modelCliente;
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

  public function delete($id){ 
    $modelCliente = $this->model("Cliente");
    $modelCliente->buscarPorId($id);
    if(!$modelCliente){
      http_response_code(404);
      $erro = ["erro" => "Cliente não encontrado"];
      echo json_encode($erro);  
    }
    if($modelCliente->deletar()){
      http_response_code(204);
    }else{
      http_response_code(500);
      $erro = ["erro" => "Problemas ao deletar cliente"];
      echo json_encode($erro);
    }
    $modelCliente = $modelCliente->deletar();
  }
}