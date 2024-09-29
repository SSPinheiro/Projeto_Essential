<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header('location: login.php');
    exit();
}
require_once('classes/produto.php');
$p = new Produto();

if (isset($_GET['id_produto'])) {
    $produto_id = $_GET['id_produto'];
    $stmt = $p->prepare("SELECT * FROM produto Where id_produto = :id");
    $stmt->execute([':id' => $produto_id]);


    if ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $caminho = $produto['caminho'];
        $nome = $produto['nome'];
        $sku = $produto['sku'];
        $descricao = $produto['descricao'];
        $valor = $produto['valor'];
        $quantidade = $produto['quantidade'];
    } else {
        echo "<h5>Produto não encontrado</h5>";
        exit();
    }
} else {
    echo "<h5>ID do produto não fornecido</h5>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar produto</title>
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
              <input type="text" class="nome-input" name="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            <div>
              <label class="input-label">Descrição</label>
              <textarea class="textarea" name="descricao" required><?php echo htmlspecialchars($descricao); ?></textarea>
            </div>
            <div class="flex-2">
              <div>
                <label class="input-label">SKU</label>
                <input type="text" class="sku-input" name="sku" name="nome" value="<?php echo htmlspecialchars($sku); ?>" required>
              </div>
              <div>
                <label class="input-label">Valor</label>
                <input type="text" class="valor-input" name="valor" name="nome" value="<?php echo htmlspecialchars($valor); ?>" required>
              </div>
              <div>
                <label class="input-label">Quantidade</label>
                <input type="text" class="valor-input" name="quantidade" name="nome" value="<?php echo htmlspecialchars($quantidade); ?>" required>
              </div>
            </div>
            <div>
              <label class="bt-arquivo" for="bt-arquivo">Alterar imagem</label>
              <input id="bt-arquivo" type="file" name="imagem" required>
            </div>
          </div>
          <button type="submit" class="button-default" name="envio">Editar produto</button>
        </form>
      </div>
    </div>
  </section>
  <?php
  // Verifica se o formulário foi enviado
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sku = $_POST['sku'];
    $valor = $_POST['valor'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];

    // Se uma nova imagem foi enviada, processa o upload
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $caminho = 'uploads/' . basename($_FILES['imagem']['name']);
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            // Atualiza o produto com nova imagem
            if ($p->atualizarProduto($produto_id, $nome, $sku, $valor, $quantidade, $descricao, $caminho)) {
                echo "Produto atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar o produto.";
            }
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        // Atualiza o produto sem mudar a imagem
        if ($p->atualizarProduto($produto_id, $nome, $sku, $valor, $quantidade, $descricao, $caminho)) {
            echo "Produto atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar o produto.";
        }
    }
  }
  ?>
</body>

</html>