<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $nome = trim($_POST['nome']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $nova_senha = $_POST['nova_senha'];

    if (empty($nome) || !$email) {
        header("Location: ../pages/painel.php?erro=campos");
        exit();
    }

    // Upload de Foto de Perfil
    $caminho_foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $novo_nome = "avatar_" . $id_usuario . "_" . time() . "." . $ext;
        $diretorio = "../uploads/perfis/";

        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio . $novo_nome)) {
            $caminho_foto = "uploads/perfis/" . $novo_nome;
            $_SESSION['foto_perfil'] = $caminho_foto;
        }
    }

    // Atualiza nome, e-mail e foto
    if (!empty($nova_senha)) {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        if ($caminho_foto) {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, foto_perfil = ? WHERE id_usuario = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssssi", $nome, $email, $senha_hash, $caminho_foto, $id_usuario);
        } else {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id_usuario = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssi", $nome, $email, $senha_hash, $id_usuario);
        }
    } else {
        if ($caminho_foto) {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, foto_perfil = ? WHERE id_usuario = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssi", $nome, $email, $caminho_foto, $id_usuario);
        } else {
            $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id_usuario = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssi", $nome, $email, $id_usuario);
        }
    }

    $stmt->execute();
    $stmt->close();

    $_SESSION['nome_usuario'] = $nome;
    $_SESSION['email_usuario'] = $email;

    header("Location: ../pages/painel.php?sucesso=1");
    exit();
}