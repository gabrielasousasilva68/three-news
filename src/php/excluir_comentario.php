<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_comentario = (int) $_POST['id_comentario'];
    $id_noticia = (int) $_POST['id_noticia'];

    // Permite excluir apenas se o comentário for do usuário logado
    $sql = "DELETE FROM comentarios WHERE id_comentario = ? AND id_usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id_comentario, $id_usuario);
    $stmt->execute();
    $stmt->close();

    header("Location: ../pages/noticia.php?id=" . $id_noticia);
    exit();
}