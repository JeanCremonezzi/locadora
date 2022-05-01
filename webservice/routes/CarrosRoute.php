<?php
    require_once(dirname(__DIR__)."/utils/header.php");
    require_once(dirname(__DIR__)."/utils/utils.php");
    require_once(dirname(__DIR__)."/utils/verbs.php");
    require_once(dirname(__DIR__)."/dao/CarroDAO.php");

    if (isMetodo("GET")) {
        if (count($_GET) == 0) {
            $response = CarroDAO::findAll();

        } else if (parametrosValidos($_GET, ["id"])) {
            if (!filterIsInt($_GET["id"])) {
                $response = [
                    "status" => 400,
                    "msg" => "ID inválido"
                ];

            } else {
                $response = CarroDAO::findOne($_GET["id"]);
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "Parametros invalidos"
            ];
        }

        http_response_code($response["status"]);
        echo json_encode($response);
        die;
    }

    if (isMetodo("POST")) {
        if (parametrosValidos($_POST, ["nome", "marca", "ano", "idPessoa"])) {
            if (!filterIsInt($_POST["ano"])) {
                $response = [
                    "status" => 400,
                    "msg" => "Ano inválido"
                ];

            } else if (!filterIsInt($_POST["idPessoa"])) {
                $response = [
                    "status" => 400,
                    "msg" => "ID inválido"
                ];

            } else {
                $carro = Carro::create($_POST["nome"], $_POST["marca"], $_POST["ano"], $_POST["idPessoa"]);
                $response = CarroDAO::insert($carro);    
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "Parâmetros inválidos"
            ];
        }

        http_response_code($response["status"]);
        echo json_encode($response);
        die;
    }

    if (isMetodo("PUT")) {
        if (parametrosValidos($_PUT, ["id", "nome", "marca", "ano", "idPessoa"])) {
            if (!filterIsInt($_PUT["id"]) || !filterIsInt($_PUT["idPessoa"])) {
                $response = [
                    "status" => 400,
                    "msg" => "IDs devem ser números inteiros inválido"
                ];

            } else if (!filterIsInt($_PUT["ano"])) {
                $response = [
                    "status" => 400,
                    "msg" => "Ano inválido"
                ];

            } else {
                $carro = Carro::createWithId($_PUT["id"], $_PUT["nome"], $_PUT["marca"], $_PUT["ano"], $_PUT["idPessoa"]);
                $response = CarroDAO::update($carro);
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "Parâmetros inválidos"
            ];
        }

        http_response_code($response["status"]);
        echo json_encode($response);
        die;
    }

    if (isMetodo("DELETE")) {
        if (parametrosValidos($_DELETE, ["id"])) {
            if (!filterIsInt($_DELETE["id"])) {
                $response = [
                    "status" => 400,
                    "msg" => "ID inválido"
                ];
                
            } else {
                $response = CarroDAO::delete($_DELETE["id"]);
            }
        } else {
            $response = [
                "status" => 400,
                "msg" => "Parâmetros inválidos"
            ];
        }
        
        http_response_code($response["status"]);
        echo json_encode($response);
        die;
    }

    http_response_code(501);
    echo json_encode([
        "status" => 501,
        "msg" => "Rota não encontrado",
    ]);
?>