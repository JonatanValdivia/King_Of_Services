<?php
  use App\Core\Controller;
  Class SolicitacoesClientesAceitar extends Controller{
    
    public function index(){
      echo "null"; 
    }

    public function find($id){
      $modelSolicitacao = $this->model("Solicitacao");
      $dados = $modelSolicitacao->visualizarAceitacaoCliente($id);
      echo json_encode($dados);
    }
  }
