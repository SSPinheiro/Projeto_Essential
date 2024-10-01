<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
  header('location: login.php');
  exit();
}
require_once('classes/produto.php');
$p = new produto();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de produto</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/cadastro_produto.css">
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
          Lorem
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
          <a href="relatorio-estoque.php">Relatorio de estoque</a>  
          <a href="logout.php">Sair da conta</a>
        </div>
      </div>
    </div>
  </header>
  <section class="page-cadastro-produto paddingBottom50">
    <div class="container">
      <div>
        <a href="cadastro-produto.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Cadastro de produto</span>
        </a>
      </div>
      <div class="container-small">
        <form action="" method="post" enctype="multipart/form-data" id="form-cadastro-produto">
          <div class="bloco-inputs">
            <div>
              <label class="input-label">Nome</label>
              <input type="text" class="nome-input" name="nome" required>
            </div>
            <div>
              <label class="input-label">Descrição</label>
              <textarea class="textarea" name="descricao" required></textarea>
            </div>
            <div class="flex-2">
              <div>
                <label class="input-label">SKU</label>
                <input type="text" class="sku-input" name="sku" required>
              </div>
              <div>
                <label class="input-label">Valor</label>
                <input type="text" class="valor-input" name="valor" required>
              </div>
              <div>
                <label class="input-label">Quantidade</label>
                <input type="text" class="valor-input quantidade-input" name="quantidade" required>
              </div>
            </div>
            <div>
              <label class="bt-arquivo" for="bt-arquivo">Adicionar imagem</label>
              <input id="bt-arquivo" type="file" name="imagem" required>
            </div>
          </div>
          <button type="submit" class="button-default" name="envio">Salvar novo produto</button>
        </form>
      </div>
    </div>
  </section>
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const skuInput = document.querySelector('.sku-input');
      const valorInput = document.querySelector('.valor-input');
      const quantidadeInput = document.querySelector('.quantidade-input');

      const validateNumberInput = (input) => {
        input.addEventListener('input', function() {
          this.value = this.value.replace(/[^0-9]/g, ''); 
        });
      };

      validateNumberInput(skuInput);
      validateNumberInput(valorInput);
      validateNumberInput(quantidadeInput);
    });
  </script>

  <?php

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sku = $_POST['sku'];
    $valor = $_POST['valor'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];

    if (!empty($nome) && !empty($sku) && !empty($valor) && !empty($quantidade) && !empty($descricao)) {
      if (ctype_digit($sku) && is_numeric($valor) && ctype_digit($quantidade)) {
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
          $caminho = 'uploads/' . basename($_FILES['imagem']['name']);


          if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {

            if ($p->insertProduto($nome, $sku, $valor, $quantidade, $descricao, $caminho)) {
              echo "Produto carregado e dados salvos com sucesso!";
            } else {
              echo "Erro ao salvar o produto.";
            }
          } else {
            echo "Erro ao mover o arquivo.";
          }
        } else {
          echo "Erro no upload da imagem.";
        }
      } else {
        echo "SKU e quantidade devem ser números inteiros e valor deve ser numérico.";
      }
    }
  }
  ?>
</body>

</html>
