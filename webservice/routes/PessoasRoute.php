<?php
    require_once(dirname(__DIR__)."/utils/header.php");
    require_once(dirname(__DIR__)."/utils/utils.php");
    require_once(dirname(__DIR__)."/utils/verbs.php");
    require_once(dirname(__DIR__)."/dao/PessoaDAO.php");

    if (isMetodo("GET")) {
        if (parametrosValidos($_GET, ["id"])) {
            $response = PessoaDAO::findOne($_GET["id"]);
        } else {
            $response = PessoaDAO::findAll();
        }
    
        echo json_encode($response);
    
        die;
    }

    if (isMetodo("POST")) {
        if (parametrosValidos($_POST, ["nome", "login", "senha"])) {
            $pessoa = Pessoa::create($_POST["nome"], $_POST["login"], $_POST["senha"]);
            $response = PessoaDAO::insert($pessoa);
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }

        echo json_encode($response);

        die;
    }

    if (isMetodo("PUT")) {
        if (parametrosValidos($_PUT, ["id", "nome", "login", "senha"])) {
            $pessoa = Pessoa::createWithId($_PUT["id"], $_PUT["nome"], $_PUT["login"], $_PUT["senha"]);
            $response = PessoaDAO::update($pessoa);
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }

        echo json_encode($response);

        die;
    }

    if (isMetodo("DELETE")) {
        if (parametrosValidos($_DELETE, ["id"])) {
            $response = PessoaDAO::delete($_DELETE["id"]);
        } else {
            $response = ["msg" => "Parâmetros inválidos"];
        }
        
        echo json_encode($response);

        die;
    }

    echo "Nenhuma rota encontrada";

?>