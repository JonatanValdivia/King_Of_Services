<?php

use App\Core\Controller;

Class Prestadores extends Controller{
  public function index(){
    $modelPrestador = $this->model('Prestador');
    $dados = $modelPrestador->listarTodos();
    echo json_encode($dados);
  }

  public function find($id){
    $modelPrestador = $this->model('Prestador');
    $dado = $modelPrestador->procurarPorId($id);
    if($dado){
      echo json_encode($dado, JSON_UNESCAPED_UNICODE);
    }else{
      http_response_code(404);
      $erro = ["Erro" => "Cliente não encontrado."];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }
  }

}