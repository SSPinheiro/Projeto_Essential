<?php

class Usuario
{
    private $pdo;
    public $msgErro = "";

    public function __construct($dbname, $host, $usuario, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $usuario, $senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilita modo de erro
        } catch (PDOException $e) {
            $this->msgErro = $e->getMessage();
        }
    }

    public function cadastrar($nome, $email, $cpf, $telefone, $dataNascimento, $senha, $perguntaSecreta, $respostaSecreta)
    {
        // Verifica se o email já existe
        $sql = $this->pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
        
        if ($sql->rowCount() > 0) {
            $this->msgErro = "Email já cadastrado!";
            return false;
        }

        // Inserção de dados
        try {
            $sql = $this->pdo->prepare("INSERT INTO usuario (nome, email, cpf, telefone, dataNascimento, senha, pergunta_secreta, resposta_secreta) VALUES (:n, :e, :c, :t, :d, :s, :p, :r)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":c", $cpf);
            $sql->bindValue(":t", $telefone);
            $sql->bindValue(":d", $dataNascimento);
            $sql->bindValue(":s", sha1($senha)); // Usando sha1 para criptografar a senha
            $sql->bindValue(':p', $perguntaSecreta);
            $sql->bindValue(':r', $respostaSecreta);
            
            $sql->execute();
            return true; // Cadastro bem-sucedido
        } catch (Exception $e) {
            $this->msgErro = "Erro ao cadastrar usuário: " . $e->getMessage();
            return false; // Cadastro falhou
        }
    }

    public function logar($email, $senha)
    {
        $sql = $this->pdo->prepare("SELECT id_usuario, senha FROM usuario WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $dado = $sql->fetch();
            if ($dado['senha'] === sha1($senha)) { // Verificando a senha
                session_start();
                $_SESSION['id_usuario'] = $dado['id_usuario'];
                return true; // Login bem-sucedido
            }
        }
        return false; // Login falhou
    }

    public function recuperarConta($email, $respostaSecreta)
    {
        $sql = $this->pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :e AND resposta_secreta = :r");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":r", $respostaSecreta);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $dado = $sql->fetch();
            return $dado['id_usuario']; // Retorna o ID do usuário
        } else {
            return false; // Retorna false se não encontrar
        }
    }

    public function buscarDados()
    {
        $cmd = $this->pdo->query("SELECT id_usuario, nome, email, cpf, telefone, dataNascimento FROM usuario ORDER BY id_usuario");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirUsuario($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function atualizarUsuario($id_usuario, $nome, $email, $cpf, $telefone, $dataNascimento)
    {
        $stmt = $this->pdo->prepare("UPDATE usuario SET nome = :nome, email = :email, cpf = :cpf, telefone = :telefone, dataNascimento = :dataNascimento WHERE id_usuario = :id");
        return $stmt->execute([':nome' => $nome, ':email' => $email, ':cpf' => $cpf, ':telefone' => $telefone, ':dataNascimento' => $dataNascimento, ':id' => $id_usuario]);
    }

    public function alterarSenha($id_usuario, $senhaCriptografada)
    {
        $senhaCriptografada = sha1($senhaCriptografada); // Usando sha1 para criptografar a nova senha
        $stmt = $this->pdo->prepare("UPDATE usuario SET senha = :senha WHERE id_usuario = :id");
        return $stmt->execute([':senha' => $senhaCriptografada, ':id' => $id_usuario]);
    }
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}
?>
