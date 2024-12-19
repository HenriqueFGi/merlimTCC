<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Merlim</title>
    <link rel="icon" href="img/Merlim.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <style>
     
    </style>
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
            <button onclick="window.location.href='ajuda.php'">Ajuda</button>
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
    <div class="background-container">
        <img src="img/loginfund.png" class="logologin" alt="logo">
    </div>
    <h2>Cadastre-se</h2>
    <form action="processar_cadastro.php" method="POST" enctype="multipart/form-data">
    <a href="index.php" class="fechar">X</a> 
        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Senha:</label>
        <input type="password" name="senha" required><br>

        <label>Data de Nascimento:</label>
        <input type="date" name="data_nascimento"><br>

        <label>Gênero:</label>
        <select name="genero">
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
            <option value="Outro">Outro</option>
        </select><br>

     

        <input type="submit" value="Cadastrar">
        <center><h4>Ja possui conta? <a href="login.php" class="botao">Clique aqui</a></center>
        
    </form>
</body>
</html>
