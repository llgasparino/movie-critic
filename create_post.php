<?php
require 'db.php';
require 'header.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $rating = $_POST['rating'];
    $movie_cover = mysqli_real_escape_string($conn, $_POST['movie_cover']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $actors = mysqli_real_escape_string($conn, $_POST['actors']);
    $plot = mysqli_real_escape_string($conn, $_POST['plot']);

    $sql = "INSERT INTO filmes (user_id, title, content, rating, movie_cover, year, director, actors, plot, created_at)
            VALUES ('$user_id', '$title', '$content', '$rating', '$movie_cover', '$year', '$director', '$actors', '$plot', NOW())";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao adicionar o filme: " . mysqli_error($conn);
    }
}

// Fechar a conexão
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Filme - Movie Critic</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>


    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div id="movie-info" class="card" style="display: none;">
                    <img id="poster" class="card-img-top" src="" alt="Poster do Filme">
                    <div class="card-body">
                        <h5 class="card-title" id="info-title"></h5>
                        <p class="card-text" id="info-plot"></p>
                        <p class="card-text"><strong>Diretor:</strong> <span id="info-director"></span></p>
                        <p class="card-text"><strong>Atores:</strong> <span id="info-actors"></span></p>
                        <p class="card-text"><strong>Ano:</strong> <span id="info-year"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h2>Adicionar Filme</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="search">Buscar Filme</label>
                        <input type="text" class="form-control" id="search" placeholder="Digite o nome do filme">
                        <button type="button" class="btn btn-primary mt-2" id="search-button">Buscar</button>
                    </div>
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Texto</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="rating">Nota (de 1 a 10)</label>
                        <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" required>
                    </div>
                    <input type="hidden" id="movie_cover" name="movie_cover">
                    <input type="hidden" id="year" name="year">
                    <input type="hidden" id="director" name="director">
                    <input type="hidden" id="actors" name="actors">
                    <input type="hidden" id="plot" name="plot">
                    <button type="submit" class="btn btn-primary">Adicionar Filme</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#search-button').click(function() {
                var movieName = $('#search').val();
                if (movieName) {
                    $.ajax({
                        url: 'http://www.omdbapi.com/?apikey=YOUR_OMDB_API_KEY&t' + movieName,
                        method: 'GET',
                        success: function(data) {
                            if (data.Response == "True") {
                                $('#title').val(data.Title);
                                $('#movie_cover').val(data.Poster);
                                $('#year').val(data.Year);
                                $('#director').val(data.Director);
                                $('#actors').val(data.Actors);
                                $('#plot').val(data.Plot);

                                $('#poster').attr('src', data.Poster);
                                $('#info-title').text(data.Title);
                                $('#info-plot').text(data.Plot);
                                $('#info-director').text(data.Director);
                                $('#info-actors').text(data.Actors);
                                $('#info-year').text(data.Year);

                                $('#movie-info').show();
                            } else {
                                alert('Filme não encontrado!');
                            }
                        },
                        error: function() {
                            alert('Erro ao buscar o filme. Tente novamente.');
                        }
                    });
                } else {
                    alert('Por favor, digite o nome do filme.');
                }
            });
        });
    </script>

</body>

</html>