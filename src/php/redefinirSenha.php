<?php
session_start();
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $resposta = trim($_POST['resposta']);
    $nova_senha = $_POST['nova_senha'];

    if (!$email || empty($resposta) || empty($nova_senha)) {
        header("Location: ../pages/recuperarSenha.php");
        exit();
    }

    $sql = "SELECT id_usuario, resposta_seguranca FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $usr = $res->fetch_assoc();
        $resposta_normalizada = mb_strtolower($resposta, 'UTF-8');

        if (password_verify($resposta_normalizada, $usr['resposta_seguranca'])) {
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $sql_up = "UPDATE usuarios SET senha = ? WHERE id_usuario = ?";
            $stmt_u = $conexao->prepare($sql_up);
            $stmt_u->bind_param("si", $nova_senha_hash, $usr['id_usuario']);
            $stmt_u->execute();
            $stmt_u->close();

            header("Location: ../pages/login.php?sucesso=senha_redefinida");
            exit();
        }
    }

    header("Location: ../pages/recuperarSenha.php");
    exit();
}