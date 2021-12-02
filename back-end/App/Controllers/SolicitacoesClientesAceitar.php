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

    public function store(){
      $json = file_get_contents("php://input");
      $dadosInsercao = json_decode($json);
      $modelSolicitacao = $this->model("Solicitacao");
      $modelSolicitacao->idPrestador = $dadosInsercao->idPrestador;
      $modelSolicitacao->idCliente = $dadosInsercao->idCliente;
      $modelSolicitacao->descricao = $dadosInsercao->descricao;
      $modelSolicitacao->statusServico = $dadosInsercao->statusServico;
      if($modelSolicitacao->criarSolicitacaoDoClienteParaOPrestador()){
        http_response_code(201);
        return json_encode($modelSolicitacao);
      }else{
        http_response_code(500);
        $erro = ["erro" => "Problemas ao enviar a solicitação"];
        return json_encode($erro);
      }
    }

    public function update($id){

    }
  }
