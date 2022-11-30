<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$id_logado = $_SESSION['id_logado'];
$nome_logado = $_SESSION['nome_logado'];
$status = $_SESSION['status'];

?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Interface</title>
</head>
<body>
    <?php
    if ($status == 1) {
        echo"
        <header>
            <div class='login'>
                <h1>Bem-vindo, <span>".$nome_logado."</span>!</h1>
            </div>
            <nav>
                <ul>
                    <li id='li-visao-geral'><i class='fa-solid fa-house'></i><a href='index.php'>Visão Geral</a></li>
                    <li id='li-produtos' class='active'><i class='fa-solid fa-bag-shopping'></i><a href='produtos.php'>Produtos</a></li>
                    <li id='li-visao-geral'><i class='fa-solid fa-cart-shopping'></i><a href='pedidos.php'>Pedidos</a></li>
                    <li id='li-clientes'><i class='fa-solid fa-person-arrow-down-to-line'></i></i></i><a href='clientes.php'>Clientes</a></li>
                    <li id='li-vendedores'><i class='fa-solid fa-person-arrow-up-from-line'></i><a href='vendedores.php'>Vendedores</a></li>
                    <li id='li-relatorios'><i class='fa-solid fa-arrow-right-from-bracket'></i><a href='logout.php'>Sair</a></li>
                </ul>
            </nav>
            <footer><h1>Desenvolvido por <span>Eder Seefeldt</span></h1></footer>
        </header>";
    }else {
        echo"
        <header>
            <div class='login'>
                <h1>Bem-vindo, <span>".$nome_logado."</span>!</h1>
            </div>
            <nav>
                <ul>
                    <li id='li-visao-geral'><i class='fa-solid fa-house'></i><a href='index.php'>Visão Geral</a></li>
                    <li id='li-produtos'class='active'><i class='fa-solid fa-bag-shopping'></i><a href='produtos.php'>Produtos</a></li>
                    <li id='li-visao-geral'><i class='fa-solid fa-cart-shopping'></i><a href='pedidos.php'>Pedidos</a></li>
                    <li id='li-relatorios'><i class='fa-solid fa-arrow-right-from-bracket'></i><a href='logout.php'>Sair</a></li>
                </ul>
            </nav>
            <footer><h1>Desenvolvido por <span>Eder Seefeldt</span></h1></footer>
        </header>";
    }
    ?>

