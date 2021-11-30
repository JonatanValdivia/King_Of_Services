<?php

use App\Core\Controller;

Class Sexos extends Controller{

  public function index(){
    $modelSexo = $this->model("Sexo");
    $dados = $modelSexo->listarTodosOsSexos();
    echo json_encode($dados);
  }

  public function store(){
    $json = file_get_contents("php://input");
    $modelSexo = $this->model("Sexo");
    $dadosInsercao = json_decode($json);
    $modelSexo->sigla = $dadosInsercao->sigla;
    $modelSexo->descricao = $dadosInsercao->sigla;
    $modelSexo->criarSexo();
    return $modelSexo;
  }

}