<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario']) || !in_array($_SESSION['tipo_usuario'], ['admin', 'moderador'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_comentario = (int) $_POST['id_comentario'];
    $acao = $_POST['acao'];

    if ($acao === 'manter') {
        $sql = "UPDATE comentarios SET status = 'ativo' WHERE id_comentario = ?";
    } elseif ($acao === 'excluir') {
        $sql = "DELETE FROM comentarios WHERE id_comentario = ?";
    }

    if (isset($sql)) {
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id_comentario);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: ../pages/painel.php");
    exit();
}