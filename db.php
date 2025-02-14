<?php
// includes/db.php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'movie_critic';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
