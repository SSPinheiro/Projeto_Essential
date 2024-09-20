<?php 

require 'classes/cliente.php';

if (isset($_GET['id_cliente'])) {
    $id = $_GET['id_cliente'];
    $cliente = new Cliente("essentia", "localhost", "root", "Unida010!");

    if($cliente->excluirCliente($id)) {
        echo "Registro excluído com sucesso!";
        header('Location: gerenciamento-cliente.php');
    } else {
        echo "Erro ao excluir o registro.";
        header('Location: gerenciamento-cliente.php');
    }
}else {
    echo "ID não fornecido.";
    header('Location: gerenciamento-cliente.php');
}
?>