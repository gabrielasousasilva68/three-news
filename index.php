<?php
session_start();
include("src/php/conexao.php");

// Captura parâmetros de busca e categoria da URL
$busca = trim($_GET['busca'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');

// Monta a consulta dinâmica SQL
$sql = "SELECT id_noticia, titulo, resumo, imagem, categoria, autor, data_publicacao FROM noticias WHERE 1=1";
$params = [];
$types = "";

if (!empty($busca)) {
    $sql .= " AND (titulo LIKE ? OR resumo LIKE ? OR conteudo LIKE ?)";
    $term = "%" . $busca . "%";
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
    $types .= "sss";
}

if (!empty($categoria)) {
    $sql .= " AND categoria = ?";
    $params[] = $categoria;
    $types .= "s";
}

$sql .= " ORDER BY data_publicacao DESC";

$stmt = $conexao->prepare($sql);
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Notícias - Página Inicial</title>
    <link rel="stylesheet" href="src/assets/css/style.css">
</head>
<body>
    <?php include('src/php/header.php'); ?>

    <main class="container">
        <section class="filtro-busca-container">
            <h1>Últimas Notícias</h1>
            
            <form action="index.php" method="GET" class="form-busca">
                <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Pesquisar notícias...">
                
                <select name="categoria" onchange="this.form.submit()">
                    <option value="">Todas as Categorias</option>
                    <option value="Tecnologia" <?= $categoria === 'Tecnologia' ? 'selected' : '' ?>>Música</option>
                    <option value="Entretenimento" <?= $categoria === 'Entretenimento' ? 'selected' : '' ?>>Entretenimento</option>
                    <option value="Filmes e Series" <?= $categoria === 'Filmes e Series' ? 'selected' : '' ?>>Filmes e Séries</option>
                    <option value="Livros" <?= $categoria === 'Livros' ? 'selected' : '' ?>>Livros</option>
                    <option value="Cultura" <?= $categoria === 'Cultura' ? 'selected' : '' ?>>Cultura</option>
                </select>

                <button type="submit" class="botao">Buscar</button>
                <?php if (!empty($busca) || !empty($categoria)): ?>
                    <a href="index.php" class="btn-limpar">Limpar Filtros</a>
                <?php endif; ?>
            </form>
        </section>

        <section class="grid-noticias">
            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($noticia = $resultado->fetch_assoc()): ?>
                    <article class="card-noticia card">
                        <?php if (!empty($noticia['imagem'])): ?>
                            <div class="capa-noticia">
                                <a href="src/pages/noticia.php?id=<?= $noticia['id_noticia'] ?>">
                                    <img src="<?= './src/' . htmlspecialchars($noticia['imagem']) ?>" alt="<?= htmlspecialchars($noticia['titulo']) ?>">
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="conteudo-card">
                            <span class="genero-tag"><?= htmlspecialchars($noticia['categoria']) ?></span>
                            <h2>
                                <a href="src/pages/noticia.php?id=<?= $noticia['id_noticia'] ?>">
                                    <?= htmlspecialchars($noticia['titulo']) ?>
                                </a>
                            </h2>
                            <?php if (!empty($noticia['resumo'])): ?>
                                <p class="resumo"><?= htmlspecialchars($noticia['resumo']) ?></p>
                            <?php endif; ?>

                            <div class="noticia-meta">
                                <span>Por <strong><?= htmlspecialchars($noticia['autor']) ?></strong></span> | 
                                <small><?= date('d/m/Y', strtotime($noticia['data_publicacao'])) ?></small>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="descricao">Nenhuma notícia encontrada com os filtros selecionados.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php 
    $stmt->close();
    $conexao->close();
    include('src/php/footer.php'); 
    ?>
    <script src="./src/assets/js/script.js"></script>
</body>
</html>