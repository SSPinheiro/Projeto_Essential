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
    $stmt = $u->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
    $stmt->execute([':id' => $usuario_id]);

    if ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome = $usuario['nome'];
        $email = $usuario['email'];
        $cpf = $usuario['cpf'];
        $telefone = $usuario['telefone'];
        $dataNascimento = $usuario['dataNascimento'];
    } else {
        echo "<h5>Usuário não encontrado</h5>";
        exit();
    }
} else {
    echo "<h5>ID do usuário não fornecido</h5>";
    exit();
}

$generalMessage = "";
$emailMessage = "";
$cpfMessage = "";
$campoVazioMessage = "";

function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $digito1 = ($soma * 10) % 11;
    if ($digito1 == 10) $digito1 = 0;

    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $digito2 = ($soma * 10) % 11;
    if ($digito2 == 10) $digito2 = 0;

    return $digito1 == $cpf[9] && $digito2 == $cpf[10];
}

if (isset($_POST['envio'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $dataNascimento = $_POST['dataNascimento'];

    if (empty($nome) || empty($email) || empty($cpf) || empty($telefone) || empty($dataNascimento)) {
        $campoVazioMessage = "Preencha todos os campos!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailMessage = "Email inválido!";
    } elseif (!validarCPF($cpf)) {
        $cpfMessage = "CPF inválido! Verifique se está correto.";
    } else {
        // Atualização no banco de dados
        if ($u->atualizarUsuario($usuario_id, $nome, $email, $cpf, $telefone, $dataNascimento)) {
            header('location: gerenciamento-usuario.php');
            exit();
        } else {
            $generalMessage = "Erro ao atualizar usuário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
                    <a href="gerenciamento-usuario.php">Gerenciar usuários</a>
                    <a href="cadastro-cliente.php">Cadastrar cliente</a>
                    <a href="cadastro-usuario.php">Cadastrar usuário</a>
                    <a href="cadastro-produto.php">Cadastrar produto</a>
                    <a href="novo-pedido.php">Novo pedido</a>
                    <a href="alterar-senha.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>">Alterar senha</a>
                    <a href="relatorio-estoque.php">Relatório de estoque</a>
                    <a href="logout.php">Sair da conta</a>
                </div>
            </div>
        </div>
    </header>
    <section class="page-cadastro-usuario paddingBottom50">
        <div class="container">
            <div>
                <a href="gerenciamento-usuario.php" class="link-voltar">
                    <img src="assets/images/arrow.svg" alt="">
                    <span>Editar Usuário</span>
                </a>
            </div>
            <div class="container-small">
                <div>
                    <?php if ($generalMessage) echo "<div class='alert error'>{$generalMessage}</div>"; ?>
                    <?php if ($emailMessage) echo "<div class='alert error'>{$emailMessage}</div>"; ?>
                    <?php if ($cpfMessage) echo "<div class='alert error'>{$cpfMessage}</div>"; ?>
                    <?php if ($campoVazioMessage) echo "<div class='alert error'>{$campoVazioMessage}</div>"; ?>
                </div>
                <form method="post" id="form-cadastro-cliente">
                    <div class="bloco-inputs">
                        <div>
                            <label class="input-label">Nome</label>
                            <input type="text" class="nome-input" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required maxlength="255">
                        </div>
                        <div>
                            <label class="input-label">E-mail</label>
                            <input type="text" class="email-input" name="email" value="<?php echo htmlspecialchars($email); ?>" required maxlength="255">
                        </div>
                        <div>
                            <label class="input-label">CPF</label>
                            <input type="text" class="cpf-input" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" required maxlength="14">
                        </div>
                        <div>
                            <label class="input-label">Telefone</label>
                            <input type="tel" class="telefone-input" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required maxlength="15">
                        </div>
                        <div>
                            <label class="input-label">Data de Nascimento</label>
                            <input type="date" class="data-input" name="dataNascimento" value="<?php echo htmlspecialchars($dataNascimento); ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="button-default" name="envio">Salvar alterações</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>