<?php

use App\Core\Controller;

Class Profissoes extends Controller{
  public function index(){
    $modelProfissao = $this->model("Profissao");
    $modelProfissao->listarTodasProfissoes();
  }

  public function find($id){
    $modelProfissao = $this->model("Profissao");
    $dado = $modelProfissao->buscarPorId($id);
    if(!$dado){
      http_response_code(404);
      $erro = ["Erro" => "Profissao não encontrada"];
      echo json_encode($erro);
    }else{
      echo json_encode($modelProfissao, JSON_UNESCAPED_UNICODE);
    }

    return $dado;
  }

  public function store(){
    $json = file_get_contents("php://input");
    $modelProfissao = $this->model("Profissao");
    $dadosInsercao = json_decode($json);
    $modelProfissao->nome = $dadosInsercao->nome;
    $modelProfissao->inserirProfissao();
    return $modelProfissao;
  }

  public function update($id){
    $json = file_get_contents("php://input");
    $modelProfissao = $this->model("Profissao");
    $modelProfissao->buscarPorId($id);
    if(!$modelProfissao){
      http_response_code(404);
      $erro = ["Erro" => "Profissão não encontrada"];
      echo json_encode($erro);
    }
    $dadosEdicao = json_decode($json);
    $modelProfissao->nome = $dadosEdicao->nome;
    $modelProfissao->atualizar();
  }

  public function delete(){

  }
}