<?php
    require_once(dirname(__DIR__)."/entities/Carro.php");
    require_once(dirname(__DIR__)."/database/configuration/connection.php");
    require_once("PessoaDAO.php");

    class CarroDAO {
        private static $conn;

        public function __construct() {
            self::$conn = Conexao::getConexao();
        }

        public static function insert(Carro $carro) {
            try {
                if (!isset(self::$conn)) {
                    new CarroDAO();
                }

                if (!PessoaDAO::idExists($carro->getIdPessoa())) {
                    $response["status"] = 404;
                    $response["msg"] = "Pessoa não existe";

                } else {
                    $stmt = self::$conn->prepare("INSERT INTO carro(nome, marca, ano, idPessoa) VALUES (:nome , :marca, :ano, :pessoa)");

                    $stmt->execute([
                        ':nome' => $carro->getNome(),
                        ':marca' => $carro->getMarca(),
                        ':ano' => $carro->getAno(),
                        ':pessoa' => $carro->getIdPessoa()
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $response["status"] = 201;
                        $response["msg"] = "Carro inserido com sucesso";
                        $response["data"] = self::findOne(self::$conn->lastInsertId())["data"];

                    } else {
                        $response["status"] = 400;
                        $response["msg"] = "Carro não inserido";
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
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("
                    SELECT carro.*, pessoa.nome AS pessoa
                    FROM carro, pessoa
                    WHERE carro.id = :id AND carro.idPessoa = pessoa.id;
                ");
                $stmt->execute([
                    ':id' => $id
                ]);
                
                $result = $stmt->fetchAll();

                if (count($result) == 0) {
                    $response["status"] = 404;
                    $response["msg"] = "Carro não encontrado";

                } else {
                    $response["status"] = 200;
                    $response["msg"] = "Carro encontrado";
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
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("
                    SELECT carro.*, pessoa.nome AS pessoa 
                    FROM carro, pessoa 
                    WHERE carro.idPessoa = pessoa.id;
                ");
                $stmt->execute();

                $result = $stmt->fetchAll();

                if (count($result)) {
                    $response["status"] = 200;
                    $response["msg"] = "Carros encontrados";
                    $response["data"] = $result;

                } else {
                    $response["status"] = 404;
                    $response["msg"] = "Nenhum carro encontrado";
                }
        
                return $response;
            } catch (Exception $e) {
                return $response = [
                    "status" => 500,
                    "msg" => "Internal Server Error"
                ];
            }
        }
        
        public static function update(Carro $carro) {
            try {
                if (!isset(self::$conn)) {
                    new CarroDAO();
                }

                if (!self::idExists($carro->getId())) {
                    $response["status"] = 404;
                    $response["msg"] = "Carro não existe";

                } else if (!PessoaDAO::idExists($carro->getIdPessoa())) {
                    $response["status"] = 404;
                    $response["msg"] = "Pessoa não existe";

                } else {
                    $stmt = self::$conn->prepare("UPDATE carro SET nome = :nome, marca = :marca, ano = :ano, idPessoa = :pessoa WHERE id = :id");

                    $stmt->execute([
                        ':id' => $carro->getId(),
                        ':nome' => $carro->getNome(),
                        ':marca' => $carro->getMarca(),
                        ':ano' => $carro->getAno(),
                        ':pessoa' => $carro->getIdPessoa()
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $response["status"] = 200;
                        $response["msg"] = "Carro atualizado com sucesso";
                        $response["data"] = self::findOne($carro->getId())["data"];
                        
                    } else {
                        $response["status"] = 400;
                        $response["msg"] = "Carro não atualizado";
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
                    new CarroDAO();
                }

                if (!self::idExists($id)) {
                    $response["status"] = 404;
                    $response["msg"] = "Carro não existe";

                } else {
                    $stmt = self::$conn->prepare("DELETE FROM carro WHERE id = :id");
                    $stmt->execute([
                        ':id' => $id
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $response["status"] = 200;
                        $response["msg"] = "Carro deletado com sucesso";
                        
                    } else {
                        $response["status"] = 400;
                        $response["msg"] = "Carro não deletado ou não encontrado";
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

        public static function haveCarros($idPessoa) {
            try {
                if (!isset(self::$conn)) {
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("SELECT COUNT(*) FROM carro WHERE idPessoa = :idPessoa");
                $stmt->execute([
                    ':idPessoa' => $idPessoa
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

        public static function idExists($id) {
            try {
                if (!isset(self::$conn)) {
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("SELECT COUNT(*) FROM carro WHERE id = :id");
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