<?php
require '../conexaobd/conexao.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $autor = trim($_POST['autor']);
    $ano_lancamento = trim($_POST['ano_lancamento']);

    if (!is_numeric($ano_lancamento) || $ano_lancamento < 0 || $ano_lancamento > date("Y")) {
        $erro = 'Por favor, insira um ano de lançamento válido.';
    }

    if (empty($erro)) {
        $stmt = $conn->prepare('INSERT INTO livros (nome, ano_lancamento, autor) VALUES (?, ?, ?)');
        $stmt->bind_param('sis', $nome, $ano_lancamento, $autor);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Erro ao adicionar o livro. Verifique os dados.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Livro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Adicionar Novo Livro</h1>
    </header>
    <main>
        <?php if ($erro): ?>
            <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br>
            
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required><br>
            
            <label for="ano_lancamento">Ano de Lançamento:</label>
            <input type="number" id="ano_lancamento" name="ano_lancamento" required><br>

            <button type="submit">Adicionar Livro</button>
        </form>
        <a href="index.php">Voltar para a lista de livros</a>
    </main>
</body>
</html>