<?php
    if ($status == 1) {
        echo"
        <section class='section-produtos'>
            <div class='display-1'>
                <div class='header-produtos'>
                    <div class='titulos-vg'><i class='fa-solid fa-note-sticky'></i>Catálogo de Produtos</div>
                    <form action='' method='POST' autocomplete='off'>
                        <input type='text' name='result_busca' placeholder='Busque por ID, nome ou categoria do produto...'>
                        <input type='submit' name='btn_buscar' value='Buscar'>
                    </form>
                </div>
                <div class='form-cadastro-produto'>
                    <h2 class='titulos-vg'>Cadastrar Novo Produto</h2>
                    <form action='code.php' method='POST' enctype='multipart/form-data'>
                        <div class='inputs'>
                            <div class='input'><span>Nome</span><input type='text' name='produto_nome' placeholder='Digite o nome do produto' required></div>
                            <div class='input'><span>Valor</span><input type='text' name='produto_valor' placeholder='Digite o valor do produto' required></div>
                            <div class='input'><span>Descrição</span><input type='text' name='produto_descricao' placeholder='Informações sobre o produto' required></div>
                            <div class='input'><span>Categoria</span><input type='text' name='produto_categoria' placeholder='Digite a categoria do produto' required></div>
                            <div class='input'><span>Fabricante</span><input type='text' name='produto_fabricante' placeholder='Digite o fabricante do produto' required></div>
                            <div class='input'><input class='input-imagem' type='file' name='produto_imagem' required></div>
                        </div>

                        <div class='btns-forms'>
                            <input class='list-btn-edit' type='submit' name='btn-cadastrar-produto' value='Cadastrar'>
                            <input class='btn-back' type='reset' value='Excluir'>
                        </div>
                    </form>
                </div>  
                <div class='produtos'>
        ";
                    if (isset($_POST["btn_buscar"])) {
                        $busca = $_POST['result_busca'];

                        if (!empty($busca)) {
                            $sql = "SELECT * FROM produto WHERE produto_id LIKE '%$busca%' OR produto_nome LIKE '%$busca%' OR produto_categoria LIKE '%$busca%'";
                            $resultado = mysqli_query($conectar, $sql);

                            while ($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['produto_id'];
                                $nome = $registro['produto_nome'];
                                $valor = $registro['produto_valor'];    
                                $descricao = $registro['produto_descricao'];
                                $fabricante = $registro['produto_fabricante'];
                                $imagem = $registro['produto_imagem'];

                                echo"<div class='produto'>
                                    <div class='img-produto'>
                                        <img src='abrir_imagens.php?id=".$id."'/>
                                    </div>
                                    <div class='infos-produto'>
                                        <h1>".$nome."</h1>
                                        <p>".$descricao."</p>
                                        <p>".$fabricante."</p>
                                        <p>R$<span>".$valor."</span></p>
                                    </div>
                                    <div class='btns-produto'>
                                        <a class='list-btn-edit' href='editarproduto.php?id=".$id."'>Editar</a>
                                        <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_produto' value=".$id.">Remover</button></form>
                                    </div>
                                </div>";
                            }
                        }else {
                            $sql = "SELECT * FROM produto";
                            $resultado = mysqli_query($conectar, $sql);

                            while ($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['produto_id'];
                                $nome = $registro['produto_nome'];
                                $valor = $registro['produto_valor'];    
                                $descricao = $registro['produto_descricao'];
                                $fabricante = $registro['produto_fabricante'];
                                $imagem = $registro['produto_imagem'];

                                echo"<div class='produto'>
                                    <div class='img-produto'>
                                        <img src='abrir_imagens.php?id=".$id."'/>
                                    </div>
                                    <div class='infos-produto'>
                                        <h1>".$nome."</h1>
                                        <p>".$descricao."</p>
                                        <p>".$fabricante."</p>
                                        <p>R$<span>".$valor."</span></p>
                                    </div>
                                    <div class='btns-produto'>
                                        <a class='list-btn-edit' href='editarproduto.php?id=".$id."'>Editar</a>
                                        <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_produto' value=".$id.">Remover</button></form>
                                    </div>
                                </div>";
                            }
                        }
                    }else {
                        $sql = "SELECT * FROM produto";
                        $resultado = mysqli_query($conectar, $sql);

                        while ($registro = mysqli_fetch_array($resultado)) {
                            $id = $registro['produto_id'];
                            $nome = $registro['produto_nome'];
                            $valor = $registro['produto_valor'];    
                            $descricao = $registro['produto_descricao'];
                            $fabricante = $registro['produto_fabricante'];
                            $imagem = $registro['produto_imagem'];

                            echo"<div class='produto'>
                                <div class='img-produto'>
                                    <img src='abrir_imagens.php?id=".$id."'/>
                                </div>
                                <div class='infos-produto'>
                                    <h1>".$nome."</h1>
                                    <p>".$descricao."</p>
                                    <p>".$fabricante."</p>
                                    <p>R$<span>".$valor."</span></p>
                                </div>
                                <div class='btns-produto'>
                                    <a class='list-btn-edit' href='editarproduto.php?id=".$id."'>Editar</a>
                                    <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_produto' value=".$id.">Remover</button></form>
                                </div>
                            </div>";
                        }
                    }
                echo"
                </div>
            </div>
        </section>";
    }else {
        echo"
        <section class='section-produtos'>
            <div class='display-1'>
                <div class='header-produtos'>
                    <div class='titulos-vg'><i class='fa-solid fa-note-sticky'></i>Catálogo de Produtos</div>
                    <form action='' method='POST' autocomplete='off'>
                        <input type='text' name='result_busca' placeholder='Busque por ID, nome ou categoria do produto...'>
                        <input type='submit' name='btn_buscar' value='Buscar'>
                    </form>
                </div> 
                <div class='produtos' style='position: absolute; width: 78vw; height: 90vh; bottom: 0'>
        ";
                    if (isset($_POST["btn_buscar"])) {
                        $busca = $_POST['result_busca'];

                        if (!empty($busca)) {
                            $sql = "SELECT * FROM produto WHERE produto_id LIKE '%$busca%' OR produto_nome LIKE '%$busca%' OR produto_categoria LIKE '%$busca%'";
                            $resultado = mysqli_query($conectar, $sql);

                            while ($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['produto_id'];
                                $nome = $registro['produto_nome'];
                                $valor = $registro['produto_valor'];    
                                $descricao = $registro['produto_descricao'];
                                $fabricante = $registro['produto_fabricante'];
                                $imagem = $registro['produto_imagem'];

                                echo"<div class='produto'>
                                    <div class='img-produto'>
                                        <img src='abrir_imagens.php?id=".$id."'/>
                                    </div>
                                    <div class='infos-produto'>
                                        <h1>".$nome."</h1>
                                        <p>".$descricao."</p>
                                        <p>".$fabricante."</p>
                                        <p>R$<span>".$valor."</span></p>
                                    </div>
                                </div>";
                            }
                        }else {
                            $sql = "SELECT * FROM produto";
                            $resultado = mysqli_query($conectar, $sql);

                            while ($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['produto_id'];
                                $nome = $registro['produto_nome'];
                                $valor = $registro['produto_valor'];    
                                $descricao = $registro['produto_descricao'];
                                $fabricante = $registro['produto_fabricante'];
                                $imagem = $registro['produto_imagem'];

                                echo"<div class='produto'>
                                    <div class='img-produto'>
                                        <img src='abrir_imagens.php?id=".$id."'/>
                                    </div>
                                    <div class='infos-produto'>
                                        <h1>".$nome."</h1>
                                        <p>".$descricao."</p>
                                        <p>".$fabricante."</p>
                                        <p>R$<span>".$valor."</span></p>
                                    </div>
                                </div>";
                            }
                        }
                    }else {
                        $sql = "SELECT * FROM produto";
                        $resultado = mysqli_query($conectar, $sql);

                        while ($registro = mysqli_fetch_array($resultado)) {
                            $id = $registro['produto_id'];
                            $nome = $registro['produto_nome'];
                            $valor = $registro['produto_valor'];    
                            $descricao = $registro['produto_descricao'];
                            $fabricante = $registro['produto_fabricante'];
                            $imagem = $registro['produto_imagem'];

                            echo"<div class='produto'>
                                <div class='img-produto'>
                                    <img src='abrir_imagens.php?id=".$id."'/>
                                </div>
                                <div class='infos-produto'>
                                    <h1>".$nome."</h1>
                                    <p>".$descricao."</p>
                                    <p>".$fabricante."</p>
                                    <p>R$<span>".$valor."</span></p>
                                </div>
                            </div>";
                        }
                    }
                echo"
                </div>
            </div>
        </section>";
    }
    ?>

    <script src="script.js"></script>
</body>
</html>