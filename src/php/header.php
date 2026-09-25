<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pagina_atual = basename($_SERVER['SCRIPT_NAME']);
$eh_raiz = ($pagina_atual === 'index.php');

// Define prefixos de caminho dinâmicos dependendo de onde o header foi incluído
$caminho_home  = $eh_raiz ? 'index.php' : '../../index.php';
$caminho_pages = $eh_raiz ? 'src/pages/' : '';
$caminho_php   = $eh_raiz ? 'src/php/' : '../php/';
// Adicione a linha abaixo:
$caminho_img   = $eh_raiz ? 'src/assets/img/logomarca.png' : '../../src/assets/img/logomarca.png';
?>

<header class="header-principal">
    <div class="nav-container">
        <a href="<?= $caminho_home ?>" class="logo">
           <img src="<?= $caminho_img ?>" alt="Logomarca">
        </a>

        <!-- Checkbox invisível que controla o menu mobile via CSS -->
        <input type="checkbox" id="menu-toggle" class="menu-toggle-checkbox">

        <nav class="navbar">
            <a href="<?= $caminho_home ?>" class="nav-link <?php echo ($pagina_atual === 'index.php') ? 'ativo' : ''; ?>">Início</a>
            
            <?php if (isset($_SESSION['tipo_usuario']) && in_array($_SESSION['tipo_usuario'], ['admin', 'moderador'])): ?>
                <a href="<?= $caminho_pages ?>cadastroNoticia.php" class="nav-link <?php echo ($pagina_atual === 'cadastroNoticia.php') ? 'ativo' : ''; ?>">Cadastrar Notícia</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['id_usuario'])): ?>
                <a href="<?= $caminho_pages ?>painel.php" class="nav-link <?php echo ($pagina_atual === 'painel.php') ? 'ativo' : ''; ?>">Meu Perfil</a>
                <a href="<?= $caminho_php ?>logout.php" class="nav-link">Sair</a>
            <?php else: ?>
                <a href="<?= $caminho_pages ?>login.php" class="nav-link <?php echo ($pagina_atual === 'login.php') ? 'ativo' : ''; ?>">Entrar</a>
                <a href="<?= $caminho_pages ?>cadastro.php" class="nav-link <?php echo ($pagina_atual === 'cadastro.php') ? 'ativo' : ''; ?>">Cadastrar-se</a>
            <?php endif; ?>
        </nav>

        <div class="nav-utilidades">
            <div class="container-tema">
                <label class="switch">
                    <input type="checkbox" id="btn-toggle-tema">
                    <span class="slider round"></span>
                </label>
            </div>

            <!-- Botão hambúrguer para mobile -->
            <label for="menu-toggle" class="menu-toggle-label" aria-label="Abrir menu">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>
    </div>
</header>