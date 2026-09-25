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
    <title>Cadastro - Blog de Notícias</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include('../php/header.php'); ?>

    <main class="container">
        <h1>Criar uma Conta</h1>
        <p class="descricao">Cadastre-se para comentar matérias e interagir no portal de notícias.</p>

        <?php if (isset($_GET['erro'])): ?>
            <div class="mensagem-erro">
                <?php 
                    if ($_GET['erro'] === 'email_existe') echo "Este e-mail já está cadastrado.";
                    elseif ($_GET['erro'] === 'senhas_diferentes') echo "As senhas não coincidem.";
                    else echo "Preencha todos os campos corretamente.";
                ?>
            </div>
        <?php endif; ?>

        <form action="../php/cadastrar.php" method="POST" class="form-cadastro">
            <div class="campo">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required placeholder="Seu nome">
            </div>

            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="seuemail@exemplo.com">
            </div>

            <div class="campo">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required placeholder="Mínimo 6 caracteres">
            </div>

            <div class="campo">
                <label for="confirma_senha">Confirmar Senha:</label>
                <input type="password" id="confirma_senha" name="confirma_senha" required placeholder="Repita a senha">
            </div>

            <div class="campo">
                <label for="pergunta_seguranca">Pergunta de Segurança (para recuperação de conta):</label>
                <select name="pergunta_seguranca" id="pergunta_seguranca" required>
                    <option value="" disabled selected>Selecione uma pergunta</option>
                    <option value="Qual o nome do seu primeiro animal de estimação?">Qual o nome do seu primeiro animal de estimação?</option>
                    <option value="Qual a sua cidade natal?">Qual a sua cidade natal?</option>
                    <option value="Qual o nome da sua primeira escola?">Qual o nome da sua primeira escola?</option>
                </select>
            </div>

            <div class="campo">
                <label for="resposta_seguranca">Resposta de Segurança:</label>
                <input type="text" id="resposta_seguranca" name="resposta_seguranca" required placeholder="Sua resposta secreta">
            </div>

            <button type="submit" class="botao">Cadastrar</button>
        </form>

        <p class="aviso-login">Já tem uma conta? <a href="login.php" class="link">Faça Login</a></p>
    </main>

    <?php include('../php/footer.php'); ?>
    <script src="../assets/js/script.js"></script>
</body>
</html>