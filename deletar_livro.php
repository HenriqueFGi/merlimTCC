<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if (isset($_GET['id'])) {
    $livro_id = $_GET['id'];

    
    $sql = "SELECT autor_id FROM livros WHERE id = :livro_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':livro_id', $livro_id, PDO::PARAM_INT);
    $stmt->execute();
    $livro = $stmt->fetch();

    if ($livro) {
        if ($livro['autor_id'] == $usuario_id) {
            try {
                
                $pdo->beginTransaction();

                
                $sql_delete_favoritos = "DELETE FROM favoritos WHERE livro_id = :livro_id";
                $stmt_delete_favoritos = $pdo->prepare($sql_delete_favoritos);
                $stmt_delete_favoritos->bindValue(':livro_id', $livro_id, PDO::PARAM_INT);
                $stmt_delete_favoritos->execute();

                
                $sql_delete_livro = "DELETE FROM livros WHERE id = :livro_id";
                $stmt_delete_livro = $pdo->prepare($sql_delete_livro);
                $stmt_delete_livro->bindValue(':livro_id', $livro_id, PDO::PARAM_INT);

                if ($stmt_delete_livro->execute()) {
                    
                    $pdo->commit();

                    
                    $_SESSION['mensagem_sucesso'] = "Livro excluído com sucesso!";
                    header("Location: meusLivros.php");
                    exit();
                } else {
                    
                    $pdo->rollBack();
                    echo "Erro ao excluir o livro.";
                }
            } catch (Exception $e) {
                
                $pdo->rollBack();
                echo "Erro: " . $e->getMessage();
            }
        } else {
            echo "Você não tem permissão para excluir este livro.";
        }
    } else {
        echo "Livro não encontrado.";
    }
} else {
    echo "ID do livro não foi fornecido.";
}
?>
