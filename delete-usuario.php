<?php 

require 'classes/usuario.php';

if (isset($_GET['id_usuario'])) {
    $id = $_GET['id_usuario'];
    $usuario = new Usuario("essentia", "localhost", "root", "Unida010!");

    if($usuario->excluirUsuario($id)) {
        echo "Registro excluído com sucesso!";
        header('Location: gerenciamento-usuario.php');
    } else {
        echo "Erro ao excluir o registro.";
        header('Location: gerenciamento-usuario.php');
    }
}else {
    echo "ID não fornecido.";
    header('Location: gerenciamento-usuario.php');
}
?>