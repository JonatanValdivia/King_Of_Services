<?php
  use App\Core\Controller;
  Class SolicitacoesPrestadoresPago extends Controller{
    
    public function index(){
      echo "null"; 
    }

    public function find($id){
      $modelSolicitacao = $this->model("Solicitacao");
      $dados = $modelSolicitacao->PagoPrestador($id);
      echo json_encode($dados);
    }

  }