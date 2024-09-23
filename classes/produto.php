<?php
class Produto {
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

    public function insertProduto($nome, $sku, $valor, $quantidade, $descricao, $caminho) {
        $stmt = $this->pdo->prepare("INSERT INTO produto (nome, sku, valor, quantidade, descricao, caminho) VALUES (:nome, :sku, :valor, :quantidade, :descricao, :caminho)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':caminho', $caminho);
        return $stmt->execute();
    }

    public function getProdutos() {
        $stmt = $this->pdo->query("SELECT * FROM produto");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT id_produto, nome, sku, valor, quantidade, descricao, caminho FROM produto ORDER
        BY id_produto");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
}