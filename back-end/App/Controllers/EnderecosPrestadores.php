<?php

use App\Core\Controller;
//
Class EnderecosPrestadores extends Controller{

  public function index(){
    $modelEndereco = $this->model("EnderecoPrestador");
    $dados = $modelEndereco->listarTodos();
    echo json_encode($dados);
  }

  public function find($id){
    $modelEndereco = $this->model("EnderecoPrestador");
    $dados = $modelEndereco->buscarPorId($id);

    if($dados){
      echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }else{
      http_response_code(404);
      $erro = ["Erro" => "Endereço não encontrado"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }

    return $dados;
  }

  public function store(){
    $json = file_get_contents("php://input");
    $modelEnderecoPrestador = $this->model("EnderecoPrestador");
    $dadosinsercao = json_decode($json);
    $modelEnderecoPrestador->idPrestador = $dadosinsercao->idPrestador;
    $modelEnderecoPrestador->uf = $dadosinsercao->uf;
    $modelEnderecoPrestador->cidade = $dadosinsercao->cidade;
    $modelEnderecoPrestador->bairro = $dadosinsercao->bairro;
    $modelEnderecoPrestador->rua = $dadosinsercao->rua;
    $modelEnderecoPrestador->numero = $dadosinsercao->numero;
    $modelEnderecoPrestador->complemento = $dadosinsercao->complemento;
    $modelEnderecoPrestador->cep = $dadosinsercao->cep;
    $modelEnderecoPrestador->inserirEnderecoPrestador();
    return $modelEnderecoPrestador;

  }

  public function update($id){
    $json = file_get_contents("php://input");
    $modelEndereco = $this->model("EnderecoPrestador");
    $dadosEdicao = json_decode($json);
    $modelEndereco->uf = $dadosEdicao->uf;
    $modelEndereco->cidade = $dadosEdicao->cidade;
    $modelEndereco->bairro = $dadosEdicao->bairro;
    $modelEndereco->rua = $dadosEdicao->rua;
    $modelEndereco->numero = $dadosEdicao->numero;
    $modelEndereco->complemento = $dadosEdicao->complemento;
    $modelEndereco->cep = $dadosEdicao->cep;
    $modelEndereco->idEnderecoPrestador = $id;
    if($modelEndereco->atualizar()){
      http_response_code(204);
    }else{
      http_response_code(500);
      $erro = ["erro" => "Problemas ao editar o cliente"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }
    
  }

  public function delete($id){
    $modelEndereco = $this->model("EnderecoPrestador");
    $modelEndereco->buscarPorId($id);
    if(!$modelEndereco){
      http_response_code(404);
      $erro = ["Erro" => "Endereco não encontrado"];
      echo json_encode($erro);
    }else if($modelEndereco->deletar()){
      http_response_code(204);
      $mensagem = ["Sucesso!" => "Deleção efetuada com sucesso!"];
      echo json_encode($mensagem);
    }
  }

}