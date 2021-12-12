<?php

use App\Core\Controller;

class AvaliacoesPrestador extends Controller{

  public function find($id){
    $modelAvaliacao = $this->model("Avaliacao");
    $dados = $modelAvaliacao->buscarPeloIdDoPrestador($id);
    echo json_encode($dados);
  }
}