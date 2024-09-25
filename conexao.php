<?php
$host = 'localhost'; // ou o host do seu banco de dados
$db = 'essentia';
$user = 'root';
$pass = 'Unida010!';

try {
    $conexao = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Conexão falhou: ' . $e->getMessage());
}
?>