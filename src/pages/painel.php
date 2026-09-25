<?php
session_start();
include("../php/conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// 1. Busca dados atualizados do usuário primeiro
$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

// 2. Define se o usuário é moderador/admin
$eh_moderador = in_array($usuario['tipo_usuario'], ['admin', 'moderador']);

// 3. Agora realiza a consulta para denúncias caso ele seja moderador
$denuncias = [];
if ($eh_moderador) {
    $sql_denuncias = "SELECT c.id_comentario, c.comentario, c.data_comentario, u.nome AS autor, n.titulo AS noticia_titulo, n.id_noticia
                      FROM comentarios c
                      INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                      INNER JOIN noticias n ON c.id_noticia = n.id_noticia
                      WHERE c.status = 'analise'
                      ORDER BY c.data_comentario DESC";
    $res_denuncias = $conexao->query($sql_denuncias);
    if ($res_denuncias) {
        while ($row = $res_denuncias->fetch_assoc()) {
            $denuncias[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Leitor - Portal de Notícias</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include('../php/header.php'); ?>

    <main class="container">
        <h1>Minha Conta</h1>
        <p>Bem-vindo(a), <strong><?= htmlspecialchars($usuario['nome']) ?></strong>! Nível de acesso: <span class="tag-nivel"><?= strtoupper($usuario['tipo_usuario']) ?></span></p>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="mensagem-sucesso">Perfil atualizado com sucesso!</div>
        <?php endif; ?>

        <!-- AÇÕES DE GERENCIAMENTO DE NOTÍCIAS (ADMIN / MODERADOR) -->
        <?php if ($eh_moderador): ?>
            <section class="card acoes-admin">
                <h2>Painel de Gestão de Notícias</h2>
                <div class="botoes-grupo">
                    <a href="cadastroNoticia.php" class="botao">+ Publicar Nova Notícia</a>
                </div>
            </section>
        <?php endif; ?>

        <!-- EDIÇÃO DE PERFIL -->
        <section class="card">
            <h2>Atualizar Dados Pessoais</h2>
            <form action="../php/atualizarPerfil.php" method="POST" enctype="multipart/form-data">
                <div class="campo">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </div>

                <div class="campo">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>

                <div class="campo">
                    <label for="nova_senha">Nova Senha (deixe em branco se não quiser alterar):</label>
                    <input type="password" id="nova_senha" name="nova_senha" placeholder="Nova senha">
                </div>

                <div class="campo">
                    <label for="foto">Foto de Perfil:</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                </div>

                <button type="submit" class="btn-salvar">Salvar Alterações</button>
            </form>
        </section>

        <!-- ABA DE MODERAÇÃO DE DENÚNCIAS -->
        <?php if ($eh_moderador): ?>
            <div id="aba-denuncias" class="aba-conteudo card">
                <h2>Moderação de Comentários Denunciados</h2>
                <p class="descricao">Analise os comentários reportados nas notícias pelos leitores.</p>

                <?php if (!empty($denuncias)): ?>
                    <div class="lista-denuncias">
                        <?php foreach ($denuncias as $d): ?>
                            <div class="card-denuncia">
                                <p><strong>Autor do Comentário:</strong> <?= htmlspecialchars($d['autor']) ?></p>
                                <p><strong>Notícia:</strong> <a href="noticia.php?id=<?= $d['id_noticia'] ?>" target="_blank" class="link-noticia-denuncia"><?= htmlspecialchars($d['noticia_titulo']) ?></a></p>
                                <p class="texto-denuncia-comentario"><strong>Conteúdo:</strong> "<?= htmlspecialchars($d['comentario']) ?>"</p>
                                <small class="data-denuncia">Data: <?= date('d/m/Y \à\s H:i', strtotime($d['data_comentario'])) ?></small>

                                <div class="acoes-denuncia">
                                    <!-- Manter Comentário -->
                                    <form action="../php/moderar_comentario.php" method="POST" class="form-acao-denuncia">
                                        <input type="hidden" name="id_comentario" value="<?= $d['id_comentario'] ?>">
                                        <input type="hidden" name="acao" value="manter">
                                        <button type="submit" class="btn-salvar">Aprovar / Manter</button>
                                    </form>

                                    <!-- Excluir Comentário -->
                                    <form action="../php/moderar_comentario.php" method="POST" class="form-acao-denuncia" onsubmit="return confirm('Deseja apagar permanentemente este comentário?');">
                                        <input type="hidden" name="id_comentario" value="<?= $d['id_comentario'] ?>">
                                        <input type="hidden" name="acao" value="excluir">
                                        <button type="submit" class="botao-perigo">Remover Comentário</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="descricao">Nenhum comentário sob análise no momento.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php include('../php/footer.php'); ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>