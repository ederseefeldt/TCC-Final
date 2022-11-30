<?php

    include_once('conectar.php');

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql = "DELETE FROM anotacao WHERE anotacao_id = '$id'";
    $resultado = mysqli_query($conectar, $sql);

    if (mysqli_affected_rows($conectar)) {
        header('location: index.php');
    }else {
        
    }
?>