<?php
    require_once("carro.php");

    class Pessoa {
        private $id;
        private $nome;
        private $login;
        private $senha;
        private $carros;

        public function __construct() {
            $this->id = null;
            $this->nome = null;
            $this->login = null;
            $this->senha = null;
            $this->carros = [];
        }

        public static function create($nome, $login, $senha, $carros = []) {
            $instance = new self();

            $instance->nome = $nome;
            $instance->login = $login;
            $instance->senha = $senha;
            $instance->carros = $carros;

            return $instance;
        }

        public static function createWithId($id, $nome, $login, $senha, $carros = []) {
            $instance = self::create($nome, $login, $senha, $carros);
            $instance->id = $id;

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

        public function addCarro(Carro $carro) {
            $this->carros[$carro->getId()] = $carro;
            $carro->setIdPessoa($this->id);
        }

        public function removeCarro($id) {
            $this->carros[$id]->setIdPessoa(null);
            unset($this->carros[$id]);
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