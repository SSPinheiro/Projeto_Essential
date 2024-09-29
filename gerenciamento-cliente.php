<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['id_usuario'])) {
  header('location: login.php');
  exit();
}
require_once 'classes/cliente.php';
$c = new cliente("essentia", "localhost", "root", "Unida010!");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento de cliente</title>
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
          <a href="alterar-senha.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>">Alterar senha</a>
          <a href="relatorio-estoque.php">Relatorio de estoque</a>
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
          <span>Gerenciamento de cliente</span>
        </a>
        <a href="cadastro-cliente.php" class="button-default bt-add">Adicionar novo cliente</a>
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
              <th>Botões</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $dados = $c->buscarDados();
            if (count($dados) > 0) {
              foreach ($dados as $cliente) {
                echo "<tr>";
                echo "<td>" . $cliente['id_cliente'] . "</td>";
                echo "<td>" . $cliente['nome'] . "</td>";
                echo "<td>" . $cliente['cpf'] . "</td>";
                echo "<td>" . $cliente['email'] . "</td>";
                echo "<td>" . $cliente['telefone'] . "</td>";
            ?>
                <td>
                  <a href="editar-cliente.php?id_cliente=<?php echo $cliente['id_cliente']; ?>">Editar</a>
                  <a href="delete-cliente.php?id_cliente=<?php echo $cliente['id_cliente']; ?>" onclick='return confirm("Tem certeza que deseja excluir este registro?");'>Excluir</a>
                </td>
            <?php
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='6'>Ainda não existem clientes cadastradas!</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>