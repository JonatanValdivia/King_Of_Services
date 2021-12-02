<?php
  use App\Core\Controller;
  Class SolicitacoesClientesConcluidas extends Controller{
    
    public function index(){
      echo "null"; 
    }

    public function find($id){
      $modelSolicitacao = $this->model("Solicitacao");
      $dados = $modelSolicitacao->visualizarConcluidoCliente($id);
      echo json_encode($dados);
    }

  }
