<?php
require '../conexaobd/conexao.php';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare('DELETE FROM livros WHERE id = ?');
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    header('Location: index.php');
}

$query = 'SELECT * FROM livros';
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Lista de Livros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Acervo Biblioteca Memória</h1>
        <a href="adicionar_livro.php">Adicionar Novo Livro</a>
    </header>
    <main>
        <div class="livros-container">
            <?php while ($livro = $result->fetch_assoc()): ?>
                <div class="livro-card">
                    <h2><?= htmlspecialchars($livro['nome']) ?></h2>
                    <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
                    <p><strong>Ano de Lançamento:</strong> <?= htmlspecialchars($livro['ano_lancamento']) ?></p>
                    
                    <button class="edit" onclick="window.location.href='editar_livro.php?id=<?= $livro['id'] ?>'">Editar</button>
                    <form method="GET" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $livro['id'] ?>">
                        <button class="delete" type="submit" onclick="return confirm('Tem certeza que deseja excluir este livro?');">Excluir</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html>
