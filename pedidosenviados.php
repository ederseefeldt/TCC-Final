<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$nome_logado = $_SESSION['nome_logado'];
$status = $_SESSION['status'];
$id_logado = $_SESSION['id_logado'];
$vendedor_id = $_SESSION['id_logado'];

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
                <a href="pedidosafinalizar.php">Pedidos à finalizar</a>
                <a href="enviopendente.php">Envio Pendente</a>
                <a style="height: 10vh; background-color: #0066db;" href="pedidosenviados.php">Pedidos Enviados</a>
            </div>
            <div class="body-pedidos">
                <?php 
                if ($status == 1) {
                    echo"
                    <div class='buscar-cliente'>
                        <h1 class='titulos-vg'>Selecione um pedido</h1>
                        <form action='' method='POST' autocomplete='off'>
                            <input type='text' name='result_busca' placeholder='Busque por ID ou nome do cliente...'>
                            <input type='submit' name='btn_buscar_cliente' value='Buscar'>
                        </form>
                    </div>
                    <div class='lista-pedidos'>";
                    
                    if(isset($_POST["btn_buscar_cliente"])) {
                        $busca = $_POST['result_busca'];

                        if(!empty($busca)) {

                            $sql = "SELECT pedido_id, SUM(pd_quantidade * produto_valor) AS 'valor_total', COUNT(pd_pedido_id) AS 'quant_produtos', pedido_data, cliente_id, cliente_nome, 
                            cliente_cidade, cliente_cnpj, cliente_telefone FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id INNER JOIN pedido_produtos PD 
                            ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PD.pd_produto_id = PR.produto_id WHERE P.pedido_id LIKE '%$busca%' OR C.cliente_nome LIKE '%$busca%' AND P.pedido_status = 1 GROUP BY pedido_id";
                            $resultado = mysqli_query($conectar, $sql);
                            
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $pedido_id = $registro['pedido_id'];
                                $pedido_data = $registro['pedido_data'];
                                $pedido_valor = $registro['valor_total'];
                                $quant_produtos = $registro['quant_produtos'];
                                $cliente_id = $registro['cliente_id'];
                                $cliente_nome = $registro['cliente_nome'];
                                $cliente_cidade = $registro['cliente_cidade'];
                                $cliente_cnpj = $registro['cliente_cnpj'];
                                $cliente_telefone = $registro['cliente_telefone'];

                                echo "<div class='pedido-enviado'>
                                    <div class='infos-pedido'>
                                        <h2>Informações do Pedido</h2>
                                        <div>
                                            <p>ID: ".$pedido_id."</p>
                                            <p>Valor: ".$pedido_valor."</p>
                                            <p>Data: ".$pedido_data."</p>
                                            <p>Quant. Produtos: ".$quant_produtos."</p>
                                        </div>
                                    </div>
                                    <div class='infos-cliente'>
                                        <h2>Informações do Cliente</h2>
                                        <div>
                                            <p>ID: ".$cliente_id."</p>
                                            <p>Nome: ".$cliente_nome."</p>
                                            <p>Cidade: ".$cliente_cidade."</p>
                                            <p>CNPJ: ".$cliente_cnpj."</p>
                                            <p>Telefone: ".$cliente_telefone."</p>
                                        </div>
                                    </div>
                                    <div class='status'>
                                        <p>Enviado</p>
                                    </div>
                                </div>
                                ";
                            }
                        }else {

                            $sql = "SELECT pedido_id, SUM(pd_quantidade * produto_valor) AS 'valor_total', COUNT(pd_pedido_id) AS 'quant_produtos', pedido_data, cliente_id, cliente_nome, 
                            cliente_cidade, cliente_cnpj, cliente_telefone FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id INNER JOIN pedido_produtos PD 
                            ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PD.pd_produto_id = PR.produto_id WHERE P.pedido_status = 1 GROUP BY pedido_id";
                            $resultado = mysqli_query($conectar, $sql);
                            
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $pedido_id = $registro['pedido_id'];
                                $pedido_data = $registro['pedido_data'];
                                $pedido_valor = $registro['valor_total'];
                                $quant_produtos = $registro['quant_produtos'];
                                $cliente_id = $registro['cliente_id'];
                                $cliente_nome = $registro['cliente_nome'];
                                $cliente_cidade = $registro['cliente_cidade'];
                                $cliente_cnpj = $registro['cliente_cnpj'];
                                $cliente_telefone = $registro['cliente_telefone'];

                                echo "
                                <div class='pedido-enviado'>
                                    <div class='infos-pedido'>
                                        <h2>Informações do Pedido</h2>
                                        <div>
                                            <p>ID: ".$pedido_id."</p>
                                            <p>Valor: ".$pedido_valor."</p>
                                            <p>Data: ".$pedido_data."</p>
                                            <p>Quant. Produtos: ".$quant_produtos."</p>
                                        </div>
                                    </div>
                                    <div class='infos-cliente'>
                                        <h2>Informações do Cliente</h2>
                                        <div>
                                            <p>ID: ".$cliente_id."</p>
                                            <p>Nome: ".$cliente_nome."</p>
                                            <p>Cidade: ".$cliente_cidade."</p>
                                            <p>CNPJ: ".$cliente_cnpj."</p>
                                            <p>Telefone: ".$cliente_telefone."</p>
                                        </div>
                                    </div>
                                    <div class='status'>
                                        <p>Enviado</p>
                                    </div>
                                </div>
                                ";
                            }
                        }
                    }else {

                        $sql = "SELECT pedido_id, SUM(pd_quantidade * produto_valor) AS 'valor_total', COUNT(pd_pedido_id) AS 'quant_produtos', pedido_data, cliente_id, cliente_nome, 
                        cliente_cidade, cliente_cnpj, cliente_telefone FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id INNER JOIN pedido_produtos PD 
                        ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PD.pd_produto_id = PR.produto_id WHERE P.pedido_status = 1 GROUP BY pedido_id";
                        $resultado = mysqli_query($conectar, $sql);
                            
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $pedido_id = $registro['pedido_id'];
                                $pedido_data = $registro['pedido_data'];
                                $pedido_valor = $registro['valor_total'];
                                $quant_produtos = $registro['quant_produtos'];
                                $cliente_id = $registro['cliente_id'];
                                $cliente_nome = $registro['cliente_nome'];
                                $cliente_cidade = $registro['cliente_cidade'];
                                $cliente_cnpj = $registro['cliente_cnpj'];
                                $cliente_telefone = $registro['cliente_telefone'];

                                echo "
                                <div class='pedido-enviado'>
                                    <div class='infos-pedido'>
                                        <h2>Informações do Pedido</h2>
                                        <div>
                                            <p>ID: ".$pedido_id."</p>
                                            <p>Valor: ".$pedido_valor."</p>
                                            <p>Data: ".$pedido_data."</p>
                                            <p>Quant. Produtos: ".$quant_produtos."</p>
                                        </div>
                                    </div>
                                    <div class='infos-cliente'>
                                        <h2>Informações do Cliente</h2>
                                        <div>
                                            <p>ID: ".$cliente_id."</p>
                                            <p>Nome: ".$cliente_nome."</p>
                                            <p>Cidade: ".$cliente_cidade."</p>
                                            <p>CNPJ: ".$cliente_cnpj."</p>
                                            <p>Telefone: ".$cliente_telefone."</p>
                                        </div>
                                    </div>
                                    <div class='status'>
                                        <p>Enviado</p>
                                    </div>
                                </div>
                            ";
                        }
                    }
                }else {
                    echo"
                    <div class='buscar-cliente'>
                        <h1 class='titulos-vg'>Selecione um pedido</h1>
                        <form action='' method='POST' autocomplete='off'>
                            <input type='text' name='result_busca' placeholder='Busque por ID ou nome do cliente...'>
                            <input type='submit' name='btn_buscar_cliente' value='Buscar'>
                        </form>
                    </div>
                    <div class='lista-pedidos'>";
                    
                    if(isset($_POST["btn_buscar_cliente"])) {
                        $busca = $_POST['result_busca'];

                        if(!empty($busca)) {

                            $sql = "SELECT pedido_id, SUM(pd_quantidade * produto_valor) AS 'valor_total', COUNT(pd_pedido_id) AS 'quant_produtos', pedido_data, cliente_id, cliente_nome, 
                            cliente_cidade, cliente_cnpj, cliente_telefone FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id INNER JOIN pedido_produtos PD 
                            ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PD.pd_produto_id = PR.produto_id WHERE P.pedido_usuario_id = '$id_logado' AND P.pedido_id LIKE '%$busca%' OR C.cliente_nome LIKE '%$busca%' AND P.pedido_status = 1 GROUP BY pedido_id";
                            $resultado = mysqli_query($conectar, $sql);
                            
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $pedido_id = $registro['pedido_id'];
                                $pedido_data = $registro['pedido_data'];
                                $pedido_valor = $registro['valor_total'];
                                $quant_produtos = $registro['quant_produtos'];
                                $cliente_id = $registro['cliente_id'];
                                $cliente_nome = $registro['cliente_nome'];
                                $cliente_cidade = $registro['cliente_cidade'];
                                $cliente_cnpj = $registro['cliente_cnpj'];
                                $cliente_telefone = $registro['cliente_telefone'];

                                echo "<div class='pedido-enviado'>
                                    <div class='infos-pedido'>
                                        <h2>Informações do Pedido</h2>
                                        <div>
                                            <p>ID: ".$pedido_id."</p>
                                            <p>Valor: ".$pedido_valor."</p>
                                            <p>Data: ".$pedido_data."</p>
                                            <p>Quant. Produtos: ".$quant_produtos."</p>
                                        </div>
                                    </div>
                                    <div class='infos-cliente'>
                                        <h2>Informações do Cliente</h2>
                                        <div>
                                            <p>ID: ".$cliente_id."</p>
                                            <p>Nome: ".$cliente_nome."</p>
                                            <p>Cidade: ".$cliente_cidade."</p>
                                            <p>CNPJ: ".$cliente_cnpj."</p>
                                            <p>Telefone: ".$cliente_telefone."</p>
                                        </div>
                                    </div>
                                    <div class='status'>
                                        <p>Enviado</p>
                                    </div>
                                </div>
                                ";
                            }
                        }else {

                            $sql = "SELECT pedido_id, SUM(pd_quantidade * produto_valor) AS 'valor_total', COUNT(pd_pedido_id) AS 'quant_produtos', pedido_data, cliente_id, cliente_nome, 
                            cliente_cidade, cliente_cnpj, cliente_telefone FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id INNER JOIN pedido_produtos PD 
                            ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PD.pd_produto_id = PR.produto_id WHERE P.pedido_usuario_id = '$id_logado' AND  P.pedido_status = 1 GROUP BY pedido_id";
                            $resultado = mysqli_query($conectar, $sql);
                            
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $pedido_id = $registro['pedido_id'];
                                $pedido_data = $registro['pedido_data'];
                                $pedido_valor = $registro['valor_total'];
                                $quant_produtos = $registro['quant_produtos'];
                                $cliente_id = $registro['cliente_id'];
                                $cliente_nome = $registro['cliente_nome'];
                                $cliente_cidade = $registro['cliente_cidade'];
                                $cliente_cnpj = $registro['cliente_cnpj'];
                                $cliente_telefone = $registro['cliente_telefone'];

                                echo "
                                <div class='pedido-enviado'>
                                    <div class='infos-pedido'>
                                        <h2>Informações do Pedido</h2>
                                        <div>
                                            <p>ID: ".$pedido_id."</p>
                                            <p>Valor: ".$pedido_valor."</p>
                                            <p>Data: ".$pedido_data."</p>
                                            <p>Quant. Produtos: ".$quant_produtos."</p>
                                        </div>
                                    </div>
                                    <div class='infos-cliente'>
                                        <h2>Informações do Cliente</h2>
                                        <div>
                                            <p>ID: ".$cliente_id."</p>
                                            <p>Nome: ".$cliente_nome."</p>
                                            <p>Cidade: ".$cliente_cidade."</p>
                                            <p>CNPJ: ".$cliente_cnpj."</p>
                                            <p>Telefone: ".$cliente_telefone."</p>
                                        </div>
                                    </div>
                                    <div class='status'>
                                        <p>Enviado</p>
                                    </div>
                                </div>
                                ";
                            }
                        }
                    }else {

                        $sql = "SELECT pedido_id, SUM(pd_quantidade * produto_valor) AS 'valor_total', COUNT(pd_pedido_id) AS 'quant_produtos', pedido_data, cliente_id, cliente_nome, 
                        cliente_cidade, cliente_cnpj, cliente_telefone FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id INNER JOIN pedido_produtos PD 
                        ON P.pedido_id = PD.pd_pedido_id INNER JOIN produto PR ON PD.pd_produto_id = PR.produto_id WHERE P.pedido_usuario_id = '$id_logado' AND P.pedido_status = 1 GROUP BY pedido_id";
                        $resultado = mysqli_query($conectar, $sql);
                            
                            while ($registro = mysqli_fetch_array($resultado)) {
                                $pedido_id = $registro['pedido_id'];
                                $pedido_data = $registro['pedido_data'];
                                $pedido_valor = $registro['valor_total'];
                                $quant_produtos = $registro['quant_produtos'];
                                $cliente_id = $registro['cliente_id'];
                                $cliente_nome = $registro['cliente_nome'];
                                $cliente_cidade = $registro['cliente_cidade'];
                                $cliente_cnpj = $registro['cliente_cnpj'];
                                $cliente_telefone = $registro['cliente_telefone'];

                                echo "
                                <div class='pedido-enviado'>
                                    <div class='infos-pedido'>
                                        <h2>Informações do Pedido</h2>
                                        <div>
                                            <p>ID: ".$pedido_id."</p>
                                            <p>Valor: ".$pedido_valor."</p>
                                            <p>Data: ".$pedido_data."</p>
                                            <p>Quant. Produtos: ".$quant_produtos."</p>
                                        </div>
                                    </div>
                                    <div class='infos-cliente'>
                                        <h2>Informações do Cliente</h2>
                                        <div>
                                            <p>ID: ".$cliente_id."</p>
                                            <p>Nome: ".$cliente_nome."</p>
                                            <p>Cidade: ".$cliente_cidade."</p>
                                            <p>CNPJ: ".$cliente_cnpj."</p>
                                            <p>Telefone: ".$cliente_telefone."</p>
                                        </div>
                                    </div>
                                    <div class='status'>
                                        <p>Enviado</p>
                                    </div>
                                </div>
                            ";
                        }
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