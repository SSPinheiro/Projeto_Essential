<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
  header('location: login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo pedido</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/novo_pedido.css">
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
  <section class="page-novo-pedido paddingBottom50">
    <div class="container">
      <div>
        <a href="novo-pedido.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Novo pedido</span>
        </a>
      </div>
      <div class="maxW340">
        <label class="input-label">Cliente</label>
        <select class="input" id="cliente" name="cliente">
          <option value="">Selecione um cliente</option>
        </select>
      </div>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Valor parcial</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <select class="input produto" name="produto[]">
                  <option value="">Selecione um produto</option>
                </select>
              </td>
              <td>
                <input type="number" class="input quantidade" name="quantidade[]" min="1">
              </td>
              <td>
                <input type="text" class="input valorParcial" name="valor[]" readonly>
              </td>
              <td><a href="#" class="bt-remover"><img src="assets/images/remover.svg" alt="" /></a></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4">
                <div class="row justify-content-between align-items-center">
                  <div class="col">
                    <a href="#" class="bt-add-produto">
                      <span>Adicionar produto</span>
                      <img src="assets/images/adicionar.svg" alt="" />
                    </a>
                  </div>
                  <div class="blc-subtotal d-flex">
                    <div class="d-flex align-items-center">
                      <span>Subtotal</span>
                      <input type="text" class="input" disabled value="572,00" />
                    </div>
                    <div class="d-flex align-items-center">
                      <span>Desconto</span>
                      <input type="text" class="input" value="100,00" />
                    </div>
                    <div class="d-flex align-items-center">
                      <span>Total</span>
                      <input type="text" class="input" disabled value="472,00" />
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="maxW340">
        <label class="input-label">Observação</label>
        <input type="text" class="input" name="observacao">
      </div>
      <div class="maxW340">
        <button type="submit" class="button-default">Salvar</button>
      </div>
    </div>
  </section>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
 $(document).ready(function() {
  $.ajax({
    url: 'pegar_clientes.php', // O arquivo PHP que busca os clientes
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      $('#cliente').empty().append('<option value="">Selecione um cliente</option>');
      $.each(data, function(index, cliente) {
        $('#cliente').append('<option value="' + cliente.id_cliente + '">' + cliente.nome + '</option>');
      });
    },
    error: function() {
      alert('Erro ao carregar os clientes.');
    }
  });

  // Carregar produtos
  $.ajax({
    url: 'pegar_produtos.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      $('.produto').each(function() {
        $(this).empty().append('<option value="">Selecione um produto</option>');

        $.each(data, function(index, produto) {
          $(this).append('<option value="' + produto.id_produto + '" data-valor="' + produto.valor + '" data-quantidade="' + produto.quantidade + '">' + produto.nome + '</option>');
        }.bind(this));
      });
    },
    error: function() {
      alert('Erro ao carregar os produtos.');
    }
  });

  // Calcular valor parcial
  $(document).on('change', '.produto', function() {
    var $linha = $(this).closest('tr');
    var valor = parseFloat($(this).find(':selected').data('valor')) || 0;
    var quantidadeMax = parseInt($(this).find(':selected').data('quantidade')) || 0;

    $linha.find('.quantidade').attr('max', quantidadeMax);
    $linha.find('.quantidade').val(1); 

    var valorParcial = valor * 1; 
    $linha.find('.valorParcial').val(valorParcial.toFixed(2));
  });

  $(document).on('input', '.quantidade', function() {
    var $linha = $(this).closest('tr');
    var valor = parseFloat($linha.find('.produto').find(':selected').data('valor')) || 0;
    var quantidadeMax = parseInt($(this).attr('max')) || 0;

    var quant = Math.min(Math.max(parseInt($(this).val()) || 0, 1), quantidadeMax);
    $(this).val(quant); 

    var valorParcial = valor * quant; 
    $linha.find('.valorParcial').val(valorParcial.toFixed(2));
  });
});

  </script>
</body>

</html>