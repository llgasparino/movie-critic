<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar ao banco de dados
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'movie_critic';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografar senha
    $name = $_POST['name'];

    // Tratamento da imagem de perfil
    $photo = 'default.jpg'; // Imagem padrão
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Verifica se o arquivo é uma imagem real
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $error_message = "O arquivo não é uma imagem.";
            $uploadOk = 0;
        }

        // Verifica se o arquivo já existe
        if (file_exists($target_file)) {
            $error_message = "Desculpe, o arquivo já existe.";
            $uploadOk = 0;
        }

        // Verifica o tamanho do arquivo
        if ($_FILES["photo"]["size"] > 500000) {
            $error_message = "Desculpe, seu arquivo é muito grande.";
            $uploadOk = 0;
        }

        // Permite apenas alguns formatos de arquivo
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $error_message = "Desculpe, apenas arquivos JPG, JPEG, PNG & GIF são permitidos.";
            $uploadOk = 0;
        }

        // Move o arquivo para o diretório de uploads
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = basename($_FILES["photo"]["name"]);
            } else {
                $error_message = "Desculpe, houve um erro ao enviar seu arquivo.";
            }
        }
    }

    // Insere o usuário no banco de dados
    $sql = "INSERT INTO users (username, password, name, photo) VALUES ('$username', '$password', '$name', '$photo')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['user_id'] = mysqli_insert_id($conn); // Define a sessão com o ID do usuário inserido
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Erro ao cadastrar o usuário: " . mysqli_error($conn);
    }

    // Fechar conexão
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Movie Critic</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Movie Critic</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Cadastro</div>
                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form action="register.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Usuário</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="photo">Foto de Perfil</label>
                            <input type="file" class="form-control-file" id="photo" name="photo">
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
