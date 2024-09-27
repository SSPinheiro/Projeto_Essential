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

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
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
    public function excluirProduto($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM produto WHERE id_produto = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }
    public function atualizarProduto($id, $nome, $sku, $valor, $quantidade, $descricao, $caminho = null) {
        $sql = "UPDATE produto SET nome = :nome, sku = :sku, valor = :valor, quantidade = :quantidade, descricao = :descricao";
        if ($caminho) {
            $sql .= ", caminho = :caminho";
        }
        $sql .= " WHERE id_produto = :id";

        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':nome' => $nome,
            ':sku' => $sku,
            ':valor' => $valor,
            ':quantidade' => $quantidade,
            ':descricao' => $descricao,
            ':id' => $id,
        ];
        if ($caminho) {
            $params[':caminho'] = $caminho;
        }

        return $stmt->execute($params);
    }
    public function atualizarQuantidade($id, $quantidade){
        $sql = "UPDATE produto SET quantidade = :quantidade WHERE id_produto = :id";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':quantidade' => $quantidade,
            ':id' => $id,
        ];
        return $stmt->execute($params);
    }
    public function contarProdutos(){
        $sql = "SELECT COUNT(*) AS total FROM produto";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}