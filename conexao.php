<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$dbname = 'merlim';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
