<?php
    require_once("Carro.php");

    class Pessoa {
        private $id;
        private $nome;
        private $login;
        private $senha;

        public function __construct() {
            $this->id = null;
            $this->nome = null;
            $this->login = null;
            $this->senha = null;
        }

        public static function create($nome, $login, $senha) {
            $instance = new self();

            $instance->nome = $nome;
            $instance->login = $login;
            $instance->senha = $senha;

            return $instance;
        }

        public static function createWithId($id, $nome, $login, $senha) {
            $instance = self::create($nome, $login, $senha);
            $instance->id = $id;

            return $instance;
        }

        public static function createByArray($array) {
            $instance = self::createWithId(
                $array['id'],
                $array['nome'],
                $array['login'],
                $array['senha'],
            );

            return $instance;
        }

        public function encode() {
            return json_encode([
                "id" => $this->id,
                "nome" => $this->nome,
                "login" => $this->login,
                "senha" => $this->senha
            ]);
        }

        public function getId() {
            return $this->id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getLogin() {
            return $this->login;
        }

        public function getSenha() {
            return $this->senha;
        }

        public function getCarros() {
            return $this->carros;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setLogin($login) {
            $this->login = $login;
        }

        public function setSenha($senha) {
            $this->senha = $senha;
        }
    }
?>