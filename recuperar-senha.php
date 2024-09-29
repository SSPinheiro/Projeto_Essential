<?php
require_once 'classes/usuario.php';
$u = new Usuario("essentia", "localhost", "root", "Unida010!");
$perguntas = [
    "Qual é o nome do seu primeiro animal de estimação?",
    "Qual é a sua cidade natal?",
    "Qual é o nome da sua escola primária?",
    "Qual é o seu anime favorito?",
];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
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
                    <div class="input-login">
                </form>
                <form method="post" id="form-recuperacao-senha">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="pergunta-secreta">Pergunta Secreta:</label>
                    <select id="pergunta-secreta" name="pergunta-secreta" required>
                        <?php foreach ($perguntas as $pergunta): ?>
                            <option value="<?php echo htmlspecialchars($pergunta); ?>"><?php echo htmlspecialchars($pergunta); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="resposta-secreta">Resposta:</label>
                    <input type="text" id="resposta-secreta" name="resposta-secreta" required>

                    <button type="submit" name="recuperar">Recuperar Senha</button>
                </form>

            </div>
        </div>
    </section>
    <?php

    if (isset($_POST['recuperar'])) {
        $email = addslashes($_POST['email']);
        $respostaSecreta = addslashes($_POST['resposta-secreta']);

        if (!empty($email) && !empty($respostaSecreta)) {
            if ($u->msgErro == "") {
                $id_usuario = $u->recuperarConta($email, $respostaSecreta);
                if($id_usuario) {
                    header("location: mudar-senha.php?id_usuario=" . $id_usuario);
                } else {
                    echo "Email e/ou resposta estão incorretos!";
                }
            } else {
                echo "Erro: " . $u->msgErro;
            }
        } else {
            echo "Preencha todos os campos!";
        }
    };

    ?>

</body>

</html>