<?php
    require_once(dirname(__DIR__)."/utils/header.php");
    require_once(dirname(__DIR__)."/utils/utils.php");
    require_once(dirname(__DIR__)."/utils/verbs.php");
    require_once(dirname(__DIR__)."/dao/PessoaDAO.php");

    if (isMetodo("GET")) {
        if (count($_GET) == 0) {
            $response = PessoaDAO::findAll();

        } else if (parametrosValidos($_GET, ["id"])) {
            if (!filterIsInt($_GET["id"])) {
                $response = [
                    "status" => 400,
                    "msg" => "ID inválido"
                ];

            } else {
                $response = PessoaDAO::findOne($_GET["id"]);
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

    if (isMetodo("POST")) {
        if (parametrosValidos($_POST, ["nome", "login", "senha"])) {
            if (!filterIsEmail($_POST["login"])) {
                $response = [
                    "status" => 400,
                    "msg" => "Login deve ser email"
                ];

            } else {
                $pessoa = Pessoa::create($_POST["nome"], $_POST["login"], $_POST["senha"]);
                $response = PessoaDAO::insert($pessoa);
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
        if (parametrosValidos($_PUT, ["id", "nome", "login", "senha"])) {

            if (!filterIsInt($_PUT["id"])) {
                $response = [
                    "status" => 400,
                    "msg" => "ID inválido"
                ];

            } else if (!filterIsEmail($_PUT["login"])) {
                $response = [
                    "status" => 400,
                    "msg" => "Login deve ser email"
                ];

            } else {
                $pessoa = Pessoa::createWithId($_PUT["id"], $_PUT["nome"], $_PUT["login"], $_PUT["senha"]);
                $response = PessoaDAO::update($pessoa);
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
                $response = PessoaDAO::delete($_DELETE["id"]);
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