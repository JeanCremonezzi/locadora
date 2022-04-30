<?php
    require_once(dirname(__DIR__)."/entities/Carro.php");
    require_once(dirname(__DIR__)."/database/configuration/connection.php");

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

                $stmt = self::$conn->prepare("INSERT INTO carro(nome, marca, ano, pessoa) VALUES (:nome , :marca, :ano, :pessoa)");

                $stmt->execute([
                    ':nome' => $carro->getNome(),
                    ':marca' => $carro->getMarca(),
                    ':ano' => $carro->getAno(),
                    ':pessoa' => $carro->getIdPessoa()
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
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("SELECT * FROM carro WHERE id = :id");
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
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("SELECT * FROM carro");
                $stmt->execute();

                return $stmt->fetchAll();
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }
        
        public static function update(Carro $carro) {
            try {
                if (!isset(self::$conn)) {
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("UPDATE carro SET nome = :nome, marca = :marca, ano = :ano, pessoa = :pessoa WHERE id = :id");

                $stmt->execute([
                    ':id' => $carro->getId(),
                    ':nome' => $carro->getNome(),
                    ':marca' => $carro->getMarca(),
                    ':ano' => $carro->getAno(),
                    ':pessoa' => $carro->getIdPessoa()
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
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("DELETE FROM carro WHERE id = :id");
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

        public static function updateSetPessoaNull($idPessoa) {
            try {
                if (!isset(self::$conn)) {
                    new CarroDAO();
                }

                $stmt = self::$conn->prepare("UPDATE carro SET pessoa = NULL WHERE pessoa = :id");
                $stmt->execute([
                    ':id' => $idPessoa
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