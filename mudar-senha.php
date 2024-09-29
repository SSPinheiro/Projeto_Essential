<?php
require_once 'classes/usuario.php';
$u = new Usuario("essentia", "localhost", "root", "Unida010!");
if (isset($_GET['id_usuario'])) {
    $usuario_id = $_GET['id_usuario'];
    $stmt = $u->prepare("SELECT * FROM usuario Where id_usuario = :id");
    $stmt->execute([':id' => $usuario_id]);


    if ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $email = $usuario['email'];
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
    <title>Mudar Senha</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">
                <img src="assets/images/ho.svg" alt="" />
            </a>
        </div>
    </header>
    <section class="page-login">
        <div class="container-login">
            <div class="login container-small">
                <form method="post" id="form-input-login">
                    <div>
                        <label class="input-label">E-mail</label>
                        <input type="text" class="email-input" name="email" value="<?php echo htmlspecialchars($email); ?>"
                            required maxlength="255" readonly>
                    </div>
                    <div>
                        <label class="input-label-password">Nova Senha</label>
                        <input type="password" class="senha" id="data-password" name="senha">
                    </div>
            </div>
            <button type="submit" name="envio" class="button-default">Continuar</button>
        </div>
        </form>
        </div>
        </div>
    </section>
    <?php

    if (isset($_POST['envio'])) {
        $senha = addslashes($_POST['senha']);
        $email = addslashes($_POST['email']);

        if (!empty($senha)) {
            if ($u->msgErro == "") {
                if ($u->alterarSenha($usuario_id, $senha)) {

                    header("location: login.php");
                }
            } else {
                echo "Erro: " . $u->msgErro;
            }
        }
    }

    ?>
</body>

</html>