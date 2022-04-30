<?php
    require_once(dirname(__DIR__)."/entities/Pessoa.php");
    require_once(dirname(__DIR__)."/database/configuration/connection.php");

    class PessoaDAO {
        private static $conn;

        public function __construct() {
            self::$conn = Conexao::getConexao();
        }

        public static function insert(Pessoa $pessoa) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                $stmt = self::$conn->prepare("INSERT INTO pessoa(nome, login, senha) VALUES (:nome , :login, :senha)");

                $stmt->execute([
                    ':nome' => $pessoa->getNome(),
                    ':login' => $pessoa->getLogin(),
                    ':senha' => $pessoa->getSenha()
                ]);

                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        public static function findOne($id) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                $stmt = self::$conn->prepare("SELECT * FROM pessoa WHERE id = :id");
                $stmt->execute([
                    ':id' => $id
                ]);
                
                $result = $stmt->fetchAll();

                if (count($result) == 0) {
                    return [];
                } else {
                    return $result[0];
                }

            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            } 
        }

        public static function findAll() {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                $stmt = self::$conn->prepare("SELECT * FROM pessoa");
                $stmt->execute();

                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        public static function update(Pessoa $pessoa) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }
            
                $stmt = self::$conn->prepare("UPDATE pessoa SET nome = :nome, login = :login, senha = :senha WHERE id = :id");

                $stmt->execute([
                    ':id' => $pessoa->getId(),
                    ':nome' => $pessoa->getNome(),
                    ':login' => $pessoa->getLogin(),
                    ':senha' => $pessoa->getSenha()
                ]);

                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        public static function delete($id) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                CarroDAO::updateSetPessoaNull($id);

                $stmt = self::$conn->prepare("DELETE FROM pessoa WHERE id = :id");
                $stmt->execute([
                    ':id' => $id
                ]);

                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
                
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }
    }
?>