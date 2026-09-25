<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_comentario = (int) $_POST['id_comentario'];
    $id_noticia = (int) $_POST['id_noticia'];

    $sql = "UPDATE comentarios SET status = 'analise' WHERE id_comentario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_comentario);
    $stmt->execute();
    $stmt->close();

    header("Location: ../pages/noticia.php?id=" . $id_noticia);
    exit();
}