<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = 'localhost'; // ou o host do seu banco de dados
    $db = 'essentia';
    $user = 'root';
    $pass = 'Unida010!';
    try {
        $conexao = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obter dados do formulário
        $id_cliente = $_POST['cliente'];
        $observacao = $_POST['observacao'];
        $subtotal = !empty($_POST['subtotal']) ? str_replace(',', '.', $_POST['subtotal']) : 0.00;
        $desconto = !empty($_POST['desconto']) ? str_replace(',', '.', $_POST['desconto']) : 0.00;
        $total = !empty($_POST['total']) ? str_replace(',', '.', $_POST['total']) : 0.00;

        // Verificar se o cliente existe
        $stmt = $conexao->prepare("SELECT COUNT(*) FROM cliente WHERE id_cliente = :id_cliente");
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        $clienteExiste = $stmt->fetchColumn();

        if (!$clienteExiste) {
            die("Cliente não encontrado.");
        }

        // Inserir o pedido na tabela de pedidos
        $sql = "INSERT INTO pedidos (id_cliente, observacao, subtotal, desconto, total, id_usuario) VALUES (:id_cliente, :observacao, :subtotal, :desconto, :total, :id_usuario)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':desconto', $desconto);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);

        if ($stmt->execute()) {
            $id_pedido = $conexao->lastInsertId(); // ID do pedido inserido

            // Inserir produtos do pedido
            $produtos = $_POST['produto'];
            $quantidades = $_POST['quantidade'];
            $valores = $_POST['valor'];

            foreach ($produtos as $index => $id_produto) {
                $quantidade = $quantidades[$index];
                $valor = str_replace(',', '.', $valores[$index]);

                $sql_produto = "INSERT INTO pedido_produtos (id_pedido, id_produto, quantidade, valor) VALUES (:id_pedido, :id_produto, :quantidade, :valor)";
                $stmt_produto = $conexao->prepare($sql_produto);
                $stmt_produto->bindParam(':id_pedido', $id_pedido);
                $stmt_produto->bindParam(':id_produto', $id_produto);
                $stmt_produto->bindParam(':quantidade', $quantidade);
                $stmt_produto->bindParam(':valor', $valor);
                $stmt_produto->execute();
            }

            echo "Pedido salvo com sucesso!";
        } else {
            echo "Erro ao salvar o pedido.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
