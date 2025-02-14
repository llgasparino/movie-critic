<?php
require 'db.php';

// Buscar os filmes no banco de dados
$sql = "SELECT f.*, u.username 
        FROM filmes f
        JOIN users u ON f.user_id = u.id
        ORDER BY f.created_at DESC";
$result = mysqli_query($conn, $sql);
$filmes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fechar conexão
mysqli_close($conn);

require 'header.php';
?>

<div class="container mt-4">
    <h2>Últimos Filmes Adicionados</h2>
    <div class="row">
        <?php foreach ($filmes as $filme) : ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($filme['movie_cover']); ?>" class="card-img-top" alt="Poster do Filme" onclick="openModal(<?php echo $filme['id']; ?>)" title="Saber mais">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($filme['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($filme['content']); ?></p>
                        <p class="card-text"><strong>Nota:</strong> <?php echo htmlspecialchars($filme['rating']); ?></p>
                        <p class="card-text"><strong>Diretor:</strong> <?php echo htmlspecialchars($filme['director']); ?></p>
                        <p class="card-text"><strong>Atores:</strong> <?php echo htmlspecialchars($filme['actors']); ?></p>
                        <p class="card-text"><strong>Adicionado por:</strong> <?php echo htmlspecialchars($filme['username']); ?></p>
                        <p class="card-text"><small class="text-muted">Adicionado em: <?php echo htmlspecialchars($filme['created_at']); ?></small></p>
                        <?php if (isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] || $_SESSION['user_id'] == $filme['user_id'])) : ?>
                            <a href="edit_post.php?id=<?php echo $filme['id']; ?>" class="btn btn-secondary">Editar</a>
                            <a href="delete_post.php?id=<?php echo $filme['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este filme?')">Excluir</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal -->
<div id="filmModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Filme</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <!-- Informações do filme carregadas via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(filmId) {
    $.ajax({
        url: 'get_movie_details.php?id=' + filmId,
        method: 'GET',
        success: function(data) {
            $('#modal-body').html(data);
            $('#filmModal').modal('show');
        },
        error: function() {
            alert('Erro ao buscar os detalhes do filme.');
        }
    });
}

function closeModal() {
    $('#filmModal').modal('hide');
}
</script>

<?php require 'footer.php'; ?>