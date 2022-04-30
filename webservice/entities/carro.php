<?php
    class Carro {
        private $id;
        private $nome;
        private $marca;
        private $ano;
        private $idPessoa;

        public function __construct() {
            $this->id = null;
            $this->nome = null;
            $this->marca = null;
            $this->ano = null;
            $this->idPessoa = null;
        }

        public static function create($nome, $marca, $ano, $idPessoa = null) {
            $instance = new self();

            $instance->nome = $nome;
            $instance->marca = $marca;
            $instance->ano = $ano;
            $instance->idPessoa = $idPessoa;

            return $instance;
        }

        public static function createWithId($id, $nome, $marca, $ano, $idPessoa = null) {
            $instance = self::create($nome, $marca, $ano, $idPessoa);
            $instance->id = $id;

            return $instance;
        }

        public function encode() {
            return json_encode(get_object_vars($this));
        }

        public function getId() {
            return $this->id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getMarca() {
            return $this->marca;
        }

        public function getAno() {
            return $this->ano;
        }

        public function getIdPessoa() {
            return $this->idPessoa;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setMarca($marca) {
            $this->marca = $marca;
        }

        public function setAno($ano) {
            $this->ano = $ano;
        }

        public function setIdPessoa($idPessoa) {
            $this->idPessoa = $idPessoa;
        }
    }
?>