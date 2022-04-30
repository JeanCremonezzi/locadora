<?php
    require_once(dirname(__DIR__)."/utils/header.php");
    require_once(dirname(__DIR__)."/utils/utils.php");
    require_once(dirname(__DIR__)."/utils/verbs.php");
    require_once(dirname(__DIR__)."/dao/CarroDAO.php");

    if (isMetodo("GET")) {
        if (parametrosValidos($_GET, ["id"])) {
            $response = CarroDAO::findOne($_GET["id"]);
        } else {
            $response = CarroDAO::findAll();
        }
    
        echo json_encode($response);
    
        die;
    }

    if (isMetodo("POST")) {
        if (parametrosValidos($_POST, ["nome", "marca", "ano", "idPessoa"])) {
            $carro = Carro::create($_POST["nome"], $_POST["marca"], $_POST["ano"], $_POST["idPessoa"]);
            $response = CarroDAO::insert($carro);
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }

        echo json_encode($response);

        die;
    }

    if (isMetodo("PUT")) {
        if (parametrosValidos($_PUT, ["id", "nome", "marca", "ano", "idPessoa"])) {
            $carro = Carro::createWithId($_PUT["id"], $_PUT["nome"], $_PUT["marca"], $_PUT["ano"], $_PUT["idPessoa"]);
            $response = CarroDAO::update($carro);
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }

        echo json_encode($response);

        die;
    }

    if (isMetodo("DELETE")) {
        if (parametrosValidos($_DELETE, ["id"])) {
            $response = CarroDAO::delete($_DELETE["id"]);
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }
        
        echo json_encode($response);

        die;
    }

    echo "Nenhuma rota encontrada";
?>