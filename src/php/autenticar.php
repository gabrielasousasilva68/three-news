<?php
session_start();
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'];

    if (!$email || empty($senha)) {
        header("Location: ../pages/login.php?erro=1");
        exit();
    }

    $sql = "SELECT id_usuario, nome, email, senha, tipo_usuario, foto_perfil FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['email_usuario'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            $_SESSION['foto_perfil'] = $usuario['foto_perfil'];

            $stmt->close();
            $conexao->close();
            header("Location: ../pages/painel.php");
            exit();
        }
    }

    $stmt->close();
    $conexao->close();
    header("Location: ../pages/login.php?erro=1");
    exit();
}