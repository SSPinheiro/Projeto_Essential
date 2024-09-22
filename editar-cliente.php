<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header('location: login.php');
    exit();
}
require_once('classes/cliente.php');
$u = new Cliente("essentia", "localhost", "root", "Unida010!");

if (isset($_GET['id_cliente'])) {
    $cliente_id = $_GET['id_cliente'];
    $stmt = $u->prepare("SELECT * FROM cliente Where id_cliente = :id");
    $stmt->execute([':id' => $cliente_id]);


    if ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome = $cliente['nome'];
        $email = $cliente['email'];
        $cpf = $cliente['cpf'];
        $telefone = $cliente['telefone'];
    } else {
        echo "<h5>Cliente não encontrado</h5>";
        exit();
    }
} else {
    echo "<h5>ID do cliente não fornecido</h5>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
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
                    <span>Cadastro de cliente</span>
                </a>
            </div>
            <div class="container-small">
                <form method="post" id="form-cadastro-cliente">
                    <div class="bloco-inputs">
                        <div>
                            <label class="input-label">Nome</label>
                            <input type="text" class="nome-input" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required maxlength="255">
                        </div>
                        <div>
                            <label class="input-label">E-mail</label>
                            <input type="text" class="email-input" name="email" value="<?php echo htmlspecialchars($email); ?>"
                                required maxlength="255">
                        </div>
                        <div>
                            <label class="input-label">CPF</label>
                            <input type="text" class="cpf-input" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" required maxlength="11">
                        </div>
                        <div>
                            <label class="input-label">Telefone</label>
                            <input type="tel" class="telefone-input" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required maxlength="15">
                        </div>
                    </div>
                    <button type="submit" class="button-default" name="envio">Salvar alterações</button>
                </form>
            </div>
        </div>
    </section>
    <?php
    if (isset($_POST['envio'])) {
        $nome = addslashes($_POST['nome']);
        $email = addslashes($_POST['email']);
        $cpf = addslashes($_POST['cpf']);
        $telefone = addslashes($_POST['telefone']);

        // Aqui você deve atualizar o cliente no banco de dados
        if ($u->atualizarCliente($cliente_id, $nome, $email, $cpf, $telefone)) {
            echo "Cliente atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar cliente.";
        }
    }
    ?>
</body>

</html>