<?php
  use App\Core\Controller;
  Class SolicitacoesPrestadoresAndamento extends Controller{
    
    public function index(){
      echo "null"; 
    }

    public function find($id){
      $modelSolicitacao = $this->model("Solicitacao");
      $dados = $modelSolicitacao->AndamentoPrestador($id);
      echo json_encode($dados);
    }

    public function update($id){

    }
  }
