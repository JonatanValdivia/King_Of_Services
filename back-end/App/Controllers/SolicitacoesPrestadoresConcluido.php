<?php
  use App\Core\Controller;
  Class SolicitacoesPrestadoresConcluido extends Controller{
    
    public function index(){
      echo "null"; 
    }

    public function find($id){
      $modelSolicitacao = $this->model("Solicitacao");
      $dados = $modelSolicitacao->ConcluidoPrestador($id);
      echo json_encode($dados);
    }
  }
