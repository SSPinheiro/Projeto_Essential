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
  <title>Index</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/index.css">
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
          <a href="cadastro-cliente.php">Cadastrar cliente</a>
          <a href="cadastro-usuario.php">Cadastrar usuário</a>
          <a href="cadastro-produto.php">Cadastrar produto</a>
          <a href="novo-pedido.php">Novo pedido</a>
          <a href="logout.php">Sair da conta</a>
        </div>
      </div>

    </div>
  </header>
  <section class="page-index">
    <div class="container">
      <div class="dash-index">
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Clientes</h2>
              <span>444</span>
            </div>
            <img src="assets/images/icon-users.svg" alt="">
          </div>
          <a href="gerenciamento-cliente.html" class="bt-index">Gerenciar clientes</a>
        </div>
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Produtos</h2>
              <span>444</span>
            </div>
            <img src="assets/images/icon-product.svg" style="max-width: 76px;" alt="">
          </div>
          <a href="gerenciamento-produto.html" class="bt-index">Gerenciar produto</a>
        </div>
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Pedidos</h2>
              <span>444</span>
            </div>
            <img src="assets/images/icon-pedido.svg" alt="">
          </div>
          <a href="novo-pedido.html" class="bt-index">Novo pedido</a>
        </div>
      </div>
    </div>
  </section>
</body>

</html>