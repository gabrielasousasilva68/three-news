<?php
session_start();

// Bloqueia quem não está logado ou quem não é administrador/autor
if (!isset($_SESSION['id_usuario']) || !in_array($_SESSION['tipo_usuario'], ['admin', 'moderador'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Notícia - Blog de Notícias</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=20260905">
</head>
<body class="preload">
    <?php include('../php/header.php'); ?>

    <main class="container">
        <h1>Cadastrar Nova Notícia</h1>
        
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="mensagem-sucesso">Notícia cadastrada com sucesso!</div>
        <?php endif; ?>
        <?php if (isset($_GET['erro'])): ?>
            <div class="mensagem-erro">Erro ao cadastrar notícia. Preencha todos os campos obrigatórios.</div>
        <?php endif; ?>

        <form action="../php/cadastrarNoticia.php" method="post" enctype="multipart/form-data" id="formNoticia">
            <div class="campo">
                <label for="imagem">Imagem de Capa da Notícia:</label>
                <input type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/webp" required>
            </div>

            <div class="campo">
                <label for="titulo">Título da Notícia:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Digite o título principal" required>
            </div>

            <div class="campo">
                <label for="resumo">Subtítulo / Resumo:</label>
                <textarea id="resumo" name="resumo" rows="3" placeholder="Pequena introdução da notícia..."></textarea>
            </div>

            <div class="campo">
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" required>
                    <option value="" selected disabled>Selecione uma categoria</option>
                    <option value="Musica">Música</option>
                    <option value="Entretenimento">Entretenimento</option>
                    <option value="Filmes e Series">Filmes e Séries</option>
                    <option value="Livros">Livros</option>
                    <option value="Cultura">Cultura</option>
                </select>
            </div>

            <div class="campo">
                <label for="autor">Autor / Repórter:</label>
                <input type="text" id="autor" name="autor" placeholder="Nome do autor do artigo" required>
            </div>

            <div class="campo">
                <label for="conteudo">Conteúdo Completo (Suporta trechos HTML e textos com mais de 10.000 caracteres):</label>
                <textarea id="conteudo" name="conteudo" rows="18" placeholder="Escreva ou cole aqui a matéria completa. Aceita tags HTML como <p>, <h2>, <strong>, <a>, <img>, etc." required></textarea>
            </div>

            <button type="submit" class="btn-salvar">Publicar Notícia</button>
        </form>
    </main>    

    <?php include('../php/footer.php'); ?>
    <script src="../assets/js/script.js" defer></script>
</body>
</html>