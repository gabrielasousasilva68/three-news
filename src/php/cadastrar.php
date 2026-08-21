<?php
    include('conexao.php');
    # Captura os dados do formulario de cadstro
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    # valida dados vazios 
    if(empty($nome)|| empty($email) || empty($senha)){
        die("Preencha todos os campos!");
    }

    $senha_segura = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_segura) values ('$nome', '$email','$senha_segura')";

    $conexao -> query($sql);
    header("Location: ../pages/login.html");
    exit();
?>