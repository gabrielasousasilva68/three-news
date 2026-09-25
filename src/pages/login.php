<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    header("Location: painel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blog de Notícias</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include('../php/header.php'); ?>

    <main class="container">
        <h1>Acessar Conta</h1>

        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'cadastro'): ?>
            <div class="mensagem-sucesso">Cadastro realizado com sucesso! Faça login abaixo.</div>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'senha_redefinida'): ?>
            <div class="mensagem-sucesso">Sua senha foi redefinida com sucesso. Entre com a nova senha.</div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="mensagem-erro">E-mail ou senha incorretos.</div>
        <?php endif; ?>

        <form action="../php/autenticar.php" method="POST" class="form-login">
            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="seuemail@exemplo.com">
            </div>

            <div class="campo">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">
            </div>

            <button type="submit" class="botao">Entrar</button>
        </form>

        <p class="aviso-login">
            <a href="recuperarSenha.php" class="link">Esqueceu sua senha?</a> | 
            <a href="cadastro.php" class="link">Criar conta</a>
        </p>
    </main>

    <?php include('../php/footer.php'); ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>