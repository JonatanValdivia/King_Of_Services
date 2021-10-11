<?php
//
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

  public function store(){
    $json = file_get_contents("php://input");
    $modelPrestador = $this->model("Prestador");
    $dadosInsercao = json_decode($json);
    $modelPrestador->idSexo = $dadosInsercao->idSexo;
    $modelPrestador->idProfissao = $dadosInsercao->idProfissao;
    $modelPrestador->nome = $dadosInsercao->nome;
    $modelPrestador->email = $dadosInsercao->email;
    $modelPrestador->senha = $dadosInsercao->senha;
    $modelPrestador->telefone = $dadosInsercao->telefone;
    $modelPrestador->dataNascimento = $dadosInsercao->dataNascimento;
    $modelPrestador->foto = $dadosInsercao->foto;
    $modelPrestador->criarPrestador();
    return $modelPrestador;
    
  }

  public function update($id){
    $json = file_get_contents("php://input");
    $modelPrestador = $this->model("Prestador");
    $modelPrestador->procurarPorId($id);
    if(!$modelPrestador){
      http_response_code(404);
      $erro = ["erro" => "Cliente não encontrado"];
      echo json_encode($erro);
      exit;
    }
    $dadosEdicao = json_decode($json);
    $modelPrestador->idSexo = $dadosEdicao->idSexo;
    $modelPrestador->nome = $dadosEdicao->nome;
    $modelPrestador->email = $dadosEdicao->email;
    $modelPrestador->senha = $dadosEdicao->senha;
    $modelPrestador->telefone = $dadosEdicao->telefone;
    $modelPrestador->dataNascimento = $dadosEdicao->dataNascimento;
    $modelPrestador->foto = $dadosEdicao->foto;
    if($modelPrestador->atualizar()){
      http_response_code(204);
    }else{
      http_response_code(500);
      $erro = ["erro" => "Problemas ao editar o cliente"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }
    return $modelPrestador;

  }

  public function delete($id){
    $modelPrestador = $this->model("Prestador");
    $modelPrestador->procurarPorId($id);
    if(!$modelPrestador){
      http_response_code(404);
      $erro = ["erro" => "Cliente não encontrado"];
      echo json_encode($erro);  
    }
    if($modelPrestador->deletar()){
      http_response_code(204);
    }else{
      http_response_code(500);
      $erro = ["erro" => "Problemas ao deletar cliente"];
      echo json_encode($erro);
    }
    $modelPrestador = $modelPrestador->deletar();
  }

}