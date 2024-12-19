<?php
session_start();
include 'conexao.php';


if (!isset($_GET['id'])) {
    header("Location: livros.php");
    exit();
}

$livro_id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM livros WHERE id = ?");
$stmt->execute([$livro_id]);
$livro = $stmt->fetch();

if (!$livro) {
    echo "Livro não encontrado.";
    exit();
}


$avaliacoes_stmt = $pdo->prepare("SELECT AVG(nota) AS media_avaliacao FROM avaliacoes WHERE livro_id = ?");
$avaliacoes_stmt->execute([$livro_id]);
$media_avaliacao = $avaliacoes_stmt->fetchColumn();

$comentarios_stmt = $pdo->prepare("SELECT comentarios.comentario, usuarios.nome, comentarios.data_comentario FROM comentarios JOIN usuarios ON comentarios.usuario_id = usuarios.id WHERE livro_id = ?");
$comentarios_stmt->execute([$livro_id]);
$comentarios = $comentarios_stmt->fetchAll();


$usuario_id = $_SESSION['usuario_id'] ?? null;
$ja_avaliou = false;

if ($usuario_id) {
    $verifica_avaliacao_stmt = $pdo->prepare("SELECT COUNT(*) FROM avaliacoes WHERE livro_id = ? AND usuario_id = ?");
    $verifica_avaliacao_stmt->execute([$livro_id, $usuario_id]);
    $ja_avaliou = $verifica_avaliacao_stmt->fetchColumn() > 0;
}


$favoritado = false;

if ($usuario_id) {
    $verifica_favorito_stmt = $pdo->prepare("SELECT COUNT(*) FROM favoritos WHERE livro_id = ? AND usuario_id = ?");
    $verifica_favorito_stmt->execute([$livro_id, $usuario_id]);
    $favoritado = $verifica_favorito_stmt->fetchColumn() > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nota']) && !empty($_POST['nota']) && !$ja_avaliou) {
      
        $nota = $_POST['nota'];
        $stmt = $pdo->prepare("INSERT INTO avaliacoes (livro_id, usuario_id, nota) VALUES (?, ?, ?)");
        $stmt->execute([$livro_id, $usuario_id, $nota]);
    }

    if (isset($_POST['comentario']) && !empty($_POST['comentario'])) {
       
        $comentario = $_POST['comentario'];
        $stmt = $pdo->prepare("INSERT INTO comentarios (livro_id, usuario_id, comentario, data_comentario) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$livro_id, $usuario_id, $comentario]);
    }

    
    if (isset($_POST['favoritar'])) {
        if ($favoritado) {
           
            $stmt = $pdo->prepare("DELETE FROM favoritos WHERE livro_id = ? AND usuario_id = ?");
            $stmt->execute([$livro_id, $usuario_id]);
        } else {
           
            $stmt = $pdo->prepare("INSERT INTO favoritos (livro_id, usuario_id) VALUES (?, ?)");
            $stmt->execute([$livro_id, $usuario_id]);
        }
       
        header("Location: ler_livro.php?id=" . $livro_id);
        exit();
    }

    header("Location: ler_livro.php?id=" . $livro_id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<link rel="icon" href="img/Merlim.ico" type="image/x-icon">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($livro['titulo']); ?> - Merlim</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/Merlim.ico" type="image/x-icon">
</head>
<body>
<header>
    <a href="index.php">
    <img src="img/log.png" class="logo" alt="logo">
</a>
        
    <nav>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
            <button onclick="window.location.href='admin.php'">Administração</button>
        <?php endif; ?>

        <button onclick="window.location.href='index.php'">Home</button>
        <button onclick="window.location.href='postar_livro.php'">Postar Livro</button>
        <button onclick="window.location.href='livros.php'">Livros</button>
        <button onclick="window.location.href='Favoritos.php'">Favoritos</button>
        <button onclick="window.location.href='meusLivros.php'">Meus Livros</button>
    </nav>
    <div style="position: absolute; right: 10px; top: 10px;">
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <span>Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
            <button onclick="window.location.href='editar_perfil.php'">Editar Perfil</button>
            <button onclick="window.location.href='logout.php'">Logout</button>
        <?php else: ?>
            <button onclick="window.location.href='cadastro.php'">Cadastrar-se</button>
            <button onclick="window.location.href='login.php'">Login</button>
        <?php endif; ?>
    </div>
</header>
 
<main>
   
    <div class="livro-conteudo">
        
        <div class="livro-titulo">
            <h1><?php echo htmlspecialchars($livro['titulo']); ?></h1>
        </div>
        <div class="container-capa-desc">
       
        <div class="capa-livro">
            <?php if (!empty($livro['capa'])): ?>
                <img src="<?php echo htmlspecialchars($livro['capa']); ?>" alt="Capa do Livro">
            <?php endif; ?>
        </div>

       
        <div class="livro-descricao">
            <p><?php echo nl2br(htmlspecialchars($livro['descricao'])); ?></p>
            <?php if (!empty($livro['documento'])): ?>
               
                <a href="<?php echo htmlspecialchars($livro['documento']); ?>" target="_blank" class="download-link direita">Baixar Documento</a>
            <?php endif; ?>
            <form method="POST" style="box-shadow: none; border: none; width: 100%;">
        
                <?php if ($favoritado): ?>
                    <button class="button" type="submit" name="favoritar" value="desfavoritar"><i class="bi bi-bookmark-check-fill"></i></button>
                <?php else: ?>
                    <button class="button" type="submit" name="favoritar" value="favoritar"><i class="bi bi-bookmark-check"></i></button>
                
                <?php endif; ?>
                </div>
            </form>
        </div>
        
           
</div>
        
        
        <div class="formulario-avaliacao">
            <?php if (!$ja_avaliou): ?>
                <form method="POST">
                    <div>
                        <label>Avalie o Livro:</label>
                        <select name="nota">
                            <option value="">Escolha uma nota</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <input type="submit" value="Avaliar">
                </form>
            <?php else: ?>
                <p>Você já avaliou este livro.</p>
            <?php endif; ?>
        </div>

       
        <div class="formulario-comentario">
            <form method="POST">
                <div>
                    <label>Deixe seu Comentário:</label>
                    <textarea name="comentario"></textarea>
                </div>
                <input type="submit" value="Comentar">
            </form>
        </div>

        
        <div class="avaliacao-media">
            <h3>Média de Avaliação: <?php echo $media_avaliacao ? round($media_avaliacao, 2) : "Nenhuma avaliação"; ?></h3>
        </div>

        
        <div class="comentarios">
            <h3>Comentários:</h3><br>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="comentario">
                    <strong><?php echo htmlspecialchars($comentario['nome']); ?>:</strong>
                    <p><?php echo nl2br(htmlspecialchars($comentario['comentario'])); ?></p>
                    <small><?php echo $comentario['data_comentario']; ?></small>
                </div>
            <?php endforeach; ?>
        </div>

        
    </div>
    
</main>
</body>
</html>
