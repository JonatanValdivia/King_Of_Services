<?php

namespace App\Core;

class Router{
    private $controller;
    private $method;
    private $controllerMethod;
    private $params = [];

    function __construct(){
        //Serve para liberar as origens a acessar a nossa aplicação
        header('Access-Control-Allow-Origin: *');
        //serve para habilitar os métodos que serão usados. Habilitamos o opticons para ser realizado o preflight. Uma requisição de confirmação
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        //Os headers que serão usados
        header("Access-Control-Allow-Headers: Content-Type");
        //setamos que a resposta será enviada no formato JSON
        header("content-tyle: application/json");

        $url = $this->parseURL();
        // var_dump($url);
        if(file_exists("../App/Controllers/" . $url[1] . ".php")){
            $this->controller = $url[1];
            unset($url[1]);
        }elseif(empty($url[1]) || $url[1] == null){
            $this->controller = "Clientes";
        }else{
            $this->controller = "Clientes";
        }
        // echo "<br>";
        // var_dump($this->controller);

        require_once "../App/Controllers/" . $this->controller . ".php";

        $this->controller = new $this->controller;

        $this->method = $_SERVER["REQUEST_METHOD"];

        switch($this->method){
            case "GET":
                if(isset($url[2])){
                    $this->controllerMethod = "find";
                    $this->params = [$url[2]];
                }else{
                    $this->controllerMethod = "index";
                }

                break;

            case "POST":
                $this->controllerMethod = "store";

                break;
            
            case "PUT":
                $this->controllerMethod = "update";
                if(isset($url[2]) && is_numeric($url[2])){
                    $this->params = [$url[2]];
                }else{
                    http_response_code(400);
                    echo json_encode(["Erro" => "Necessário informar o id para atualização"]);
                    exit;
                }

                break;

            case "DELETE":
                $this->controllerMethod = "delete";
                if(isset($url[2]) && is_numeric($url[2])){
                    $this->params = [$url[2]];
                }else{
                    http_response_code(400);
                    echo json_encode(["Erro" => "Necessário informar o id para deleção"]);
                }

                break;
            
            default: 
                // http_response_code(400);
                echo json_encode(["Erro" => "Método não suportado"]);
                exit;

                break;
                
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
        
    }

    private function parseURL(){
        return explode('/', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    }

}