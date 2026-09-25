<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario']) || !in_array($_SESSION['tipo_usuario'], ['admin', 'moderador'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $resumo = trim($_POST['resumo']);
    $categoria = trim($_POST['categoria']);
    $autor = trim($_POST['autor']);
    $conteudo = $_POST['conteudo']; // Preserva HTML e formatos longos

    if (empty($titulo) || empty($categoria) || empty($conteudo)) {
        header("Location: ../pages/cadastroNoticia.php?erro=1");
        exit();
    }

    $caminho_imagem = "";
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $novo_nome = md5(uniqid(rand(), true)) . '.' . $extensao;
        $diretorio = "../uploads/";

        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        $caminho_completo = $diretorio . $novo_nome;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_completo)) {
            $caminho_imagem = "uploads/" . $novo_nome;
        }
    }

    $sql = "INSERT INTO noticias (titulo, resumo, conteudo, imagem, categoria, autor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssss", $titulo, $resumo, $conteudo, $caminho_imagem, $categoria, $autor);

    if ($stmt->execute()) {
        $stmt->close();
        $conexao->close();
        header("Location: ../pages/cadastroNoticia.php?sucesso=1");
        exit();
    } else {
        $stmt->close();
        $conexao->close();
        header("Location: ../pages/cadastroNoticia.php?erro=1");
        exit();
    }
}