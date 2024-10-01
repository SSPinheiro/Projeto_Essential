<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('location: login.php');
    exit();
}
require_once('classes/cliente.php');
$u = new Cliente("essentia", "localhost", "root", "Unida010!");

$generalMessage = ""; 
$emailMessage = ""; 
$cpfMessage = ""; 
$campoVazioMessage = ""; 

function validarCPF($cpf) {
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

if (isset($_GET['id_cliente'])) {
    $cliente_id = $_GET['id_cliente'];
    $stmt = $u->prepare("SELECT * FROM cliente WHERE id_cliente = :id");
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000');
            $('#cpf').mask('000.000.000-00');

            $('.nome-input').on('keypress', function(e) {
                const charCode = (typeof e.which === "undefined") ? e.keyCode : e.which;
                if (charCode >= 48 && charCode <= 57) {
                    e.preventDefault();
                }
            });

            $('#form-cadastro-cliente').on('submit', function(e) {
                const email = $('#email').val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert("Email inválido!");
                    e.preventDefault();
                    return;
                }

                const cpf = $('#cpf').val().replace(/\D/g, '');
                if (!validarCPF(cpf)) {
                    alert("CPF inválido!");
                    e.preventDefault();
                    return;
                }
            });

            function validarCPF(cpf) {
                if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
                    return false;
                }
                let soma = 0;
                for (let i = 0; i < 9; i++) {
                    soma += Number(cpf[i]) * (10 - i);
                }
                let digito1 = (soma * 10) % 11;
                if (digito1 === 10) digito1 = 0;

                soma = 0;
                for (let i = 0; i < 10; i++) {
                    soma += Number(cpf[i]) * (11 - i);
                }
                let digito2 = (soma * 10) % 11;
                if (digito2 === 10) digito2 = 0;

                return digito1 === Number(cpf[9]) && digito2 === Number(cpf[10]);
            }
        });
    </script>
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
                    <a href="alterar-senha.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>">Alterar senha</a>
                    <a href="relatorio-estoque.php">Relatório de estoque</a>
                    <a href="logout.php">Sair da conta</a>
                </div>
            </div>
        </div>
    </header>
    <section class="page-cadastro-cliente paddingBottom50">
        <div class="container">
            <div>
                <a href="gerenciamento-cliente.php" class="link-voltar">
                    <img src="assets/images/arrow.svg" alt="">
                    <span>Editar cliente</span>
                </a>
            </div>
            <div class="container-small">
                <div>
                    <?php echo $generalMessage; ?>
                    <p class="error-message"><?php echo $emailMessage; ?></p>
                    <p class="error-message"><?php echo $cpfMessage; ?></p>
                    <p class="error-message"><?php echo $campoVazioMessage; ?></p>
                </div>
                <form method="post" id="form-cadastro-cliente">
                    <div class="bloco-inputs">
                        <div>
                            <label class="input-label">Nome</label>
                            <input type="text" class="nome-input" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required maxlength="255">
                        </div>
                        <div>
                            <label class="input-label">E-mail</label>
                            <input type="text" class="email-input" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required maxlength="255">
                        </div>
                        <div>
                            <label class="input-label">CPF</label>
                            <input type="text" class="cpf-input" id="cpf" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" required maxlength="14">
                        </div>
                        <div>
                            <label class="input-label">Telefone</label>
                            <input type="tel" class="telefone-input" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required maxlength="15">
                        </div>
                    </div>
                    <button type="submit" class="button-default" name="envio">Salvar alterações</button>
                </form>
            </div>
        </div>
    </section>
    <?php
    if (isset($_POST['envio'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailMessage = "Email inválido!";
        } elseif (!validarCPF($cpf)) {
            $cpfMessage = "CPF inválido! Verifique se está correto.";
        } elseif (empty($nome) || empty($email) || empty($cpf) || empty($telefone)) {
            $campoVazioMessage = "Preencha todos os campos!";
        } else {
            if ($u->atualizarCliente($cliente_id, $nome, $email, $cpf, $telefone)) {
                header('location: gerenciamento-cliente.php');
                exit();
            } else {
                echo "Erro ao atualizar cliente.";
            }
        }
    }
    ?>
</body>

</html>
