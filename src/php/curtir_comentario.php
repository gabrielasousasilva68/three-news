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

    // Verifica se já curtiu
    $sql_check = "SELECT id_curtida FROM curtidas_comentarios WHERE id_comentario = ? AND id_usuario = ?";
    $stmt_c = $conexao->prepare($sql_check);
    $stmt_c->bind_param("ii", $id_comentario, $id_usuario);
    $stmt_c->execute();
    $res = $stmt_c->get_result();

    if ($res->num_rows > 0) {
        // Já curtiu: Remove o like
        $sql_del = "DELETE FROM curtidas_comentarios WHERE id_comentario = ? AND id_usuario = ?";
        $stmt_d = $conexao->prepare($sql_del);
        $stmt_d->bind_param("ii", $id_comentario, $id_usuario);
        $stmt_d->execute();
        $stmt_d->close();
    } else {
        // Não curtiu: Adiciona o like
        $sql_ins = "INSERT INTO curtidas_comentarios (id_comentario, id_usuario) VALUES (?, ?)";
        $stmt_i = $conexao->prepare($sql_ins);
        $stmt_i->bind_param("ii", $id_comentario, $id_usuario);
        $stmt_i->execute();
        $stmt_i->close();
    }
    $stmt_c->close();

    header("Location: ../pages/noticia.php?id=" . $id_noticia);
    exit();
}