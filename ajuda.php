<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda</title>
    <link rel="icon" href="img/Merlim.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <style>
        button[type="submit"] {
            background-color: #203735;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button[type="submit"]:hover {
            background-color: #162020;
        }
        
        .voltar{
        text-decoration: none;
        color: #203735;
        font-size: 18px;
        margin-top: 20px;
        display: inline-block;
        padding: 10px 20px;
        background-color: #f0f0f0;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .voltar:hover {
        color: #162020;
        background-color: #e1e1e1;
    }
    </style>
</head>
<header>
    <a href="index.php">
    <img src="img/log.png" class="logo" alt="logo">
</a>
        <nav>
    
        <nav>
            <button onclick="window.location.href='index.php'">Home</button>
            <button onclick="window.location.href='postar_livro.php'">Postar Livro</button>
            <button onclick="window.location.href='livros.php'">Livros</button>
            <button onclick="window.location.href='ajuda.php'">Ajuda</button>
            <button onclick="window.location.href='Favoritos.php'">Favoritos</button>
        </nav>
      
    </header>

<body><br>
<center> <h1>Ajuda</h1>
    <p>Se você precisar de ajuda, entre em contato conosco via WhatsApp. <br>
        Você pode adicionar mais detalhes à sua mensagem abaixo.</p>
    
   
    <form action="https://wa.me/5511999999999" method="get" target="_blank">
        <label for="message">Mensagem:</label>
        <textarea id="message" name="text" rows="4" cols="50" placeholder="Digite aqui sua mensagem..."></textarea><br><br>
        <button type="submit">Enviar no WhatsApp</button>
    </form>
    
    
    <a href="index.php" class="voltar">Voltar para a página inicial</a>

</body>
</html>
