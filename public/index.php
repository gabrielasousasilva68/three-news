<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three News</title>
    <link rel="stylesheet" href="../src/assets/css/style.css">
</head>

<body>
    <header class="header" >
        <a href="../public/index.php">
            <img class="logo" src="../src/assets/imagens/logomarca.png" >
        </a>
        <h1 id="titulo">Three News</h1>
        <div class="menu">
            <a class="usuario" href="../public/index.php">
            <img src="../src/assets/imagens/perfil-de-usuario.png">
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
        <article class="article">
            <img src="../src/assets/imagens/taylor swift.png">
            <h2><a class="a" href="../src/pages/noticia-1.php">Taylor Swift reinventa o pop em seu novo álbum — e mostra por que
                    continua no topo da geração</a></h2>
        </article>
        <article class="article">
            <img src="../src/assets/imagens/stranger things.png">
            <h2><a class="a" href="../src/pages/noticia-2.php">Stranger Things está de volta: a temporada mais sombria promete mexer
                    com as emoções dos fãs</a></h2>
        </article>
        <article class="article">
            <img src="../src/assets/imagens/hipotese do amor atores.png">
            <h2><a class="a" href="../src/pages/noticia-3.php"> Hipótese do Amor: o sucesso literário que vai ganhar vida nas
                    telas</a></h2>
        </article>
        <article class="article">
            <img src="../src/assets/imagens/mpb.png">
            <h2> <a class="a" href="../src/pages/noticia-4.php">O poder da MPB: como a música popular brasileira segue influenciando
                    gerações e moldando o som do mundo</a></h2>
        </article>
        <article class="article">
            <img src="../src/assets/imagens/caramelo.png">
            <h2><a class="a" href="../src/pages/noticia-5.php">Caramelo: o filme brasileiro que conquistou o mundo e virou o novo
                    fenômeno da Netflix</a></h2>
        </article>
    </main>
    <footer>
        <p>&copy; Desenvolvido por Three News - Todos os direitos reservados!</p>
    </footer>
    <script src="../src/assets/js/script.js"></script>
</body>

</html>
