<?php 

class Pedido {
    private $host = 'localhost';
    private $db = 'essentia';
    private $user = 'root';
    private $pass = 'Unida010!';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    }
    public function contarPedidos(){
        $sql = "SELECT COUNT(*) AS total FROM pedidos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}

?>