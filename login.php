<?php

session_start();

include_once('conectar.php');

$id = $_POST['usuario_id'];
$senha = $_POST['usuario_senha'];

$sql = "SELECT usuario_nome, usuario_id, usuario_senha, usuario_status from usuario where usuario_id = '$id' and usuario_senha = '$senha'";
$resultado = mysqli_query($conectar, $sql);
$rows_usuario = mysqli_fetch_assoc($resultado);
$nome = $rows_usuario['usuario_nome'];
$status = $rows_usuario['usuario_status'];
echo $status;

if(mysqli_num_rows($resultado) == 1) {
    $registro = mysqli_fetch_array($resultado);

    $_SESSION['nome_logado'] = $nome;
    $_SESSION['id_logado'] = $id;
    $_SESSION['status'] = $status;
    header('location: index.php');
}else{
    header('location: login.html');
}
?>