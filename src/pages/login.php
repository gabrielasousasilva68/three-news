<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="header" >
        <a href="../../public/index.php">
            <img class="logo" src="../assets/imagens/logomarca.png" >
        </a>
        <h1 id="titulo">Three News</h1>
        <div class="menu">
            <a class="usuario" href="../../public/index.php">
            <img src="../assets/imagens/perfil-de-usuario.png">
        </a>
            <div class="dropdown">☰
                <div class="dropdown-content">
                    <a href="../src/pages/livros.php">Livros</a>
                    <a href="../src/pages/series.php">Séries</a>
                    <a href="../src/pages/filmes.php">Filmes</a>
                    <a href="../src/pages/musicas.php">Música</a>
                </div>
            </div>
            <button id="modoEscuro"></button>
        </div>
    </header>
    <main>
        <form method="POST" action="../php/login.php">
            <label>E-mail:</label>
            <input type="email" name="email">
            <label>Senha:</label>
            <input type="password" name="senha">
            <button type="submit">Entrar</button>
        </form>
    </main>
    <footer>
        <p>&copy; Desenvolvido por Three News - Todos os direitos reservados!</p>
    </footer>
    <script src="../assets/js/script.js"></script>
</body>
</html>