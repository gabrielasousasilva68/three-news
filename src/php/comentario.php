<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_noticia = (int) $_POST['id_noticia'];
    $comentario = trim($_POST['comentario']);

    if (!empty($comentario) && $id_noticia > 0) {
        $sql = "INSERT INTO comentarios (id_noticia, id_usuario, comentario) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("iis", $id_noticia, $id_usuario, $comentario);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: ../pages/noticia.php?id=" . $id_noticia);
    exit();
}