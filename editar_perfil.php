<?php
session_start();
include 'conexao.php';


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}


$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $biografia = $_POST['biografia'];

    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, data_nascimento = ?, genero = ?, biografia = ? WHERE id = ?");
    $stmt->execute([$nome, $email, $data_nascimento, $genero, $biografia, $usuario_id]);

  
    $_SESSION['usuario_nome'] = $nome;

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Editar Perfil</h2>
    <form action="editar_perfil.php" method="POST">
    <a href="index.php" class="fechar">X</a><br>
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br><br>

        <label>Data de Nascimento:</label><br>
        <input type="date" name="data_nascimento" value="<?php echo htmlspecialchars($usuario['data_nascimento']); ?>"><br><br>

        <label>Gênero:</label><br>
        <select name="genero">
            <option value="Masculino" <?php if ($usuario['genero'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
            <option value="Feminino" <?php if ($usuario['genero'] == 'Feminino') echo 'selected'; ?>>Feminino</option>
            <option value="Outro" <?php if ($usuario['genero'] == 'Outro') echo 'selected'; ?>>Outro</option>
        </select><br><br>

    

        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
