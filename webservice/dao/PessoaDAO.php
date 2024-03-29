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

                if (self::loginExists($pessoa->getLogin())) {
                    $response["status"] = 409;
                    $response["msg"] = "Login já existe";

                } else {
                    $stmt = self::$conn->prepare("INSERT INTO pessoa(nome, login, senha) VALUES (:nome , :login, :senha)");

                    $stmt->execute([
                        ':nome' => $pessoa->getNome(),
                        ':login' => $pessoa->getLogin(),
                        ':senha' => $pessoa->getSenha()
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $response["status"] = 201;
                        $response["msg"] = "Pessoa inserida com sucesso";
                        $response["data"] = self::findOne(self::$conn->lastInsertId())["data"];

                    } else {
                        $response["status"] = 400;
                        $response["msg"] = "Pessoa não inserida";
                    }
                }

                return $response;

            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
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
                    $response["status"] = 404;
                    $response["msg"] = "Pessoa não encontrada";

                } else {
                    $response["status"] = 200;
                    $response["msg"] = "Pessoa encontrada";
                    $response["data"] = $result[0];
                }

                return $response;

            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
            } 
        }

        public static function findAll() {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                $stmt = self::$conn->prepare("SELECT * FROM pessoa");
                $stmt->execute();

                $result = $stmt->fetchAll();

                if (count($result)) {
                    $response["status"] = 200;
                    $response["msg"] = "Pessoas encontradas";
                    $response["data"] = $result;
                    
                } else {
                    $response["status"] = 404;
                    $response["msg"] = "Nenhuma pessoa encontrada";
                }
        
                return $response;
            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
            }
        }

        public static function update(Pessoa $pessoa) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                if (!self::idExists($pessoa->getId())) {
                    $response["status"] = 404;
                    $response["msg"] = "Pessoa não encontrada";
                    
                } else if (self::loginExists($pessoa->getLogin(), $pessoa->getId())) {
                    $response["status"] = 409;
                    $response["msg"] = "Login já existe";

                } else {
                    $stmt = self::$conn->prepare("UPDATE pessoa SET nome = :nome, login = :login, senha = :senha WHERE id = :id");

                    $stmt->execute([
                        ':id' => $pessoa->getId(),
                        ':nome' => $pessoa->getNome(),
                        ':login' => $pessoa->getLogin(),
                        ':senha' => $pessoa->getSenha()
                    ]);
                    
                    if ($stmt->rowCount() > 0) {
                        $response["status"] = 200;
                        $response["msg"] = "Pessoa atualizada com sucesso";
                        $response["data"] = self::findOne($pessoa->getId())["data"];

                    } else {
                        $response["status"] = 400;
                        $response["msg"] = "Pessoa não atualizada";
                    }
                }

                return $response;
            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
            }
        }

        public static function delete($id) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                if (!self::idExists($id)) {
                    $response["status"] = 404;
                    $response["msg"] = "Pessoa não encontrada";

                } else if (CarroDAO::haveCarros($id)) {
                    $response["status"] = 409;
                    $response["msg"] = "Não é possível deletar pessoa que possua carros";

                } else {
                    $stmt = self::$conn->prepare("DELETE FROM pessoa WHERE id = :id");
                    $stmt->execute([
                        ':id' => $id
                    ]);
                    
                    if ($stmt->rowCount() > 0) {
                        $response["status"] = 200;
                        $response["msg"] = "Pessoa deletada com sucesso";
                        
                    } else {
                        $response["status"] = 400;
                        $response["msg"] = "Pessoa não deletada ou não encontrada";
                    }
                }
                
                return $response;
                
            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
            }
        }

        public static function loginExists($login, $id = null) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                if ($id != null) {
                    $stmt = self::$conn->prepare("SELECT COUNT(*) FROM pessoa WHERE login = :login AND id != :id");
                    $stmt->execute([
                        ':login' => $login,
                        ':id' => $id
                    ]);

                } else {
                    $stmt = self::$conn->prepare("SELECT COUNT(*) FROM pessoa WHERE login = :login");
                    $stmt->execute([
                        ':login' => $login
                    ]);    
                }


                if ($stmt->fetchColumn()) {
                    return true;
                }

                return false;

            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
            }
        }

        public static function idExists($id) {
            try {
                if (!isset(self::$conn)) {
                    new PessoaDAO();
                }

                $stmt = self::$conn->prepare("SELECT COUNT(*) FROM pessoa WHERE id = :id");
                $stmt->execute([
                    ':id' => $id
                ]);

                if ($stmt->fetchColumn()) {
                    return true;
                }

                return false;

            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
            }
        }
    }
?>