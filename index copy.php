<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'movie_critic';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Consulta SQL para carregar os posts (limitado por 10 posts)
$sql = "SELECT posts.*, users.username, users.name as author_name, users.photo as author_photo FROM posts
        LEFT JOIN users ON posts.user_id = users.id
        ORDER BY created_at DESC LIMIT 10";
$result = mysqli_query($conn, $sql);

// Verificar se há posts
$posts = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}

// Fechar conexão
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Critic</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Arquivo CSS externo -->
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Movie Critic</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Página Inicial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="create_post.php">Adicionar Filme</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Cadastro</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="row" id="post-container">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-6">
                <div class="post">
                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <p>Nota: <?php echo htmlspecialchars($post['rating']); ?>/10</p>
                    <?php if (!empty($post['movie_cover'])): ?>
                        <img src="<?php echo htmlspecialchars($post['movie_cover']); ?>" class="img-fluid" alt="Capa do Filme">
                    <?php endif; ?>
                    <div class="author-info">
                        <img src="<?php echo htmlspecialchars($post['author_photo']); ?>" alt="Foto do Autor">
                        <p>Por <?php echo htmlspecialchars($post['author_name']); ?></p>
                    </div>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger">Excluir</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Script para rolagem infinita -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    var limit = 10; // Número de posts carregados por vez
    var offset = 10; // Inicialmente carregaremos do 11º post em diante

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            $.ajax({
                url: 'load_posts.php',
                type: 'POST',
                data: {limit: limit, offset: offset},
                success: function(data) {
                    $('#post-container').append(data);
                    offset += limit; // Incrementa o offset para a próxima carga
                }
            });
        }
    });
});
</script>

</body>
</html>
