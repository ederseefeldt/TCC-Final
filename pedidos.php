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
                <a style="height: 10vh; background-color: #0066db;" href="pedidos.php">Novo Pedido</a>
                <a href="pedidosafinalizar.php">Pedidos à finalizar</a>
                <a href="enviopendente.php">Envio Pendente</a>
                <a href="pedidosenviados.php">Pedidos Enviados</a>
            </div>
            <div class="body-pedidos">
                <div class="buscar-cliente">
                    <h1 class="titulos-vg">Selecione um cliente</h1>
                    <form action="" method="POST" autocomplete="off">
                        <input type="text" name="result_busca" placeholder="Busque por ID, nome ou CNPJ...">
                        <input type="submit" name="btn_buscar_cliente" value="Buscar">
                    </form>
                </div>
                <div class="lista-cliente">
                    <?php 
                    
                    if(isset($_POST["btn_buscar_cliente"])) {
                        $busca = $_POST['result_busca'];

                        $sql = "SELECT cliente_id, cliente_nome, cliente_cnpj, cliente_cidade FROM cliente WHERE cliente_id LIKE '%$busca%' OR cliente_nome LIKE '%$busca%' OR cliente_cnpj LIKE '%$busca%'";
                        $resultado = mysqli_query($conectar, $sql);
                        
                        while ($registro = mysqli_fetch_array($resultado)) {
                            $id = $registro['cliente_id'];
                            $nome = $registro['cliente_nome'];
                            $cnpj = $registro['cliente_cnpj'];
                            $cidade = $registro['cliente_cidade'];

                            echo "
                                <div class='cliente'>
                                    <div style='width: 8vw;'>
                                        <h2>ID</h2>
                                        <p>".$id."</p>
                                    </div>
                                    <div style='width: 23vw;'>
                                        <h2>Nome</h2>
                                        <p>".$nome."</p>
                                    </div>
                                    <div style='width: 20vw;'>
                                        <h2>CNPJ</h2>
                                        <p>".$cnpj."</p>
                                    </div>
                                    <div style='width: 10vw;'>
                                        <h2>Cidade</h2>
                                        <p>".$cidade."</p>
                                    </div>
                                    <div style='width: 15vw; display: flex; align-items: center;'>
                                        <form action='code.php' method='POST'>
                                            <input type='hidden' name='pedido_vendedor_id' value=".$id_logado.">
                                            <input type='hidden' name='pedido_cliente_id' value=".$id.">
                                            <input type='submit' name='btn_cadastrar_pedido' value='Iniciar Pedido'>
                                        </form>
                                    </div>
                                </div>
                            ";
                        }
                    }else {
                        $sql = "SELECT cliente_id, cliente_nome, cliente_cnpj, cliente_cidade FROM cliente";
                        $resultado = mysqli_query($conectar, $sql);
                        
                        while ($registro = mysqli_fetch_array($resultado)) {
                            $id = $registro['cliente_id'];
                            $nome = $registro['cliente_nome'];
                            $cnpj = $registro['cliente_cnpj'];
                            $cidade = $registro['cliente_cidade'];

                            echo "
                                <div class='cliente'>
                                    <div style='width: 8vw;'>
                                        <h2>ID</h2>
                                        <p>".$id."</p>
                                    </div>
                                    <div style='width: 23vw;'>
                                        <h2>Nome</h2>
                                        <p>".$nome."</p>
                                    </div>
                                    <div style='width: 20vw;'>
                                        <h2>CNPJ</h2>
                                        <p>".$cnpj."</p>
                                    </div>
                                    <div style='width: 10vw;'>
                                        <h2>Cidade</h2>
                                        <p>".$cidade."</p>
                                    </div>
                                    <div style='width: 15vw; display: flex; align-items: center;'>
                                        <form action='code.php' method='POST'>
                                            <input type='hidden' name='pedido_vendedor_id' value=".$id_logado.">
                                            <input type='hidden' name='pedido_cliente_id' value=".$id.">
                                            <input type='submit' name='btn_cadastrar_pedido' value='Iniciar Pedido'>
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