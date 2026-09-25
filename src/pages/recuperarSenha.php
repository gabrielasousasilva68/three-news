<?php
session_start();
include("../php/conexao.php");

$etapa = 1;
$pergunta = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao_email'])) {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $sql = "SELECT pergunta_seguranca FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $pergunta = $row['pergunta_seguranca'];
        $etapa = 2;
    } else {
        $erro = "E-mail não encontrado no sistema.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Blog de Notícias</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include('../php/header.php'); ?>

    <main class="container">
        <h1>Recuperação de Senha</h1>

        <?php if (isset($erro)): ?>
            <div class="mensagem-erro"><?= $erro ?></div>
        <?php endif; ?>

        <?php if ($etapa === 1): ?>
            <!-- ETAPA 1: DIGITAR O E-MAIL -->
            <form action="recuperarSenha.php" method="POST">
                <input type="hidden" name="acao_email" value="1">
                <div class="campo">
                    <label for="email">Informe seu e-mail cadastrado:</label>
                    <input type="email" id="email" name="email" required placeholder="seuemail@exemplo.com">
                </div>
                <button type="submit" class="botao">Buscar Conta</button>
            </form>
        <?php else: ?>
            <!-- ETAPA 2: RESPONDER PERGUNTA E DEFINIR NOVA SENHA -->
            <form action="../php/redefinirSenha.php" method="POST">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

                <div class="campo">
                    <label>Pergunta de Segurança:</label>
                    <input type="text" value="<?= htmlspecialchars($pergunta) ?>" readonly disabled>
                </div>

                <div class="campo">
                    <label for="resposta">Sua Resposta:</label>
                    <input type="text" id="resposta" name="resposta" required placeholder="Digite a resposta correta">
                </div>

                <div class="campo">
                    <label for="nova_senha">Nova Senha:</label>
                    <input type="password" id="nova_senha" name="nova_senha" required placeholder="Digite a nova senha">
                </div>

                <button type="submit" class="botao">Redefinir Senha</button>
            </form>
        <?php endif; ?>

        <p class="aviso-login"><a href="login.php" class="link">← Voltar ao Login</a></p>
    </main>

    <?php include('../php/footer.php'); ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>