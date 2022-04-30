<?php
    function parametrosValidos($metodo, $lista) {
        $obtidos = array_keys($metodo);
        $nao_encontrados = array_diff($lista, $obtidos);

        if (empty($nao_encontrados)) {
            foreach ($lista as $p) {
                if (empty(trim($metodo[$p])) and trim($metodo[$p]) != "0") {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    function isMetodo($metodo) {
        if (!strcasecmp($_SERVER['REQUEST_METHOD'], $metodo)) {
            return true;
        }

        return false;
    }

    function filterIsInt($v) {
        return filter_var($v, FILTER_VALIDATE_INT);
    }

    function filterIsEmail($v) {
        return filter_var($v, FILTER_VALIDATE_EMAIL);
    }

    function emptyString($str) {
        if (strlen(trim($str)) == 0) {
            return true;
        } 

        return false;
    }
?>