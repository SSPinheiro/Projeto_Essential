<?php

class Cliente
{
    private $pdo;
    public $msgErro = "";

    public function __construct($dbname, $host, $usuario, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $usuario, $senha);
        } catch (PDOException $e) {
            $this->msgErro = $e->getMessage();
        }
    }
    public function excluirCliente($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM cliente WHERE id_cliente = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }
    

    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT id_cliente, nome, cpf, email, telefone FROM cliente ORDER
        BY id_cliente");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrar($nome, $email, $cpf, $telefone)
    {

        $sql = $this->pdo->prepare("SELECT id_cliente FROM cliente WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return false;
        } else {
            $sql = $this->pdo->prepare("INSERT INTO cliente (nome, email, cpf, telefone) VALUES (:n, :e, :c, :t)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":c", $cpf);
            $sql->bindValue(":t", $telefone);
            $sql->execute();
            return true;
        }
    }
}
