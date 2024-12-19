<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>



    <meta charset="UTF-8">
    <title>Merlim - Página Inicial</title>
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
            <button onclick="window.location.href='Favoritos.php'">Favoritos</button>
            <button onclick="window.location.href='meusLivros.php'">Meus Livros</button>
            
            
        </nav>
        <div style="position: absolute; right: 10px; top: 10px;">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span>Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
    <button onclick="window.location.href='editar_perfil.php'">Editar Perfil</button>
    <button onclick="window.location.href='logout.php'">Logout</button><br>
    
            <?php else: ?>
                <button onclick="window.location.href='cadastro.php'">Cadastrar-se</button>
                <button onclick="window.location.href='login.php'">Login</button>
            <?php endif; ?>
        </div>
    </header>
 
    <section class="titulo-merlim">
    <center>
        <br>
        
        <h1>Bem-vindo ao Merlim</h1>
        
        <p>Explore nossa comunidade de histórias ou poste seu próprio livro! <br>
            Merlim é um espaço onde leitores e escritores podem se conectar, compartilhar e descobrir novos mundos através da literatura.</p>
            </h4>

        
        <div class="img-destaque">
            <img src="img/fundo.png" alt="Merlim - Comunidade Literária" />
        </div>
        <br>

    
        <section class="sobre-merlim">
            <h3>Sobre o Merlim</h3>
            <p>Merlim é uma plataforma que oferece aos escritores a possibilidade de compartilhar suas histórias com o mundo e aos leitores o prazer de explorar novos livros. <br>
                Com uma interface amigável, você pode facilmente postar seu livro, interagir com a comunidade e até mesmo baixar livros para leitura offline.</p>
                
            <div class="cards">
                <div class="card">
                    <img src="img/livro.jpeg" alt="Ícone de Livro">
                    <h4>Compartilhe Suas Histórias</h4>
                    <p>Publique seu livro em minutos e comece a compartilhar suas criações com a comunidade.</p>
                </div>
                <div class="card">
                    <img src="img/comunidade.png" alt="Ícone de Comunidade">
                    <h4>Conecte-se com Leitores</h4>
                    <p>Receba feedback dos leitores e interaja diretamente com aqueles que amam suas histórias.</p>
                </div>
                <div class="card">
                    <img src="img/baixar.png" alt="Ícone de Download">
                    <h4>Baixe Livros</h4>
                    <p>Baixe seus livros favoritos para ler offline, sempre que desejar.</p>
                </div>
            </div>
        </section>

       
<br>
<br>


        <footer class="footer">
    <section class="contato">
        <h3>Fale Conosco</h3>
        <p>Tem alguma dúvida? Entre em contato conosco para mais informações ou suporte!</p>
        <a href="ajuda.php" class="voltar">Ir para a página de Ajuda</a>
    </section>
    <section class="informacoes">
        <p>&copy; 2024 Merlim - Todos os direitos reservados.</p>
   
    </section>
</footer>
    </center>
    

</body>
</html>
