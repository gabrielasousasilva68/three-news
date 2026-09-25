<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<footer class="footer-principal">
    <div class="footer-container">
        <p>&copy; <?php echo date('Y'); ?> Three News. Todos os direitos reservados.</p>
    </div>
</footer>