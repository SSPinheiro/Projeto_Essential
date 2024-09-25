<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('HTTP/1.0 403 Forbidden');
    exit();
}

include 'conexao.php'; // Inclua seu arquivo de conexão

try {
    $stmt = $conexao->prepare("SELECT id_cliente, nome FROM cliente");
    $stmt->execute();

    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($clientes);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao buscar clientes: ' . $e->getMessage()]);
}
?>
