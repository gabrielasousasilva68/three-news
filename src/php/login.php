<?php 
    include('conexao.php');
    session_start();
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = " SELECT * FROM usuarios WHERE email_usuario = '$email'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        die("email nao cadastrado!");
    }
    if(password_verify($senha, $usuario['senha_segura'])) {
        $_SESSION['usuario'] = $usuario['id'];
        header("Location: ../../public/index.html");
       exit(); 
    }  else {
        die("senha incorreta!");
    }
?>