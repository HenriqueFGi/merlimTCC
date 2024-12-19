<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); 
    $data_nascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null; 
    $genero = $_POST['genero'];

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, data_nascimento, genero) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$nome, $email, $senha, $data_nascimento, $genero])) {
            
            $usuario_id = $pdo->lastInsertId();

          
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['usuario_nome'] = $nome;

            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}
?>