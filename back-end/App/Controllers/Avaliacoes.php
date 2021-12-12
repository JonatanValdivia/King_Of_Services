<?php

use App\Core\Controller;

class Avaliacoes extends Controller{

  public function find($id){
    $modelAvaliacao = $this->model("Avaliacao");
    $dados = $modelAvaliacao->buscarPeloIdDaAvaliacao($id);
    echo json_encode($dados);
  }

  public function store(){
    $json = file_get_contents("php://input");
    $dadosInsercao = json_decode($json);
    $modelAvaliacao = $this->model("Avaliacao");
    $modelAvaliacao->idPrestador = $dadosInsercao->idPrestador;
    $modelAvaliacao->idCliente = $dadosInsercao->idCliente;
    $modelAvaliacao->estrelas = $dadosInsercao->estrelas;
    $modelAvaliacao->comentario = $dadosInsercao->comentario;
    //Conversão da foto
    $file_chunks = explode(";base64,", $dadosInsercao->foto);
    $fileType = explode("image/", $file_chunks[0]);
    $image_type = $fileType[1];
    $base64Img = base64_decode($file_chunks[1]);
    $file = uniqid().'.'.$image_type;
    file_put_contents('./fotos_avaliacoes/'.$file, $base64Img); 
    $modelAvaliacao->foto =  $file;
    $modelAvaliacao->criarAvalidacao();
  }
}