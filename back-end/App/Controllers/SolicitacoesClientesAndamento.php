<?php
  use App\Core\Controller;
  Class SolicitacoesClientesAndamento extends Controller{
    
    public function index(){
      echo "null"; 
    }

    public function find($id){
      $modelSolicitacao = $this->model("Solicitacao");
      $dados = $modelSolicitacao->visualizarPendenteCliente($id);
      echo json_encode($dados);
    }

  }
