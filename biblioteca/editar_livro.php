<?php
require '../conexaobd/conexao.php';

$erro = '';
$livro = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare('SELECT * FROM livros WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $livro = $result->fetch_assoc();
    } else {
        $erro = 'Livro não encontrado.';
    }
} else {
    $erro = 'ID do livro não especificado.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $livro) {
    $nome = trim($_POST['nome']);
    $autor = trim($_POST['autor']);
    $ano_lancamento = trim($_POST['ano_lancamento']);

    if (!is_numeric($ano_lancamento) || $ano_lancamento < 0 || $ano_lancamento > date("Y")) {
        $erro = 'Por favor, insira um ano de lançamento válido.';
    }

    if (empty($erro)) {
        $stmt = $conn->prepare('UPDATE livros SET nome = ?, ano_lancamento = ?, autor = ? WHERE id = ?');
        $stmt->bind_param('sisi', $nome, $ano_lancamento, $autor, $id);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Erro ao atualizar o livro. Verifique os dados.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Editar Livro</h1>
    </header>
    <main>
        <?php if ($erro): ?>
            <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        
        <?php if ($livro): ?>
            <form method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($livro['nome']) ?>" required><br>
                
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($livro['autor']) ?>" required><br>
                
                <label for="ano_lancamento">Ano de Lançamento:</label>
                <input type="number" id="ano_lancamento" name="ano_lancamento" value="<?= htmlspecialchars($livro['ano_lancamento']) ?>" required><br>

                <button type="submit">Salvar Alterações</button>
            </form>
            <a href="index.php">Voltar para a lista de livros</a>
        <?php else: ?>
            <p>Livro não encontrado.</p>
        <?php endif; ?>
    </main>
</body>
</html>
