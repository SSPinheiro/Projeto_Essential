<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header('location: login.php');
    exit();
}
require_once('classes/usuario.php');
$u = new Usuario("essentia", "localhost", "root", "Unida010!");

if (isset($_GET['id_usuario'])) {
    $usuario_id = $_GET['id_usuario'];
    $stmt = $u->prepare("SELECT * FROM usuario Where id_usuario = :id");
    $stmt->execute([':id' => $usuario_id]);


    if ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome = $usuario['senha'];
    } else {
        echo "<h5>Usuário não encontrado</h5>";
        exit();
    }
} else {
    echo "<h5>ID do usuário não fornecido</h5>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">
                <img src="assets/images/ho.svg" alt="" />
            </a>
            <div class="blc-user">
                <img src="assets/images/icon-feather-user.svg" alt="" />
                <span>
                    Olá, <br />
                    Lorem Ipsum
                </span>
                <img src="assets/images/arrow-down.svg" alt="" />
                <div class="menu-drop">
                    <a href="gerenciamento-cliente.php">Gerenciar clientes</a>
                    <a href="gerenciamento-produto.php">Gerenciar produtos</a>
                    <a href="gerenciamento-usuario.php">Gerenciar usuarios</a>
                    <a href="cadastro-cliente.php">Cadastrar cliente</a>
                    <a href="cadastro-usuario.php">Cadastrar usuário</a>
                    <a href="cadastro-produto.php">Cadastrar produto</a>
                    <a href="novo-pedido.php">Novo pedido</a>
                    <a href="alterar-senha.php">Alterar senha</a>
                    <a href="logout.php">Sair da conta</a>
                </div>
            </div>
        </div>
    </header>
    <section class="page-cadastro-cliente paddingBottom50">
        <div class="container">
            <div>
                <a href="cadastro-cliente.php" class="link-voltar">
                    <img src="assets/images/arrow.svg" alt="">
                    <span>Editar Usuario</span>
                </a>
            </div>
            <div class="container-small">
                <form method="post" id="form-cadastro-cliente">
                    <div class="bloco-inputs">
                        <div>
                            <label class="input-label">Senha</label>
                            <input type="password" class="password-input" name="senha" value="" required maxlength="255">
                        </div>
                    </div>
                    <button type="submit" class="button-default" name="envio">Salvar alterações</button>
                </form>
            </div>
        </div>
    </section>
    <?php
      if(isset($_POST['envio'])) {
        $senha = addslashes($_POST['senha']);

        // Aqui você deve atualizar o usuario no banco de dados
        if ($u->alterarSenha($usuario_id, $senha)) {
            echo "Senha atualizada com sucesso";
        } else {
            echo "Erro ao atualizar Usuario.";
        }
    }
    ?>
</body>

</html>