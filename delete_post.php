<?php
session_start();

// Conectar ao banco de dados (substitua com suas credenciais)
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'movie_critic';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Verificar se o usuário está logado e é administrador ou o próprio usuário que adicionou o filme
if (isset($_SESSION['user_id']) && ($_SESSION['is_admin'] || $_SESSION['user_id'] == $_GET['user_id'])) {
    // Verificar se o parâmetro 'id' está presente na URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $filme_id = (int)$_GET['id'];

        // Preparar a consulta para excluir o filme
        $sql = "DELETE FROM filmes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $filme_id);

        // Executar a consulta
        if (mysqli_stmt_execute($stmt)) {
            // Redirecionar para a página inicial após a exclusão
            header('Location: index.php?message=Filme excluído com sucesso');
        } else {
            echo "Erro ao excluir o filme: " . mysqli_error($conn);
        }

        // Fechar a declaração e a conexão
        mysqli_stmt_close($stmt);
    } else {
        echo "ID do filme não fornecido ou inválido.";
    }
} else {
    echo "Você não tem permissão para excluir este filme.";
}

mysqli_close($conn);
?>
