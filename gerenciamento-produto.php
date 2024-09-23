<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['id_usuario'])) {
  header("location: login.php");
  exit();
}
require_once 'classes/produto.php';
$p = new produto();
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
  <section class="page-gerenciamento-produto paddingBottom50">
    <div class="container">
      <div class="d-flex justify-content-between">
        <a href="index.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Gerenciamento de produto</span>
        </a>
        <a href="cadastro-produto.php" class="bt-add">Adicionar novo produto</a>
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
              <th>Quantidade</th>
              <th>Botões</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $dados = $p->buscarDados();
            if (count($dados) > 0) {
              foreach ($dados as $produto) {
                echo "<tr>";
                echo "<td>" . $produto['id_produto'] . "</td>";
                echo "<td>
                <div class='produto-imagem'>
                    <img class='img-produto' src='" . htmlspecialchars($produto['caminho']) . "' alt='" . htmlspecialchars($produto['nome']) . "'>
                </div>
              </td>";
              echo "<td>
                <span>" . htmlspecialchars($produto['nome']) . "</span>
              </td>";
                echo "<td>" . $produto['sku'] . "</td>";
                echo "<td>" . $produto['descricao'] . "</td>";
                echo "<td>" . $produto['valor'] . "</td>";
                echo "<td>" . $produto['quantidade'] . "</td>";
            ?>
                <td>
                  <a href="editar-produto.php?id_produto=<?php echo $produto['id_produto']; ?>">Editar</a>
                  <a href="delete-produto.php?id_produto=<?php echo $produto['id_produto']; ?>" onclick='return confirm("Tem certeza que deseja excluir este registro?");'>Excluir</a>
                </td>
            <?php
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='8'>Ainda não existem produtos cadastradas!</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>