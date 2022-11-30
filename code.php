<?php
    session_start();
    include_once('conectar.php');

    //--> Começo do código adiciona uma nova anotação no banco de dados <--//
    if(isset($_POST["btn_salvar_anotacao"])) {
        $vendedor_id = $_POST['vendedor_id'];
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];

        $sql = "INSERT INTO anotacao VALUES (null, '$titulo', '$texto', '$vendedor_id')";

        $resultado = mysqli_query($conectar, $sql);
        mysqli_close($conectar);

        header('location: index.php');
    }
    //--> Fim do código adiciona uma nova anotação no banco de dados <--//

    
    //--> Começo do código edita as informações do vendedores no banco de dados <--//
    if(isset($_POST["btn_atualizar_vendedor"])) {
        $id = filter_input(INPUT_POST, 'vendedor_id', FILTER_SANITIZE_NUMBER_INT);
        $nome = filter_input(INPUT_POST, 'vendedor_nome', FILTER_UNSAFE_RAW);
        $sobrenome = $_POST['vendedor_sobrenome'];
        $cpf = $_POST['vendedor_cpf'];
        $email = $_POST['vendedor_email'];
        $telefone = $_POST['vendedor_telefone'];

        $sql = "UPDATE usuario SET usuario_nome = '$nome', usuario_sobrenome = '$sobrenome', usuario_cpf = '$cpf', usuario_email = '$email', usuario_telefone = '$telefone' WHERE usuario_id = '$id'";
        $resultado = mysqli_query($conectar, $sql);

        if($resultado) {
            header('location: vendedores.php');
        }
    }
    //--> Fim do código edita as informações do vendedores no banco de dados <--//


    //--> Começo do código remove o vendedor do banco de dados <--//
    if(isset($_POST["btn_remover_vendedor"])) {
        $id = mysqli_real_escape_string($conectar, $_POST['btn_remover_vendedor']);

        $sql = "DELETE FROM usuario WHERE usuario_id = '$id'";
        $resultado = mysqli_query($conectar, $sql);

        if (mysqli_affected_rows($conectar)) {
            header('location: vendedores.php');
        }
    }
    //--> Fim do código remove o vendedor do banco de dados <--//


    //--> Começo do código que cadastra o vendedor no banco de dados <--//
    if(isset($_POST["btn_cadastrar_vendedor"])) {
        $vendedor_nome = $_POST['vendedor_nome'];
        $vendedor_sobrenome = $_POST['vendedor_sobrenome'];
        $vendedor_cpf = $_POST['vendedor_cpf'];
        $vendedor_email = $_POST['vendedor_email'];
        $vendedor_telefone = $_POST['vendedor_telefone'];

        $sql = "INSERT INTO usuario (usuario_nome, usuario_sobrenome, usuario_senha, usuario_status, usuario_email, usuario_cpf, usuario_telefone) 
        VALUES ('$vendedor_nome', '$vendedor_sobrenome', '1234', 0, '$vendedor_email', '$vendedor_cpf', '$vendedor_telefone')";

        $resultado = mysqli_query($conectar, $sql);
        mysqli_close($conectar);

        header('location: vendedores.php');
    }
    //--> Fim do código que cadastra o vendedor no banco de dados <--//


    //--> Começo do código que remove o cliente no banco de dados <--//
    if(isset($_POST["btn_remover_cliente"])) {
        $id = $_POST['btn_remover_cliente'];

        $sql = "DELETE FROM cliente WHERE cliente_id = '$id'";
        $resultado = mysqli_query($conectar, $sql);

        if (mysqli_affected_rows($conectar)) {
            header('location: clientes.php');
        }
    }
    //--> Fim do código que remove o cliente no banco de dados <--//


    if(isset($_POST["btn_cadastrar_cliente"])) {
        $nome = $_POST['cliente_nome'];
        $email = $_POST['cliente_email'];
        $cnpj = $_POST['cliente_cnpj'];
        $telefone = $_POST['cliente_telefone'];
        $inscricaoestadual = $_POST['cliente_inscricaoestadual'];
        $rua = $_POST['cliente_rua'];
        $bairro = $_POST['cliente_bairro'];
        $cep = $_POST['cliente_cep'];
        $cidade = $_POST['cliente_cidade'];
        $numero = $_POST['cliente_numero'];
        $uf = $_POST['cliente_uf'];

        $sql = "INSERT INTO cliente VALUES (NULL, '$nome', '$email', '$cnpj', '$telefone', '$inscricaoestadual', '$rua', '$bairro', '$cep', '$cidade', '$numero', '$uf')";
        $resultado = mysqli_query($conectar, $sql);

        if ($resultado) {
            header('location: clientes.php');
        }else {
            echo "erro";
        }
    }

    if(isset($_POST["btn_atualizar_cliente"])) {
        $id = $_POST['cliente_id'];
        $nome = $_POST['cliente_nome'];
        $email = $_POST['cliente_email'];
        $cnpj = $_POST['cliente_cnpj'];
        $telefone = $_POST['cliente_telefone'];
        $inscricaoestadual = $_POST['cliente_inscricaoestadual'];
        $rua = $_POST['cliente_rua'];
        $bairro = $_POST['cliente_bairro'];
        $cep = $_POST['cliente_cep'];
        $cidade = $_POST['cliente_cidade'];
        $numero = $_POST['cliente_numero'];
        $uf = $_POST['cliente_uf'];

        $sql = "UPDATE cliente SET cliente_nome = '$nome', cliente_email = '$email', cliente_cnpj = '$cnpj', cliente_telefone = '$telefone', 
        cliente_inscricaoestadual = '$inscricaoestadual', cliente_rua = '$rua', cliente_bairro = '$bairro', cliente_cep = '$cep', cliente_cidade = '$cidade',
        cliente_numero = '$numero', cliente_uf = '$uf' WHERE cliente_id = '$id'";
        $resultado = mysqli_query($conectar, $sql);

        if($resultado) {
            header('location: clientes.php');
        }
    }

    if(isset($_POST["btn-cadastrar-produto"])) {
        $nome = $_POST['produto_nome'];
        $valor = $_POST['produto_valor'];
        $descricao = $_POST['produto_descricao'];
        $categoria = $_POST['produto_categoria'];
        $fabricante = $_POST['produto_fabricante'];
        $imagem = $_FILES['produto_imagem']['tmp_name'];
        $tamanho = $_FILES['produto_imagem']['size'];

        if($imagem != "none") {
            $fp = fopen($imagem, "rb");
            $conteudo = fread($fp, $tamanho);
            $conteudo = addslashes($conteudo);
            fclose($fp);
            
            $sql = "INSERT INTO produto VALUES (NULL, '$nome', '$valor', '$descricao', '$categoria', '$fabricante', '$conteudo')";
            $resultado = mysqli_query($conectar, $sql);

            if ($resultado) {
                header('location: produtos.php');
            }else {
                echo "erro";
            }
        }
    }

    if(isset($_POST["btn_remover_produto"])) {
        $id = $_POST['btn_remover_produto'];

        $sql = "DELETE FROM produto WHERE produto_id = '$id'";
        $resultado = mysqli_query($conectar, $sql);

        if (mysqli_affected_rows($conectar)) {
            header('location: produtos.php');
        }
    }

    if(isset($_POST["btn_atualizar_produto"]) and empty($_POST['produto_imagem'])) {
        $id = $_POST['produto_id'];
        $nome = $_POST['produto_nome'];
        $valor = $_POST['produto_valor'];
        $descricao = $_POST['produto_descricao'];
        $categoria = $_POST['produto_categoria'];
        $fabricante = $_POST['produto_fabricante'];

        $sql = "UPDATE produto SET produto_nome = '$nome', produto_valor = '$valor', produto_descricao = '$descricao', produto_categoria = '$descricao', produto_fabricante 
        = '$fabricante' WHERE produto_id = '$id'";
        $resultado = mysqli_query($conectar, $sql);

        if ($resultado) {
            header('location: produtos.php');
        }else {
            echo "erro";
        }
        
    }

    if(isset($_POST["btn_atualizar_produto"])) {
        $imagem = $_FILES['produto_imagem']['tmp_name'];
        $tamanho = $_FILES['produto_imagem']['size'];

        if ($imagem != "none") {
            $fp = fopen($imagem, "rb");
            $conteudo = fread($fp, $tamanho);
            $conteudo = addslashes($conteudo);
            fclose($fp);
            
            $sql = "UPDATE produto SET produto_nome = '$nome', produto_valor = '$valor', produto_descricao = '$descricao', produto_categoria = '$categoria', produto_fabricante 
            = '$fabricante', produto_imagem = '$conteudo' WHERE produto_id = '$id'";
            $resultado = mysqli_query($conectar, $sql);

            if ($resultado) {
                header('location: produtos.php');
            }else {
                echo "erro";
            }
        }
    }


    if(isset($_POST["btn_cadastrar_pedido"])) {
        $cliente_id = $_POST['pedido_cliente_id'];
        $vendedor_id = $_POST['pedido_vendedor_id'];

        $sql = "INSERT INTO pedido VALUES (NULL, NOW(), 0, 0, 0 , $cliente_id, $vendedor_id)";
        $resultado = mysqli_query($conectar, $sql);

        if ($resultado) {

            $ultimo_id = mysqli_insert_id($conectar);

            header('location: fazerpedido.php?id='.$ultimo_id);
        }
    }

    if (isset($_POST["btn_adicionar_produto"])) {
        $produto_id = $_POST['produto_id'];
        $pd_quantidade = $_POST['pd_quantidade'];
        $pedido_id = $_POST['pedido_id'];

        $sql = "INSERT INTO pedido_produtos VALUES ($pedido_id, $produto_id, $pd_quantidade)";
        $resultado = mysqli_query($conectar, $sql);

        if ($resultado) {
            header('location: fazerpedido.php?id='.$pedido_id);
        }
    }

    if (isset($_POST["btn_finalizar_pedido"])) {
        $id = $_POST['btn_finalizar_pedido'];
        $pedido_valor = $_POST['pedido_valor'];

        $sql = "UPDATE pedido SET pedido_valor = $pedido_valor, pedido_finalizado = 1 WHERE pedido_id = $id";
        $resultado = mysqli_query($conectar, $sql);

        if (!empty($resultado)) {
            header('location: pedidos.php');
        }
    }

    if (isset($_POST["btn_remover_pedido"])) {
        $id = $_POST['btn_remover_pedido'];

        $sql = "DELETE FROM pedido WHERE `pedido`.`pedido_id` = $id";
        $resultado = mysqli_query($conectar, $sql);

        if ($resultado) {
            header('location:pedidos.php');
        }
    }

    if (isset($_POST["btn_enviar_pedido"])) {
        $id = $_POST['btn_enviar_pedido'];
        $pedido_valor = $_POST['pedido_valor'];

        $sql = "UPDATE pedido SET pedido_status = 1, pedido_finalizado = 1, pedido_valor = '$pedido_valor' WHERE pedido_id = '$id'";
        $resultado = mysqli_query($conectar, $sql);

        if (!empty($resultado)) {
            header('location: enviopendente.php');
        }
    }
?>