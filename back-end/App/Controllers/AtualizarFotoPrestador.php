<?php

use App\Core\Controller;

class AtualizarFotoPrestador extends Controller{

  public function update($id){
    $json = file_get_contents("php://input");
    $modelPrestador = $this->model("Prestador");
    $modelPrestador->procurarPorId($id);
    $dadosEdicao = json_decode($json);
    $file_chunks = explode(";base64,", $dadosEdicao->foto);
    $fileType = explode("image/", $file_chunks[0]);
    $image_type = $fileType[1];
    $base64Img = base64_decode($file_chunks[1]);
    $file = uniqid().'.'.$image_type;
    file_put_contents($file, $base64Img);
    $modelPrestador->foto = $file;
    if($modelPrestador->atualizarFoto()){
      return true;
    }else{
      return false;
    }
  }
}