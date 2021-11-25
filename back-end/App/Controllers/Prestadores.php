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
    $file_chunks = explode(";base64,", $dadosInsercao->foto);
    $fileType = explode("image/", $file_chunks[0]);
    $image_type = $fileType[1];
    $base64Img = base64_decode($file_chunks[1]);
    $file = uniqid().'.'.$image_type;
    file_put_contents($file, $base64Img); 
    $modelPrestador->idProfissao = $dadosInsercao->idProfissao;
    $modelPrestador->idSexo = $dadosInsercao->idSexo;
    $modelPrestador->nome = $dadosInsercao->nome;
    $modelPrestador->email = $dadosInsercao->email;
    $modelPrestador->senha = $dadosInsercao->senha;
    $modelPrestador->descricao = $dadosInsercao->descricao;
    $modelPrestador->telefone = $dadosInsercao->telefone;
    $modelPrestador->dataNascimento = $dadosInsercao->dataNascimento;
    $modelPrestador->foto =  $file;
    $modelPrestador->criarPrestador();
    $modelEnderecoPrestador = $this->model("EnderecoPrestador");
    $modelEnderecoPrestador->idPrestador = $modelPrestador->idPrestador;
    $modelEnderecoPrestador->uf = $dadosInsercao->uf;
    $modelEnderecoPrestador->cidade = $dadosInsercao->cidade;
    $modelEnderecoPrestador->bairro = $dadosInsercao->bairro;
    $modelEnderecoPrestador->rua = $dadosInsercao->rua;
    $modelEnderecoPrestador->numero = $dadosInsercao->numero;
    $modelEnderecoPrestador->complemento = $dadosInsercao->complemento;
    $modelEnderecoPrestador->cep = $dadosInsercao->cep;
    $modelEnderecoPrestador->inserirEnderecoPrestador();

    echo json_encode($modelPrestador->idPrestador);
    //criar o endereço
    return $modelPrestador;
    
  }

  public function update($id){
    $json = file_get_contents("php://input");
    // echo '<pre>';
    // var_dump($json);
    // exit();
    $modelPrestador = $this->model("Prestador");
    $modelPrestador->procurarPorId($id);
    if(!$modelPrestador){
      http_response_code(404);
      $erro = ["erro" => "Cliente não encontrado"];
      echo json_encode($erro);
      exit;
    } 

    $dadosEdicao = json_decode($json);
    
    $file_chunks = explode(";base64,", $dadosEdicao->foto);
    $fileType = explode("image/", $file_chunks[0]);
    $image_type = $fileType[1];
    $base64Img = base64_decode($file_chunks[1]);
    $file = uniqid().'.'.$image_type;
    file_put_contents($file, $base64Img);
    $modelPrestador->foto = $file;
    

    //$modelPrestador->foto já esta setado por conta do $modelPrestador->procurarPorId($id);
    $modelPrestador->idProfissao = $dadosEdicao->idProfissao;
    $modelPrestador->idSexo = $dadosEdicao->idSexo;
    $modelPrestador->nome = $dadosEdicao->nome;
    $modelPrestador->email = $dadosEdicao->email;
    $modelPrestador->descricao = $dadosEdicao->descricao;
    $modelPrestador->telefone = $dadosEdicao->telefone;
    $modelPrestador->dataNascimento = $dadosEdicao->dataNascimento;
    $modelPrestador->atualizar();
    // echo '<pre>';
    // var_dump($modelPrestador);
    // exit();

    $modelEnderecoPrestador = $this->model("EnderecoPrestador");
    $modelEnderecoPrestador->idEnderecoPrestador = $modelPrestador->idEndereco;
    $modelEnderecoPrestador->uf = $dadosEdicao->uf;
    $modelEnderecoPrestador->cidade = $dadosEdicao->cidade;
    $modelEnderecoPrestador->bairro = $dadosEdicao->bairro;
    $modelEnderecoPrestador->rua = $dadosEdicao->rua;
    $modelEnderecoPrestador->numero = $dadosEdicao->numero;
    $modelEnderecoPrestador->complemento = $dadosEdicao->complemento;
    $modelEnderecoPrestador->cep = $dadosEdicao->cep;
    $modelEnderecoPrestador->atualizar();
    // if($modelPrestador->atualizar()){
    //   http_response_code(204);
    // }else{
    //   http_response_code(500);
    //   $erro = ["erro" => "Problemas ao editar o cliente"];
    //   echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    // }
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