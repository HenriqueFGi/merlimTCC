<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}


$usuarios = [];
try {
    $stmt = $pdo->query("SELECT id, nome, email, data_nascimento, genero FROM usuarios");
    $usuarios = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erro ao consultar usuários: " . $e->getMessage();
}


$livros = [];
try {
    $stmt = $pdo->query("SELECT id, titulo, autor_id, data_postagem FROM livros");
    $livros = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erro ao consultar livros: " . $e->getMessage();
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    if ($id == $_SESSION['usuario_id']) {
        echo "Você não pode excluir sua própria conta!";
    } else {
        try {
            
            $stmt = $pdo->prepare("DELETE FROM avaliacoes WHERE usuario_id = ?");
            $stmt->execute([$id]);

           
            $stmt = $pdo->prepare("DELETE FROM comentarios WHERE usuario_id = ?");
            $stmt->execute([$id]);

            
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);

            header("Location: admin.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao excluir usuário: " . $e->getMessage();
        }
    }
}


if (isset($_GET['excluir_livro'])) {
    $livro_id = $_GET['excluir_livro'];

    try {
        
        $stmt = $pdo->prepare("DELETE FROM avaliacoes WHERE livro_id = ?");
        $stmt->execute([$livro_id]);

       
        $stmt = $pdo->prepare("DELETE FROM comentarios WHERE livro_id = ?");
        $stmt->execute([$livro_id]);

        $stmt = $pdo->prepare("DELETE FROM livros WHERE id = ?");
        $stmt->execute([$livro_id]);

        header("Location: admin.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao excluir livro: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administração</title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color:#294644;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }
        table th {
            background-color: #294644;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
        a:hover {
            color: #357a38;
        }
        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Gerenciamento de Usuários e Livros</h1>

    <center>
    <h2>Usuários</h2></center>
    <?php if (!empty($usuarios)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Nascimento</th>
                    <th>Gênero</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['data_nascimento']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['genero']); ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a>
                            <a href="admin.php?excluir=<?php echo $usuario['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">Nenhum usuário encontrado.</p>
    <?php endif; ?>

    <center><h2>Livros</h2></center>
    <?php if (!empty($livros)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor ID</th>
                    <th>Data de Postagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td><?php echo $livro['id']; ?></td>
                        <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                        <td><?php echo $livro['autor_id']; ?></td>
                        <td><?php echo htmlspecialchars($livro['data_postagem']); ?></td>
                        <td>
                            <a href="admin.php?excluir_livro=<?php echo $livro['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">Nenhum livro encontrado.</p>
    <?php endif; ?>

    <button onclick="window.location.href='index.php'">Voltar</button>
</body>
</html>
