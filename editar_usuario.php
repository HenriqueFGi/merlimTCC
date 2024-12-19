<?php
session_start();
include 'conexao.php';


if (!isset($_SESSION['usuario_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}


if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
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

    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, data_nascimento = ?, genero = ? WHERE id = ?");
    $stmt->execute([$nome, $email, $data_nascimento, $genero, $id]);

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="icon" href="img/Merlim.ico" type="image/x-icon">
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
            color: #294644;
        }
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #294644;
        }
        input, select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #1f3332;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #162020; 
        }
    </style>
</head>
<body>
    <h1>Editar Usuário</h1>
    <form action="editar_usuario.php?id=<?php echo $id; ?>" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo isset($usuario['nome']) ? htmlspecialchars($usuario['nome']) : ''; ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo isset($usuario['email']) ? htmlspecialchars($usuario['email']) : ''; ?>" required>

        <label>Data de Nascimento:</label>
        <input type="date" name="data_nascimento" value="<?php echo isset($usuario['data_nascimento']) ? htmlspecialchars($usuario['data_nascimento']) : ''; ?>">

        <label>Gênero:</label>
        <select name="genero">
            <option value="Masculino" <?php echo isset($usuario['genero']) && $usuario['genero'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
            <option value="Feminino" <?php echo isset($usuario['genero']) && $usuario['genero'] == 'Feminino' ? 'selected' : ''; ?>>Feminino</option>
            <option value="Outro" <?php echo isset($usuario['genero']) && $usuario['genero'] == 'Outro' ? 'selected' : ''; ?>>Outro</option>
        </select>

        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
