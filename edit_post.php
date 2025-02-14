<?php
session_start();

// Conectar ao banco de dados
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'movie_critic';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do post está presente
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = (int)$_GET['id'];

// Busca os dados do post no banco de dados
$query = "SELECT * FROM filmes WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) != 1) {
    header("Location: index.php");
    exit();
}

$post = mysqli_fetch_assoc($result);

// Verifica se o usuário logado é o autor do post ou um administrador
if ($_SESSION['user_id'] != $post['user_id'] && !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

// Atualiza os dados do post no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $rating = $_POST['rating'];
    $movie_cover = $_POST['movie_cover'];
    $year = $_POST['year'];
    $director = $_POST['director'];
    $actors = $_POST['actors'];
    $plot = $_POST['plot'];

    // Prepara a consulta para atualizar o post
    $query = "UPDATE filmes SET 
                title = ?, 
                content = ?, 
                rating = ?, 
                movie_cover = ?, 
                year = ?, 
                director = ?, 
                actors = ?, 
                plot = ? 
              WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssdsssssi', $title, $content, $rating, $movie_cover, $year, $director, $actors, $plot, $post_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?message=Post atualizado com sucesso");
        exit();
    } else {
        echo "Erro ao atualizar o post: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Post - Movie Critic</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Movie Critic</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Sair</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2>Editar Post</h2>
    <form action="edit_post.php?id=<?php echo $post_id; ?>" method="POST">
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Conteúdo</label>
            <textarea class="form-control" id="content" name="content" rows="4" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="rating">Nota</label>
            <input type="number" class="form-control" id="rating" name="rating" value="<?php echo htmlspecialchars($post['rating']); ?>" required>
        </div>
        <div class="form-group">
            <label for="movie_cover">Capa do Filme</label>
            <input type="text" class="form-control" id="movie_cover" name="movie_cover" value="<?php echo htmlspecialchars($post['movie_cover']); ?>">
        </div>
        <div class="form-group">
            <label for="year">Ano</label>
            <input type="text" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($post['year']); ?>">
        </div>
        <div class="form-group">
            <label for="director">Diretor</label>
            <input type="text" class="form-control" id="director" name="director" value="<?php echo htmlspecialchars($post['director']); ?>">
        </div>
        <div class="form-group">
            <label for="actors">Atores</label>
            <textarea class="form-control" id="actors" name="actors" rows="2"><?php echo htmlspecialchars($post['actors']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="plot">Enredo</label>
            <textarea class="form-control" id="plot" name="plot" rows="2"><?php echo htmlspecialchars($post['plot']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
