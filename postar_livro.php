<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $autor_id = $_SESSION['usuario_id'];

    
    $diretorioCapa = 'uploads/capas/';
    $diretorioDocs = 'uploads/docs/';

    
    if (!is_dir($diretorioCapa)) {
        mkdir($diretorioCapa, 0777, true);
    }
    if (!is_dir($diretorioDocs)) {
        mkdir($diretorioDocs, 0777, true);
    }

    $capa = $_FILES['capa'];
    $caminhoCapa = $diretorioCapa . basename($capa['name']);

    if (move_uploaded_file($capa['tmp_name'], $caminhoCapa)) {
      
    } else {
        echo "Erro ao fazer o upload da capa.";
        exit();
    }

    
    $documento = $_FILES['documento'];
    $caminhoDocumento = $diretorioDocs . basename($documento['name']);

    if (move_uploaded_file($documento['tmp_name'], $caminhoDocumento)) {
        
    } else {
        echo "Erro ao fazer o upload do documento.";
        exit();
    }

    
    $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor_id, descricao, capa, documento) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$titulo, $autor_id, $descricao, $caminhoCapa, $caminhoDocumento]);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<link rel="icon" href="img/Merlim.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Postar Livro - Merlim</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <header>
        <a href="index.php">
            <img src="img/log.png" class="logo" alt="logo">
        </a>
        <nav>
            <h1>Postar seu Livro</h1>
            <button onclick="window.location.href='index.php'">Home</button>
            <button onclick="window.location.href='postar_livro.php'">Postar Livro</button>
            <button onclick="window.location.href='livros.php'">Livros</button>
            <button onclick="window.location.href='Favoritos.php'">Favoritos</button>
            <button onclick="window.location.href='meusLivros.php'">Meus Livros</button>
        </nav>
        <div style="position: absolute; right: 10px; top: 10px;">
            <span>Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
            <button onclick="window.location.href='editar_perfil.php'">Editar Perfil</button>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </header>

    <h2>Postar Livro</h2>
    <form action="postar_livro.php" method="POST" enctype="multipart/form-data">
        
        <label>Título:</label>
        <input type="text" name="titulo" required><br>
        <label>Descrição:</label>
        <textarea name="descricao" rows="4" cols="50" required></textarea><br>
        <label>Escolha a Capa do Livro:</label>
        <input type="file" name="capa" class="capa" accept="image/*" required><br>
        <label>Escolha o Documento (.doc) do Livro:</label>
        <input type="file" name="documento" class="documento" accept=".doc,.docx,.pdf" required><br><br>

        <input type="submit" value="Postar">
    </form>
</body>
</html>
