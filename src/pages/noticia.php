<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../php/conexao.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_noticia = (int) $_GET['id'];

// Busca a notícia
$sql = "SELECT * FROM noticias WHERE id_noticia = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_noticia);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$noticia = $resultado->fetch_assoc();
$stmt->close();

$id_usuario_logado = $_SESSION['id_usuario'] ?? 0;

// Busca comentários da notícia com quantidade de curtidas e status de curtiu
$sql_comentarios = "SELECT c.id_comentario, c.id_usuario, c.comentario, c.data_comentario, c.status, u.nome,
                    COUNT(DISTINCT lk.id_curtida) AS total_likes,
                    EXISTS(SELECT 1 FROM curtidas_comentarios WHERE id_comentario = c.id_comentario AND id_usuario = ?) AS curtiu
                    FROM comentarios c
                    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                    LEFT JOIN curtidas_comentarios lk ON c.id_comentario = lk.id_comentario
                    WHERE c.id_noticia = ?
                    GROUP BY c.id_comentario
                    ORDER BY c.data_comentario DESC";

$stmt_c = $conexao->prepare($sql_comentarios);
$stmt_c->bind_param("ii", $id_usuario_logado, $id_noticia);
$stmt_c->execute();
$resultado_comentarios = $stmt_c->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($noticia['titulo']); ?> - Portal de Notícias</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=20260905">
</head>
<body class="preload">
    <?php include('../php/header.php'); ?>

    <main class="container pagina-noticia">
        <a href="../../index.php" class="btn-voltar">← Voltar às Notícias</a>

        <article class="detalhes-noticia-wrapper">
            <header class="noticia-header">
                <span class="genero-tag"><?= htmlspecialchars($noticia['categoria']); ?></span>
                <h1><?= htmlspecialchars($noticia['titulo']); ?></h1>
                <?php if (!empty($noticia['resumo'])): ?>
                    <p class="noticia-resumo"><strong><?= htmlspecialchars($noticia['resumo']); ?></strong></p>
                <?php endif; ?>
                <div class="noticia-meta">
                    <span>Por <strong><?= htmlspecialchars($noticia['autor']); ?></strong></span> | 
                    <span>Publicado em: <?= date('d/m/Y \à\s H:i', strtotime($noticia['data_publicacao'])); ?></span>
                </div>
            </header>

            <?php if (!empty($noticia['imagem'])): ?>
                <div class="noticia-capa-grande">
                    <img src="../<?= htmlspecialchars($noticia['imagem']); ?>" alt="<?= htmlspecialchars($noticia['titulo']); ?>">
                </div>
            <?php endif; ?>

            <!-- CONTEÚDO COMPLETO DA NOTÍCIA (Suporta tags HTML) -->
            <div class="noticia-conteudo-body">
                <?= $noticia['conteudo']; ?>
            </div>

            <hr class="divisor">

            <!-- FORMULÁRIO DE COMENTÁRIOS -->
            <section class="secao-comentarios-container">
                <h2>Comentários</h2>

                <?php if ($id_usuario_logado): ?>
                    <form action="../php/comentario.php" method="POST" id="formComentario">
                        <input type="hidden" name="id_noticia" value="<?= $noticia['id_noticia'] ?>">                
                        <div class="campo">
                            <label for="comentario">Deixe seu comentário:</label>
                            <textarea id="comentario" name="comentario" rows="4" placeholder="Escreva o que você achou dessa notícia..." required></textarea>
                        </div>                
                        <button type="submit" class="botao">Enviar Comentário</button>
                    </form>
                <?php else: ?>
                    <p class="aviso-login">
                        Você precisa estar <a class="link" href="login.php">logado</a> para comentar nesta notícia.
                    </p>
                <?php endif; ?>

                <hr class="divisor">

                <!-- LISTA DE COMENTÁRIOS -->
                <div class="lista-comentarios">
                    <?php if ($resultado_comentarios->num_rows > 0): ?>
                        <?php while ($c = $resultado_comentarios->fetch_assoc()): ?>
                            <?php $id_autor_comentario = (int) $c['id_usuario']; ?>
                            <div class="comentario-item card">
                                <div class="comentario-header">
                                    <strong><?= htmlspecialchars($c['nome']) ?></strong>
                                    <small><?= date('d/m/Y \à\s H:i', strtotime($c['data_comentario'])) ?></small>
                                </div>

                                <div class="comentario-corpo">
                                    <?php if ($c['status'] === 'analise'): ?>
                                        <p class="comentario-analise"><em>Este comentário foi denunciado e está em análise pela moderação.</em></p>
                                    <?php else: ?>
                                        <p><?= htmlspecialchars($c['comentario']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <?php if ($c['status'] !== 'analise' && $id_usuario_logado): ?>
                                    <div class="comentario-acoes">
                                        <!-- CURTIR COMENTÁRIO -->
                                        <form action="../php/curtir_comentario.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id_comentario" value="<?= $c['id_comentario'] ?>">
                                            <input type="hidden" name="id_noticia" value="<?= $id_noticia ?>">
                                            <button type="submit" 
                                                    class="btn-acao <?= !empty($c['curtiu']) ? 'curtido' : '' ?>" 
                                                    title="<?= !empty($c['curtiu']) ? 'Remover curtida' : 'Curtir comentário' ?>">
                                                <img src="../assets/img/icons/thumbs-up.png" alt="Curtir"> 
                                                <span><?= $c['total_likes'] ?></span>
                                            </button>
                                        </form>

                                        <!-- DENUNCIAR COMENTÁRIO -->
                                        <?php if ($id_autor_comentario !== (int)$id_usuario_logado): ?>
                                            <form action="../php/denunciar_comentario.php" method="POST" class="d-inline" onsubmit="return confirm('Deseja denunciar este comentário para a moderação?');">
                                                <input type="hidden" name="id_comentario" value="<?= $c['id_comentario'] ?>">
                                                <input type="hidden" name="id_noticia" value="<?= $id_noticia ?>">
                                                <button type="submit" class="btn-acao btn-denunciar" title="Denunciar">
                                                    <img src="../assets/img/icons/finish.png" alt="Denunciar">
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <!-- EXCLUIR PRÓPRIO COMENTÁRIO -->
                                        <?php if ($id_autor_comentario === (int)$id_usuario_logado): ?>
                                            <form action="../php/excluir_comentario.php" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja apagar seu comentário?');">
                                                <input type="hidden" name="id_comentario" value="<?= $c['id_comentario'] ?>">
                                                <input type="hidden" name="id_noticia" value="<?= $id_noticia ?>">
                                                <button type="submit" class="btn-acao btn-excluir" title="Excluir meu comentário">
                                                    <img src="../assets/img/icons/trash-can.png" alt="Excluir">
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="descricao">Nenhum comentário nesta notícia ainda. Seja o primeiro a comentar!</p>
                    <?php endif; ?>
                </div>
            </section>
        </article>
    </main>

    <?php 
    $stmt_c->close();
    $conexao->close();
    include('../php/footer.php'); 
    ?>
    <script src="../assets/js/script.js" defer></script>
</body>
</html>