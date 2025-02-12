<?php
session_start();
include 'conexao.php';


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}


$usuario_id = $_SESSION['usuario_id'];


$sql = "SELECT livros.id, livros.titulo, livros.descricao, livros.data_postagem, livros.capa, livros.documento, usuarios.nome AS autor 
        FROM livros 
        JOIN usuarios ON livros.autor_id = usuarios.id
        WHERE livros.autor_id = :usuario_id
        ORDER BY livros.data_postagem DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':usuario_id', $usuario_id);
$stmt->execute();
$livros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<link rel="icon" href="img/Merlim.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Meus Livros - Merlim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .livro {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .livro img {
            width: 150px;
            height: auto;
            margin-right: 20px;
        }

        .livro-content {
            max-width: 600px;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php">
            <img src="img/log.png" class="logo" alt="logo">
        </a>
        <nav>
            <h1>Meus Livros</h1>
            <button onclick="window.location.href='index.php'">Home</button>
            <button onclick="window.location.href='postar_livro.php'">Postar Livro</button>
            <button onclick="window.location.href='livros.php'">Livros</button>
            <button onclick="window.location.href='Favoritos.php'">Favoritos</button>
            <button onclick="window.location.href='meusLivros.php'">Meus Livros</button>
        </nav>
        
        <div style="position: absolute; right: 10px; top: 10px;">
            <span>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
            <button onclick="window.location.href='editar_perfil.php'">Editar Perfil</button>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </header>
    
    <main>
        <h2>Meus Livros</h2>
        <?php if ($livros): ?>
            <?php foreach ($livros as $livro): ?>
                <div class="livro">
                    <?php if (!empty($livro['capa'])): ?>
                        <img src="<?php echo htmlspecialchars($livro['capa']); ?>" alt="Capa do Livro">
                    <?php endif; ?>
                    
                    <div class="livro-content">
                        <h3><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($livro['descricao']); ?></p>
                        <small>Autor: <?php echo htmlspecialchars($livro['autor']); ?> | Postado em: <?php echo $livro['data_postagem']; ?></small>
                        <br>
                        <a href="ler_livro.php?id=<?php echo $livro['id']; ?>">Ler Livro</a>
                        <br>
                        
                        <a href="deletar_livro.php?id=<?php echo $livro['id']; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja excluir este livro?');">Deletar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?> 
            <center><p>Você ainda não postou nenhum livro.</p></center>
        <?php endif; ?>
    </main>
</body>
</html>
