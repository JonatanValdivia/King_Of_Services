<?php

use App\Core\Controller;

class AtualizarFotoCliente extends Controller{

  public function update($id){
    $json = file_get_contents("php://input");
    $modelCliente = $this->model("Cliente");
    $modelCliente->buscarPorId($id);
    $dadosEdicao = json_decode($json);
    $file_chunks = explode(";base64,", $dadosEdicao->foto);
    $fileType = explode("image/", $file_chunks[0]);
    $image_type = $fileType[1];
    $base64Img = base64_decode($file_chunks[1]);
    $file = uniqid().'.'.$image_type;
    file_put_contents($file, $base64Img);
    $modelCliente->foto = $file;
    if($modelCliente->atualizarFoto()){
      return true;
    }else{
      return false;
    }
  }
}