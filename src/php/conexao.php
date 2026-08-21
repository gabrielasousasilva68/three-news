<?php
$servidor = "localhost";
$usuario = "root";
$senha = "senac";
$banco = "three_news";
$porta = 3307;
$conexao = new mysqli ($servidor, $usuario, $senha, $banco, $porta );

if($conexao -> connect_error){
    die("erro." . $conexao -> connect_error);
}
?>