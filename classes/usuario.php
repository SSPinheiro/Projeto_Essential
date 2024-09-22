<?php

class Usuario
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
    public function cadastrar($nome, $email, $cpf, $telefone, $dataNascimento, $senha)
    {

        $sql = $this->pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return false;
        } else {
            $sql = $this->pdo->prepare("INSERT INTO usuario (nome, email,cpf, telefone, dataNascimento, senha) VALUES (:n, :e, :c, :t, :d, :s)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":c", $cpf);
            $sql->bindValue(":t", $telefone);
            $sql->bindValue(":d", $dataNascimento);
            $sql->bindValue(":s", sha1($senha));
            $sql->execute();
            return true;
        }
    }

    public function logar($email, $senha)
    {

        $sql = $this->pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :e AND senha = :s");
        $sql->bindValue(":e",$email);
        $sql->bindValue(":s",sha1($senha));
        $sql->execute();
        if($sql->rowCount() > 0)
        {
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true;
        }
        else 
        {
            return false;
        }
    }
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT id_usuario, nome, email, cpf, telefone,dataNascimento FROM usuario ORDER
        BY id_usuario");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    public function excluirUsuario($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }
}
