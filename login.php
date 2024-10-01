<?php
require_once 'classes/usuario.php';
$u = new Usuario("essentia", "localhost", "root", "Unida010!")
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
      <div>
        <img src="assets/images/logoinpsun.png" alt="">
        <p class="login-title">
          Login
        </p>
      </div>
      <div class="login container-small">
        <form method="post" id="form-input-login">
          <div class="input-login">
            <div>
              <label class="input-label-login">E-mail</label>
              <input type="text" class="email" id="data-login" name="email">
            </div>
            <div>
              <label class="input-label-password">Senha</label>
              <input type="password" class="senha" id="data-password" name="senha">
              <div class="novo-usuario"><a href="recuperar-senha.php">Esqueci minha senha</a>
            </div>
          </div>
          <button type="submit" name="envio" class="button-default">Continuar</button>
          <div class="novo-usuario"><p>Precisa de uma conta? <a href="cadastro_usuario.php">Ainda não sou cadastrado</a></p></div>
        </form>
      </div>
    </div>
  </section>
  <?php

  if (isset($_POST['envio'])) {
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    if (!empty($email) && !empty($senha)) {
      if ($u->msgErro == "") {
        if ($u->logar($email, $senha)) {
          header("location: index.php");
        } else {
          echo "Email e/ou senha estão incorretos!";
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