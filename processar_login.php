
<?php
session_start();
include 'conexao.php';


// SENHA DO ADM
// 'admin@merlim.com', senha('admin123')


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

 
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario) {
       
        if (strlen($usuario['senha']) == 32 && md5($senha) === $usuario['senha']) {
           
            $nova_senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $update_stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
            $update_stmt->execute([$nova_senha_hash, $usuario['id']]);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['is_admin'] = $usuario['is_admin'];

            header("Location: index.php");
            exit();
        } elseif (password_verify($senha, $usuario['senha'])) {
           
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['is_admin'] = $usuario['is_admin'];

            
            header("Location: index.php");
            exit();
        } else {
          
            header("Location: login.php?erro=1");
            exit();
        }
    } else {
        
        header("Location: login.php?erro=1");
        exit();
    }
}
?>




