<?php
session_start();
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $pergunta_seguranca = trim($_POST['pergunta_seguranca']);
    $resposta_seguranca = trim($_POST['resposta_seguranca']);

    if (!$email || empty($nome) || empty($senha) || empty($pergunta_seguranca) || empty($resposta_seguranca)) {
        header("Location: ../pages/cadastro.php?erro=campos_vazios");
        exit();
    }

    if ($senha !== $confirma_senha) {
        header("Location: ../pages/cadastro.php?erro=senhas_diferentes");
        exit();
    }

    // Verifica se e-mail já existe
    $sql_check = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $stmt_c = $conexao->prepare($sql_check);
    $stmt_c->bind_param("s", $email);
    $stmt_c->execute();
    $res = $stmt_c->get_result();

    if ($res->num_rows > 0) {
        $stmt_c->close();
        header("Location: ../pages/cadastro.php?erro=email_existe");
        exit();
    }
    $stmt_c->close();

    // Hashing seguro de senha e resposta de segurança
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $resposta_hash = password_hash(mb_strtolower($resposta_seguranca, 'UTF-8'), PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha, pergunta_seguranca, resposta_seguranca, tipo_usuario) VALUES (?, ?, ?, ?, ?, 'leitor')";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $senha_hash, $pergunta_seguranca, $resposta_hash);

    if ($stmt->execute()) {
        $stmt->close();
        $conexao->close();
        header("Location: ../pages/login.php?sucesso=cadastro");
        exit();
    } else {
        $stmt->close();
        $conexao->close();
        header("Location: ../pages/cadastro.php?erro=1");
        exit();
    }
}