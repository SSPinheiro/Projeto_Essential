<?php 

require 'classes/produto.php';

if (isset($_GET['id_produto'])) {
    $id = $_GET['id_produto'];
    $produto = new Produto();

    if($produto->excluirProduto($id)) {
        echo "Registro excluído com sucesso!";
        header('Location: gerenciamento-produto.php');
    } else {
        echo "Erro ao excluir o registro.";
        header('Location: gerenciamento-produto.php');
    }
}else {
    echo "ID não fornecido.";
    header('Location: gerenciamento-produto.php');
}
?>