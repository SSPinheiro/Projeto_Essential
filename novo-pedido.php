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
                    <a href="alterar-senha.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>">Alterar senha</a>
                    <a href="relatorio-estoque.php">Relatorio de estoque</a>
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

            <!-- Mensagem de sucesso ou erro -->
            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="mensagem">
                    <p><?php echo $_SESSION['mensagem']; ?></p>
                </div>
                <?php unset($_SESSION['mensagem']); // Limpa a mensagem após exibir ?>
            <?php endif; ?>

            <form action="salvar_pedido.php" method="POST">
                <div class="maxW340">
                    <label class="input-label">Cliente</label>
                    <select class="input" id="cliente" name="cliente" required>
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
                        <tbody id="produto-body">
                            <tr class="produto-linha">
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
                                                <input type="text" class="input" disabled value="0,00" />
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span>Desconto</span>
                                                <input type="text" class="input" disabled value="0,00" />
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span>Total</span>
                                                <input type="text" class="input" disabled value="0,00" />
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
                <!-- Campos ocultos para subtotal, desconto e total -->
                <input type="hidden" name="subtotal" value="0.00">
                <input type="hidden" name="desconto" value="0.00">
                <input type="hidden" name="total" value="0.00">
                <div class="maxW340">
                    <button type="submit" class="button-default">Salvar</button>
                </div>
            </form>
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

            function atualizarProdutos() {
                var produtosSelecionados = [];

                // Coleta produtos já selecionados
                $('.produto').each(function() {
                    var valor = $(this).val();
                    if (valor) {
                        produtosSelecionados.push(valor);
                    }
                });

                // Atualiza as opções dos produtos em todas as linhas
                $('.produto').each(function() {
                    var $select = $(this);
                    $select.find('option').each(function() {
                        var $option = $(this);
                        if (produtosSelecionados.includes($option.val()) && $option.val() !== $select.val()) {
                            $option.prop('disabled', true);
                        } else {
                            $option.prop('disabled', false);
                        }
                    });
                });
            }

            function calcularSubtotal() {
                let subtotal = 0;
                let totalProdutos = 0;

                $('.valorParcial').each(function() {
                    const valor = parseFloat($(this).val()) || 0;
                    subtotal += valor;

                    const quantidade = parseInt($(this).closest('tr').find('.quantidade').val()) || 0;
                    totalProdutos += quantidade;
                });

                // Calcular o desconto apenas se totalProdutos for um múltiplo de 10
                const descontoPorDez = Math.floor(totalProdutos / 10) * 10;
                const total = subtotal - descontoPorDez;

                // Atualizar os campos
                $('.blc-subtotal input').eq(0).val(subtotal.toFixed(2)); // Subtotal
                $('.blc-subtotal input').eq(1).val(descontoPorDez.toFixed(2)); // Desconto
                $('.blc-subtotal input').eq(2).val(total.toFixed(2)); // Total

                $('input[name="subtotal"]').val(subtotal.toFixed(2));
                $('input[name="desconto"]').val(descontoPorDez.toFixed(2));
                $('input[name="total"]').val(total.toFixed(2));
            }

            // Calcular valor parcial
            $(document).on('change', '.produto', function() {
                var $linha = $(this).closest('tr');
                var valor = parseFloat($(this).find(':selected').data('valor')) || 0;
                var quantidadeMax = parseInt($(this).find(':selected').data('quantidade')) || 0;

                $linha.find('.quantidade').attr('max', quantidadeMax);
                $linha.find('.quantidade').val(1); // Resetar quantidade para 1

                var valorParcial = valor * 1;
                $linha.find('.valorParcial').val(valorParcial.toFixed(2));
                calcularSubtotal(); // Atualiza subtotal aqui
            });

            // Atualizar subtotal ao mudar a quantidade
            $(document).on('input', '.quantidade', function() {
                var $linha = $(this).closest('tr');
                var valor = parseFloat($linha.find('.produto').find(':selected').data('valor')) || 0;
                var quantidadeMax = parseInt($(this).attr('max')) || 0;

                var quant = Math.min(Math.max(parseInt($(this).val()) || 0, 1), quantidadeMax);
                $(this).val(quant);

                var valorParcial = valor * quant;
                $linha.find('.valorParcial').val(valorParcial.toFixed(2));

                // Aqui chamamos a função de subtotal após a alteração da quantidade
                calcularSubtotal();
            });

            // Adicionar nova linha de produto
            $(document).on('click', '.bt-add-produto', function(e) {
                e.preventDefault();
                var novaLinha = $('.produto-linha').first().clone(); // Clonando a primeira linha
                novaLinha.find('select').val('').end().find('.quantidade').val(1).end().find('.valorParcial').val('');
                $('#produto-body').append(novaLinha); // Adicionando a nova linha à tabela
                atualizarProdutos();
            });

            // Remover linha de produto
            $(document).on('click', '.bt-remover', function(e) {
                e.preventDefault();
                if ($('#produto-body .produto-linha').length > 1) {
                    $(this).closest('tr').remove(); // Remover a linha
                    atualizarProdutos(); // Atualiza as opções após remover uma linha
                } else {
                    alert('Você precisa ter pelo menos uma linha de produto.');
                }
            });

            // Atualizar valores ocultos antes de enviar o formulário
            $('form').on('submit', function() {
                let subtotal = parseFloat($('.blc-subtotal input').eq(0).val().replace(',', '.')) || 0;
                let desconto = parseFloat($('.blc-subtotal input').eq(1).val().replace(',', '.')) || 0;
                let total = parseFloat($('.blc-subtotal input').eq(2).val().replace(',', '.')) || 0;

                $('input[name="subtotal"]').val(subtotal.toFixed(2));
                $('input[name="desconto"]').val(desconto.toFixed(2));
                $('input[name="total"]').val(total.toFixed(2));
            });
        });
    </script>
</body>

</html>
