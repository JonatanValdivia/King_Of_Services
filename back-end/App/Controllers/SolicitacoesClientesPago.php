<?php
  use App\Core\Controller;
  Class SolicitacoesClientesPago extends Controller{
    
    public function index(){
      echo "null"; 
    }

    public function find($id){
      $modelSolicitacao = $this->model("Solicitacao");
      $dados = $modelSolicitacao->visualizarPagoCliente($id);
      echo json_encode($dados);
    }

    public function update($id){
      $json = file_get_contents("php://input");
      $dadosEdicao = json_decode($json);
      $modelSolicitacao = $this->model("Solicitacao");
      $modelSolicitacao->buscarPeloIdDaSolicitacao($id);
      if(!$modelSolicitacao){
        http_response_code(404);
        $erro = ["erro" => "Cliente não encontrado"];
        echo json_encode($erro);
        exit;
      } 
      $modelSolicitacao->idServicoPrestador = $id;
      if($modelSolicitacao->atualizarsolicitacaoServicoConcluido_pago()){
        http_response_code(204);
      }else{
        http_response_code(500);
        $erro = ["erro" => "Problemas ao editar o cliente"];
        echo json_encode($erro, JSON_UNESCAPED_UNICODE);
      }
      return $modelSolicitacao;
    }
    
  }
