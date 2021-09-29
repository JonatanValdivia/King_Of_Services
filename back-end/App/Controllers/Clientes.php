<?php

use App\Core\Controller;

Class Clientes extends Controller{
  public $id;
  public $idEndereco;
  public $idSexo;
  public $nome;

  public function index(){
    $modelClientes = $this->model("Cliente");
    $dados = $modelClientes->listarTodos();
    echo "<pre>";
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    echo "</pre>";
    return $dados;
  }

  public function find(){
    echo "Teste";
  }
}