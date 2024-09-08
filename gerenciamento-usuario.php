<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
  header('location: login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento de Usuario</title>
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
  <section class="page-gerenciamento-cliente paddingBottom50">
    <div class="container">
      <div class="d-flex justify-content-between">
        <a href="index.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Gerenciamento de Usuario</span>
        </a>
        <a href="cadastro-usuario.php" class="button-default bt-add">Adicionar novo usuario</a>
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>E-mail</th>
              <th>Telefone</th>
              <th>Data Nascimento</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Nome Sobrenome</td>
              <td>111.333.555-77</td>
              <td>nome.sobrenome@essentialnutrition.com.br</td>
              <td>(48) 99999-9999</td>
              <td>31/05/2002</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Nome Sobrenome</td>
              <td>111.333.555-77</td>
              <td>nome.sobrenome@essentialnutrition.com.br</td>
              <td>(48) 99999-9999</td>
              <td>29/05/2001</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>