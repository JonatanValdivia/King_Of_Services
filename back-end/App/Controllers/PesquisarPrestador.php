<?php
//
use App\Core\Controller;

Class PesquisarPrestador extends Controller{

  public function index(){
    echo "Busque aqui";
  }

  public function find($profissao){
    $modelPrestador = $this->model("Prestador");
    $dados = $modelPrestador->pesquisarProfissao($profissao);
    if($dados){
      http_response_code(200);
      echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }else{
      http_response_code(404);
      $erro = ["Erro" => "Não há cadastros dessa profissao"];
      echo json_encode($erro);
    }
  }
}