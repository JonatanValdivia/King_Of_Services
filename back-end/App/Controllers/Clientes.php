<?php

use App\Core\Controller;

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
    //Conversão da data
    $data = explode('/', $dadosInsercao->dataNascimento);
    $conversaoDaData = $data[2].'-'.$data[1].'-'.$data[0];
    $modelCliente->dataNascimento = $conversaoDaData;

    $modelCliente->foto = $dadosInsercao->foto;
    $modelCliente->inserirCliente();
    //Endereco do cleinte
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
    $dadosEdicao = json_decode($json);

    $modelCliente->idSexo = $dadosEdicao->idSexo;
    $modelCliente->nome = $dadosEdicao->nome;
    $modelCliente->email = $dadosEdicao->email;
    $modelCliente->descricao = $dadosEdicao->descricao;
    $modelCliente->telefone = $dadosEdicao->telefone;
    //Conversão da data
    $data = explode('/', $dadosEdicao->dataNascimento);
    $conversaoDaData = $data[2].'-'.$data[1].'-'.$data[0];
    $modelCliente->dataNascimento = $conversaoDaData;
    
    $modelEnderecoCLiente = $this->model("EnderecoCliente");
    $modelEnderecoCLiente->idCliente = $id;
    $modelEnderecoCLiente->uf = $dadosEdicao->uf;
    $modelEnderecoCLiente->cidade = $dadosEdicao->cidade;
    $modelEnderecoCLiente->bairro = $dadosEdicao->bairro;
    $modelEnderecoCLiente->rua = $dadosEdicao->rua;
    $modelEnderecoCLiente->numero = $dadosEdicao->numero;
    $modelEnderecoCLiente->complemento = $dadosEdicao->complemento;
    $modelEnderecoCLiente->cep = $dadosEdicao->cep;

    if($modelCliente->atualizar() && $modelEnderecoCLiente->updateEnderecoCliente()){
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