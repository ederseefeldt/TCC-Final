<?php

    include_once('conectar.php');

    $id = $_GET['id'];

    $sql = "SELECT produto_imagem FROM produto WHERE produto_id = $id";
    $resultado = mysqli_query($conectar, $sql);

    foreach($resultado as $result) {
        $conteudo = $result['produto_imagem'];
        echo $conteudo;
    }
?>