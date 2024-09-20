<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
  header('location: login.php');
  exit();
}
require_once 'classes/usuario.php';
$u = new Usuario("essentia", "localhost", "root", "Unida010!");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de usuário</title>
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
  <section class="page-cadastro-usuario paddingBottom50">
    <div class="container">
      <div>
        <a href="cadastro-usuario.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Cadastro de usuário</span>
        </a>
      </div>
      <div class="container-small">
        <form method="post" id="form-cadastro-usuario">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome" required maxlength="255">
            </div>
            <div>
              <label class="input-label">E-mail</label>
              <input type="text" class="email-input" name="email" required maxlength="255">
            </div>
            <div>
              <label class="input-label">CPF</label>
              <input type="text" class="cpf-input" name="cpf" required maxlength="11">
            </div>
            <div>
              <label class="input-label">Telefone</label>
              <input type="tel" class="telefone-input" name="telefone" required maxlength="15">
            </div>
            <div>
              <label class="input-label">Data de Nascimento</label>
              <input type="date" class="date-nascimento" name="data-nascimento" required>
            </div>
            <div>
              <label class="input-label">Senha</label>
              <input type="password" class="senha-input" name="senha" required maxlength="40">
            </div>
          </div>
          <button type="submit" name="envio" class="button-default">Salvar novo usuário</button>
        </form>
      </div>
    </div>
  </section>
  <?php

  if(isset($_POST['envio'])) {
    $nome = addslashes($_POST['nome']);
    $email = addslashes($_POST['email']);
    $cpf = addslashes($_POST['cpf']);
    $telefone = addslashes($_POST['telefone']);
    $dataNascimento = addslashes($_POST['data-nascimento']);
    $senha = addslashes($_POST['senha']);

    if (!empty($nome) && !empty($email) && !empty($cpf) && !empty($telefone) && !empty($dataNascimento) && !empty($senha)) {
      if ($u->msgErro == "") {
        if ($u->cadastrar($nome, $email, $cpf, $telefone, $dataNascimento, $senha)) {
          echo "cadastrado com sucesso acesse para entrar!";
        } else {
          echo "email ja cadastrado!";
        }
      } else {
        echo "Erro: " . $u->msgErro;
      }
    } else {
      echo "Preencha Todos os campos!";
    }
  }

  ?>
</body>

</html>