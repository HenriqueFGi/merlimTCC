<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Merlim</title>
    <link rel="icon" href="img/Merlim.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
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
   <br>
    <form action="processar_login.php" method="POST">
        <a href="index.php" class="fechar">X</a><br>
        <center><h1>Realize seu login</h1>
        <h4>Não possui conta? <a href="cadastro.php" class="botao">Crie aqui</a>
        </center><br>
         
        <input type="email" name="email" placeholder="Email" required><br><br>
        
        <input type="password" name="senha" placeholder="Senha" required><br><br>

        <input type="submit" value="Entrar">
     
        <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
            <p style="color: red; text-align: center;">Email ou senha inválidos. Tente novamente.</p>
        <?php endif; ?>
    </form>
</body>
</html>
