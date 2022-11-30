<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$id_logado = $_SESSION['id_logado'];
$nome_logado = $_SESSION['nome_logado'];
$status = $_SESSION['status'];

$pedido_id = $_GET['id'];

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
                    <li id='li-produtos'><i class='fa-solid fa-bag-shopping'></i><a href='produtos.php'>Produtos</a></li>
                    <li id='li-visao-geral' class='active'><i class='fa-solid fa-cart-shopping'></i><a href='pedidos.php'>Pedidos</a></li>
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
                    <li id='li-produtos'><i class='fa-solid fa-bag-shopping'></i><a href='produtos.php'>Produtos</a></li>
                    <li id='li-visao-geral' class='active'><i class='fa-solid fa-cart-shopping'></i><a href='pedidos.php'>Pedidos</a></li>
                    <li id='li-relatorios'><i class='fa-solid fa-arrow-right-from-bracket'></i><a href='logout.php'>Sair</a></li>
                </ul>
            </nav>
            <footer><h1>Desenvolvido por <span>Eder Seefeldt</span></h1></footer>
        </header>";
    }
    ?>

    <section class="section-pedidos">
        <div class="display-2">
            <div class="infos-pedido">
                <?php

                $sql = "SELECT cliente_nome FROM cliente C INNER JOIN pedido P ON C.cliente_id = P.pedido_cliente_id WHERE P.pedido_id = $pedido_id";
                $resultado = mysqli_query($conectar, $sql);
                $nome_cliente = mysqli_fetch_assoc($resultado);
                    echo "<p><span>ID do Pedido:</span> $pedido_id </p>";
                    echo "<p><span>Cliente:</span> $nome_cliente[cliente_nome]</p>";
                ?>
            </div>
            <div class="pedido-produtos">
                <div class="lista-produtos">
                    <?php
                    
                    $sql = "SELECT produto_id, produto_nome, pd_quantidade, produto_valor, pd_quantidade * produto_valor AS 'valor_total' FROM produto P INNER JOIN pedido_produtos PD ON P.produto_id = PD.pd_produto_id WHERE PD.pd_pedido_id = $pedido_id";
                    $resultado = mysqli_query($conectar, $sql);

                    if (!empty($resultado)) {
                        while($registro = mysqli_fetch_array($resultado)) {
                            $produto_id = $registro['produto_id'];
                            $produto_nome = $registro['produto_nome'];
                            $pd_quantidade = $registro['pd_quantidade'];
                            $produto_valor = $registro['produto_valor'];
                            $valor_total = $registro['valor_total'];
                            
                                echo" <div class='pedido-produto'>
                                    <div style='width: 5vw;'>
                                        <h2>ID</h2>
                                        <p>".$produto_id."</p>
                                    </div>
                                    <div style='width: 19vw;'>
                                        <h2>Nome</h2>
                                        <p>".$produto_nome."</p>
                                    </div>
                                    <div style='width: 8vw;'>
                                        <h2>Quantidade</h2>
                                        <p>".$pd_quantidade."</p>
                                    </div>
                                    <div style='width: 11vw;'>
                                        <h2>Valor do Produto</h2>
                                        <p><span>R$</span>".$produto_valor."</p>
                                    </div>
                                    <div style='width: 7vw;'>
                                        <h2>Valor Total</h2>
                                        <p><span>R$</span>".$valor_total."</p>
                                    </div>
                                </div>";
                        }
                    }
                    ?>
                </div>
                <div class="btns-pedido-produtos">
                    <?php 

                    $sql = "SELECT SUM(pd_quantidade * produto_valor) AS 'valor_pedido' FROM pedido_produtos PD INNER JOIN produto p ON pd.pd_produto_id = p.produto_id WHERE pd.pd_pedido_id = $pedido_id;";
                    $resultado = mysqli_query($conectar, $sql);
                    $valor_pedido = mysqli_fetch_assoc($resultado);

                    echo "<p><span>Valor do Pedido:</span> R$ ".$valor_pedido['valor_pedido']." </p>
                    <form action='code.php' method='POST'>
                        <input type='hidden' name='pedido_valor' value=".$valor_pedido['valor_pedido'].">
                        <button class='list-btn-edit' name='btn_finalizar_pedido' value=".$pedido_id.">Finalizar Pedido</button>
                        <button class='list-btn-delete' name='btn_remover_pedido' value=".$pedido_id.">Remover Pedido</button>
                    </form>";
                    ?>
                </div>
            </div>
            <div class="catalogo">
                <div class="busca-produtos">
                    <form action="" method="POST" autocomplete="off">
                        <input type="text" name="result_busca" placeholder="Busque por ID, nome ou categoria...">
                        <input type="submit" name="btn_buscar_cliente" value="Buscar">
                    </form>
                </div>
                <div class="produtos">
                <?php 
                if(isset($_POST["btn_buscar_cliente"])) {
                    $busca = $_POST['result_busca'];

                    if(!empty($busca)) {
                        $sql = "SELECT produto_id, produto_nome, produto_valor, produto_categoria, produto_imagem FROM produto WHERE produto_id LIKE '%$busca%' OR produto_nome LIKE '%$busca%' OR produto_categoria LIKE '%$busca%'";
                        $resultado = mysqli_query($conectar, $sql);

                        while($registro = mysqli_fetch_array($resultado)) {
                        $produto_id = $registro['produto_id'];
                        $produto_nome = $registro['produto_nome'];
                        $produto_categoria = $registro['produto_categoria'];
                        $produto_valor = $registro['produto_valor'];

                            echo "
                                <div class='produto'>
                                    <img src='abrir_imagens.php?id=".$produto_id."'/>
                                    <p>".$produto_nome."</p>
                                    <p>R$".$produto_valor."</p>
                                    <p>".$produto_categoria."</p>
                                    <div class='btns_produto'>
                                        <form action='code.php' method='POST'>
                                            <input type='hidden' name='pedido_id' value=".$pedido_id.">
                                            <input type='hidden' name='produto_id' value=".$produto_id.">
                                            <input type='number' class='input-quantidade' name='pd_quantidade' placeholder='Quantid...' required>
                                            <input type='submit' class='input-submit' name='btn_adicionar_produto' value='Adicionar ao Pedido'>
                                        </form>
                                    </div>
                                </div>
                            ";
                        }
                    }else {
                        $sql = "SELECT produto_id, produto_nome, produto_valor, produto_categoria, produto_imagem FROM produto";
                        $resultado = mysqli_query($conectar, $sql);

                        while($registro = mysqli_fetch_array($resultado)) {
                        $produto_id = $registro['produto_id'];
                        $produto_nome = $registro['produto_nome'];
                        $produto_categoria = $registro['produto_categoria'];
                        $produto_valor = $registro['produto_valor'];

                            echo "
                                <div class='produto'>
                                    <img src='abrir_imagens.php?id=".$produto_id."'/>
                                    <p>".$produto_nome."</p>
                                    <p>R$".$produto_valor."</p>
                                    <p>".$produto_categoria."</p>
                                    <div class='btns_produto'>
                                        <form action='code.php' method='POST'>
                                            <input type='hidden' name='pedido_id' value=".$pedido_id.">
                                            <input type='hidden' name='produto_id' value=".$produto_id.">
                                            <input type='number' class='input-quantidade' name='pd_quantidade' placeholder='Quantid...' required>
                                            <input type='submit' class='input-submit' name='btn_adicionar_produto' value='Adicionar ao Pedido'>
                                        </form>
                                    </div>
                                </div>
                            ";
                        }
                    }   
                }else {
                    $sql = "SELECT produto_id, produto_nome, produto_valor, produto_categoria, produto_imagem FROM produto";
                    $resultado = mysqli_query($conectar, $sql);

                    while($registro = mysqli_fetch_array($resultado)) {
                    $produto_id = $registro['produto_id'];
                    $produto_nome = $registro['produto_nome'];
                    $produto_categoria = $registro['produto_categoria'];
                    $produto_valor = $registro['produto_valor'];

                        echo "
                            <div class='produto'>
                                <img src='abrir_imagens.php?id=".$produto_id."'/>
                                <p>".$produto_nome."</p>
                                <p>R$".$produto_valor."</p>
                                <p>".$produto_categoria."</p>
                                <div class='btns_produto'>
                                    <form action='code.php' method='POST'>
                                        <input type='hidden' name='pedido_id' value=".$pedido_id.">
                                        <input type='hidden' name='produto_id' value=".$produto_id.">
                                        <input type='number' class='input-quantidade' name='pd_quantidade' placeholder='Quantid...' required>
                                        <input type='submit' class='input-submit' name='btn_adicionar_produto' value='Adicionar ao Pedido'>
                                    </form>
                                </div>
                            </div>
                        ";
                    }
                }
                ?>  
                </div>
                
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>