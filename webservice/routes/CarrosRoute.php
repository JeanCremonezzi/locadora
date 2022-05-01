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
                $response = ["msg" => "ID inválido"];

            } else {
                $response = CarroDAO::findOne($_GET["id"]);
            }
        } else {
            $response = ["msg" => "Parametros invalidos"];
        }

        echo json_encode($response);
        die;
    }

    if (isMetodo("POST")) {
        if (parametrosValidos($_POST, ["nome", "marca", "ano", "idPessoa"])) {
            if (!filterIsInt($_POST["ano"])) {
                $response = ["msg" => "Ano inválido"];

            } else if (!filterIsInt($_POST["idPessoa"])) {
                $response = ["msg" => "ID inválido"];

            } else {
                $carro = Carro::create($_POST["nome"], $_POST["marca"], $_POST["ano"], $_POST["idPessoa"]);
                $response = CarroDAO::insert($carro);    
            }
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }

        echo json_encode($response);

        die;
    }

    if (isMetodo("PUT")) {
        if (parametrosValidos($_PUT, ["id", "nome", "marca", "ano", "idPessoa"])) {
            if (!filterIsInt($_PUT["id"]) || !filterIsInt($_PUT["idPessoa"])) {
                $response = ["msg" => "IDs devem ser números inteiros inválido"];

            } else if (!filterIsInt($_PUT["ano"])) {
                $response = ["msg" => "Ano inválido"];

            } else {
                $carro = Carro::createWithId($_PUT["id"], $_PUT["nome"], $_PUT["marca"], $_PUT["ano"], $_PUT["idPessoa"]);
                $response = CarroDAO::update($carro);
            }
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }

        echo json_encode($response);

        die;
    }

    if (isMetodo("DELETE")) {
        if (parametrosValidos($_DELETE, ["id"])) {
            if (!filterIsInt($_DELETE["id"])) {
                $response = ["msg" => "ID inválido"];
                
            } else {
                $response = CarroDAO::delete($_DELETE["id"]);
            }
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }
        
        echo json_encode($response);

        die;
    }

    echo json_encode(["msg" => "Rota não encontrado"]);

?>