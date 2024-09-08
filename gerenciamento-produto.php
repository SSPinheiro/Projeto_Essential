<?php
session_start();
if(!isset($_SESSION['id_usuario'])){
  header("location: login.php");
  exit();
}
 ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento de produto</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/gerenciamento_produto.css">
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
  <section class="page-gerenciamento-produto paddingBottom50">
    <div class="container">
      <div class="d-flex justify-content-between">
        <a href="index.html" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Gerenciamento de produto</span>
        </a>
        <a href="cadastro-produto.html" class="bt-add">Adicionar novo produto</a>
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Imagem</th>
              <th>Nome</th>
              <th>SKU</th>
              <th>Descrição</th>
              <th>Valor</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td><img src="assets/images/image-happy-theanine.jpg" class="img-produto" alt="" /></td>
              <td>Happy Theanine</td>
              <td>14585</td>
              <td><span class="descr">Produto formulado com L-teanina pura e concentrada — uma poderosa substância
                  bioativa encontrada
                  naturalmente nas folhas de Camellia sinensis</span></td>
              <td>R$ 160,00</td>
            </tr>
            <tr>
              <td>2</td>
              <td><img src="assets/images/image-happy-theanine.jpg" class="img-produto" alt="" /></td>
              <td>Happy Theanine</td>
              <td>14585</td>
              <td><span class="descr">Produto formulado com L-teanina pura e concentrada — uma poderosa substância
                  bioativa encontrada
                  naturalmente nas folhas de Camellia sinensis</span></td>
              <td>R$ 160,00</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>