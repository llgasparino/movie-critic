<?php
require 'db.php';

// Verifica se o ID do filme está presente
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit();
}

$film_id = (int)$_GET['id'];

// Busca os dados do filme no banco de dados
$query = "SELECT f.*, u.username 
          FROM filmes f
          JOIN users u ON f.user_id = u.id
          WHERE f.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $film_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) != 1) {
    echo "Filme não encontrado.";
    exit();
}

$filme = mysqli_fetch_assoc($result);
mysqli_close($conn);
?>

<div class="row">
    <div class="col-md-6">
        <img src="<?php echo htmlspecialchars($filme['movie_cover']); ?>" class="img-fluid" alt="Poster do Filme">
    </div>
    <div class="col-md-6">
        <h2><?php echo htmlspecialchars($filme['title']); ?></h2>
        <p><strong>Nota:</strong> <?php echo htmlspecialchars($filme['rating']); ?></p>
        <p><strong>Diretor:</strong> <?php echo htmlspecialchars($filme['director']); ?></p>
        <p><strong>Atores:</strong> <?php echo htmlspecialchars($filme['actors']); ?></p>
        <p><strong>Enredo:</strong> <?php echo htmlspecialchars($filme['plot']); ?></p>
        <p><strong>Adicionado por:</strong> <?php echo htmlspecialchars($filme['username']); ?></p>
        <p><small class="text-muted">Adicionado em: <?php echo htmlspecialchars($filme['created_at']); ?></small></p>
    </div>
</div>

<!-- Modal -->
<div id="filmModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Filme</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <!-- Informações do filme carregadas via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
