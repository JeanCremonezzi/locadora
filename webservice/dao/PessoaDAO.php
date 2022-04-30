<?php
    require_once(dirname(__DIR__)."/entities/Pessoa.php");
    require_once(dirname(__DIR__)."/database/configuration/connection.php");
    require_once("CarroDAO.php");

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

                $response = [];
                if ($stmt->rowCount() > 0) {
                    $response["msg"] = "Pessoa inserida com sucesso";
                    $response["data"] = self::findOne(self::$conn->lastInsertId())["data"];
                } else {
                    $response["msg"] = "Pessoa não inserida";
                }

                return $response;

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

                $response = [];
                if (count($result) == 0) {
                    $response["msg"] = "Pessoa não encontrada";
                } else {
                    $response["msg"] = "Pessoa encontrada";
                    $response["data"] = $result[0];
                }

                return $response;

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

                $response = [
                    "data" => $stmt->fetchAll()
                ];
        
                return $response;
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
                
                $response = [];
                if ($stmt->rowCount() > 0) {
                    $response["msg"] = "Pessoa atualizada com sucesso";
                    $response["data"] = self::findOne($pessoa->getId())["data"];
                } else {
                    $response["msg"] = "Pessoa não atualizada ou não encontrada";
                }

                return $response;
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
                
                $response = [];
                if ($stmt->rowCount() > 0) {
                    $response["msg"] = "Pessoa deletada com sucesso";
                } else {
                    $response["msg"] = "Pessoa não deletada ou não encontrada";
                }

                return $response;
                
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }
    }
?>