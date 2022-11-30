<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$nome_logado = $_SESSION['nome_logado'];
$status = $_SESSION['status'];
$id_logado = $_SESSION['id_logado'];

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
        <div class="display">
            <div class="header-pedidos">
                <a href="pedidos.php">Novo Pedido</a>
                <a style="height: 10vh; background-color: #0066db;" href="pedidosafinalizar.php">Pedidos à finalizar</a>
                <a href="enviopendente.php">Envio Pendente</a>
                <a href="pedidosenviados.php">Pedidos Enviados</a>
            </div>
            <div class="body-pedidos">
                <div class="buscar-cliente">
                    <h1 class="titulos-vg">Selecione um pedido</h1>
                    <form action="" method="POST" autocomplete="off">
                        <input type="text" name="result_busca" placeholder="Busque por ID ou nome do cliente...">
                        <input type="submit" name="btn_buscar_cliente" value="Buscar">
                    </form>
                </div>
                <div class="lista-pedidos">
                <?php 
                if(isset($_POST["btn_buscar_cliente"])) {
                    $busca = $_POST['result_busca'];

                    if(!empty($busca)) {

                        $sql = "SELECT pedido_id, cliente_nome, pedido_data, SUM(pd_quantidade * produto_valor) AS 'valor_total' FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id 
                        INNER JOIN pedido_produtos PD ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PR.produto_id = PD.pd_produto_id 
                        WHERE P.pedido_id LIKE '%$busca%' OR C.cliente_nome LIKE '%$busca%' AND pedido_usuario_id = '$id_logado' AND P.pedido_finalizado = 0 GROUP BY P.pedido_id";
                        $resultado = mysqli_query($conectar, $sql);
                        
                        while ($registro = mysqli_fetch_array($resultado)) {
                            $pedido_id = $registro['pedido_id'];
                            $cliente_nome = $registro['cliente_nome'];
                            $pedido_data = $registro['pedido_data'];
                            $pedido_valor = $registro['valor_total'];

                            echo "
                            <div class='pedido'>
                                <div style='width: 9vw;'>
                                    <h2>ID do pedido</h2>
                                    <p>".$pedido_id."</p>
                                </div>
                                <div style='width: 14vw;'>
                                    <h2>Cliente</h2>
                                    <p>".$cliente_nome."</p>
                                </div>
                                <div style='width: 12vw;'>
                                    <h2>Data do Pedido</h2>
                                    <p>".$pedido_data."</p>
                                </div>
                                <div style='width: 10.5vw;'>
                                    <h2>Valor do Pedido</h2>
                                    <p>R$".$pedido_valor."</p>
                                </div>
                                <div style='width: 9vw; display: flex; align-items: center;'>
                                    <span style='background-color: #FAD390;' class='pedido-status'>Não Finalizado</span>
                                </div>
                                <div class='btns-pedidos-a-finalizar'>
                                    <a style='background-color: #00a000;' href='fazerpedido.php?id=".$pedido_id."'>Continuar</a>
                                    <form action='code.php' method='POST'>
                                        <input type='hidden' name='pedido_vendedor_id' value=".$id_logado.">
                                        <input type='hidden' name='pedido_cliente_id' value=".$pedido_id.">
                                        <input type='hidden' name='pedido_valor' value=".$pedido_valor.">
                                        <button style='background-color: #0066db;' name='btn_finalizar_pedido' value=".$pedido_id.">Finalizar</button>
                                        <button style='background-color: #DC3545;' name='btn_remover_pedido' value=".$pedido_id.">Remover</button>
                                    </form>
                                </div>
                            </div>
                            ";
                        }
                    }else {
                        $sql = "SELECT pedido_id, cliente_nome, pedido_data, SUM(pd_quantidade * produto_valor) AS 'valor_total' FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id 
                        INNER JOIN pedido_produtos PD ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PR.produto_id = PD.pd_produto_id WHERE pedido_usuario_id = '$id_logado' AND P.pedido_finalizado = 0 GROUP BY P.pedido_id";
                        $resultado = mysqli_query($conectar, $sql);
                        
                        while ($registro = mysqli_fetch_array($resultado)) {
                            $pedido_id = $registro['pedido_id'];
                            $cliente_nome = $registro['cliente_nome'];
                            $pedido_data = $registro['pedido_data'];
                            $pedido_valor = $registro['valor_total'];

                            echo "
                            <div class='pedido'>
                                <div style='width: 9vw;'>
                                    <h2>ID do pedido</h2>
                                    <p>".$pedido_id."</p>
                                </div>
                                <div style='width: 14vw;'>
                                    <h2>Cliente</h2>
                                    <p>".$cliente_nome."</p>
                                </div>
                                <div style='width: 12vw;'>
                                    <h2>Data do Pedido</h2>
                                    <p>".$pedido_data."</p>
                                </div>
                                <div style='width: 10.5vw;'>
                                    <h2>Valor do Pedido</h2>
                                    <p>R$".$pedido_valor."</p>
                                </div>
                                <div style='width: 9vw; display: flex; align-items: center;'>
                                    <span style='background-color: #FAD390;' class='pedido-status'>Não Finalizado</span>
                                </div>
                                <div class='btns-pedidos-a-finalizar'>
                                    <a style='background-color: #00a000;' href='fazerpedido.php?id=".$pedido_id."'>Continuar</a>
                                    <form action='code.php' method='POST'>
                                        <input type='hidden' name='pedido_vendedor_id' value=".$id_logado.">
                                        <input type='hidden' name='pedido_cliente_id' value=".$pedido_id.">
                                        <input type='hidden' name='pedido_valor' value=".$pedido_valor.">
                                        <button style='background-color: #0066db;' name='btn_finalizar_pedido' value=".$pedido_id.">Finalizar</button>
                                        <button style='background-color: #DC3545;' name='btn_remover_pedido' value=".$pedido_id.">Remover</button>
                                    </form>
                                </div>
                            </div>
                            ";
                        }
                    }
                }else {
                    $sql = "SELECT pedido_id, cliente_nome, pedido_data, SUM(pd_quantidade * produto_valor) AS 'valor_total' FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id 
                    INNER JOIN pedido_produtos PD ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PR.produto_id = PD.pd_produto_id WHERE pedido_usuario_id = '$id_logado' AND P.pedido_finalizado = 0 GROUP BY P.pedido_id";
                    $resultado = mysqli_query($conectar, $sql);
                    
                    while ($registro = mysqli_fetch_array($resultado)) {
                        $pedido_id = $registro['pedido_id'];
                        $cliente_nome = $registro['cliente_nome'];
                        $pedido_data = $registro['pedido_data'];
                        $pedido_valor = $registro['valor_total'];

                        echo "
                        <div class='pedido'>
                            <div style='width: 9vw;'>
                                <h2>ID do pedido</h2>
                                <p>".$pedido_id."</p>
                            </div>
                            <div style='width: 14vw;'>
                                <h2>Cliente</h2>
                                <p>".$cliente_nome."</p>
                            </div>
                            <div style='width: 12vw;'>
                                <h2>Data do Pedido</h2>
                                <p>".$pedido_data."</p>
                            </div>
                            <div style='width: 10.5vw;'>
                                <h2>Valor do Pedido</h2>
                                <p>R$".$pedido_valor."</p>
                            </div>
                            <div style='width: 9vw; display: flex; align-items: center;'>
                                <span style='background-color: #FAD390;' class='pedido-status'>Não Finalizado</span>
                            </div>
                            <div class='btns-pedidos-a-finalizar'>
                                <a style='background-color: #00a000;' href='fazerpedido.php?id=".$pedido_id."'>Continuar</a>
                                <form action='code.php' method='POST'>
                                    <input type='hidden' name='pedido_vendedor_id' value=".$id_logado.">
                                    <input type='hidden' name='pedido_cliente_id' value=".$pedido_id.">
                                    <input type='hidden' name='pedido_valor' value=".$pedido_valor.">
                                    <button style='background-color: #0066db;' name='btn_finalizar_pedido' value=".$pedido_id.">Finalizar</button>
                                    <button style='background-color: #DC3545;' name='btn_remover_pedido' value=".$pedido_id.">Remover</button>
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