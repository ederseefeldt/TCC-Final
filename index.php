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
    <script src="calendario.js"></script>
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
                    <li id='li-visao-geral' class='active'><i class='fa-solid fa-house'></i><a href='index.php'>Visão Geral</a></li>
                    <li id='li-produtos'><i class='fa-solid fa-bag-shopping'></i><a href='produtos.php'>Produtos</a></li>
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
                    <li id='li-visao-geral' class='active'><i class='fa-solid fa-house'></i><a href='index.php'>Visão Geral</a></li>
                    <li id='li-produtos'><i class='fa-solid fa-bag-shopping'></i><a href='produtos.php'>Produtos</a></li>
                    <li id='li-visao-geral'><i class='fa-solid fa-cart-shopping'></i><a href='pedidos.php'>Pedidos</a></li>
                    <li id='li-relatorios'><i class='fa-solid fa-arrow-right-from-bracket'></i><a href='logout.php'>Sair</a></li>
                </ul>
            </nav>
            <footer><h1>Desenvolvido por <span>Eder Seefeldt</span></h1></footer>
        </header>";
    }
    ?>
        <section>
            <div class="visao-geral">
                <div class="anotacoes">
                    <div class="titulos-vg"><i class="fa-solid fa-note-sticky"></i>Anotações</div>
                    
                    <ul class="quadro-anotacoes">
                        <?php
                        $sql = "SELECT * FROM anotacao WHERE anotacao_usuario_id = '$id_logado'";
                        $resultado = mysqli_query($conectar, $sql);

                        while($registro = mysqli_fetch_array($resultado)) {
                            $id = $registro['anotacao_id'];
                            $titulo = $registro['anotacao_titulo'];
                            $texto = $registro['anotacao_texto'];

                            echo '<li class="anotacao">';
                                echo '<div class="nota">';
                                    echo "<h1>$titulo</h1>";
                                    echo "<p>$texto</p>";
                                echo '</div>';
                                echo '<div class="del-edit-anotacao">';
                                    echo '<a href="removeranotacao.php?id='.$id.'"><i class="fa-solid fa-trash"></i></a>';
                                echo '</div>';
                            echo '</li>'; 
                        }
                        ?>
                    </ul>

                    <div class="crud-anotacoes">
                        <button onclick="abrirFecharNovaAnotacao()" id="teste" class="c-anotacao"></i>Nova Anotação</button>
                    </div>

                    <div id="nova-anotacao" class="nova-anotacao">
                        <div class="titulos-vg"><i class="fa-solid fa-notes-medical"></i>Nova Anotação</div>

                        <form class="form-anotacao" action="code.php" method="POST">
                            <input type="hidden" name="vendedor_id" value="<?php echo $id_logado ?>">
                            <div>Título<input type="text" name="titulo" autocomplete="off" required></div>
                            <div>Anotação<textarea name="texto" autocomplete="off" required></textarea></div>

                            <input class="btn-submit-anotacao" name="btn_salvar_anotacao" type="submit" value="Salvar">
                            <input class="btn-reset-anotacao" type="reset" value="Excluir">
                        </form>
                    </div>

                    <div class="ver-anotacao">
                        
                    </div>
                </div>
                <div class="acesso-rapido">
                    <div class="titulos-vg"><i class="fa-solid fa-bars"></i>Acesso Rápido</div>

                    <ul class="btns-acesso-rapido">
                        <li><a href="pedidos.php"><i class="fa-solid fa-cart-plus"></i>Fazer Pedido</a></li>
                        <li><a href="pedidosafinalizar.php"><i class="fa-solid fa-circle-xmark"></i>Pedidos não finalizados</a></li></li>
                        <li><a href="enviopendente.php"><i class="fa-solid fa-file-arrow-up"></i>Envio Pendente</a></li></li>
                        <li><a href="pedidosenviados.php"><i class="fa-solid fa-check"></i>Pedidos Enviados</a></li></li>
                    </ul>
                </div>

                <div class="calendario">
                    <div class="titulos-vg"><i class="fa-solid fa-calendar-days"></i>Calendário</div>
                    <div id="mes" class="mes">Novembro</div>
                    <table border="1">
                        <thead>
                            <th>DOM</th>
                            <th>SEG</th>
                            <th>TER</th>
                            <th>QUA</th>
                            <th>QUI</th>
                            <th>SEX</th>
                            <th>SAB</th>
                        </thead>
                        <tbody id="dias">
                            <tr>
                                <td class="mes-anterior">30</td>
                                <td class="mes-anterior">31</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>7</td>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                            </tr><tr>
                                <td>13</td>
                                <td>14</td>
                                <td>15</td>
                                <td>16</td>
                                <td>17</td>
                                <td>18</td>
                                <td>19</td>
                            </tr><tr>
                                <td>20</td>
                                <td>21</td>
                                <td>22</td>
                                <td>23</td>
                                <td class="dia-atual">24</td>
                                <td>25</td>
                                <td>26</td>
                            </tr><tr>
                                <td>27</td>
                                <td>28</td>
                                <td>29</td>
                                <td>30</td>
                                <td class="mes-seguinte">1</td>
                                <td class="mes-seguinte">2</td>
                                <td class="mes-seguinte">3</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php
                if ($status == 1) {  
                    echo"
                    <div class='faturamento'>
                        <div class='titulos-vg'><i class='fa-solid fa-chart-line'></i></i>Estatísticas</div>
                        <form action='' method='POST'>
                            <h2>Selecione o Período</h2>
                            <select name='periodos'>
                                <option value='30'>1 mês</option>
                                <option value='90'>3 meses</option>
                                <option value='365'>1 ano</option>
                            </select>
                            <input type='submit' name='btn_periodo' value='Buscar'>
                        </form>
                        <div class='estatisticas'>
                    ";
                                if(isset($_POST["btn_periodo"])) {
                                    $periodo = $_POST['periodos'];
                                    
                                    $query_valor_vendido = "SELECT SUM(pedido_valor) AS 'valor_vendido' FROM pedido WHERE pedido_status = 1 AND pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -'$periodo' DAY) AND CURRENT_DATE()";
                                    $resultado_valor_vendido = mysqli_query($conectar, $query_valor_vendido);

                                    while ($registro1 = mysqli_fetch_array($resultado_valor_vendido)) {
                                        $valor_vendido = $registro1['valor_vendido'];
                                            echo "
                                            <div class='valor-vendido'>
                                                <h2>Valor Vendido</h2>
                                                <p>R$ <span>".$valor_vendido."</span></p>
                                                <h4>Nos últimos ".$periodo." dias</h4>
                                            </div>";
                                    }

                                    $query_melhores_produtos = "SELECT produto_nome, SUM(pd_quantidade) AS 'quantidade_vendida' FROM pedido_produtos PD INNER JOIN produto PR ON PD.pd_produto_id = 
                                    PR.produto_id INNER JOIN pedido PE ON PD.pd_pedido_id = PE.pedido_id WHERE PE.pedido_status = 1 AND PE.pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), 
                                    INTERVAL -'$periodo' DAY) AND CURRENT_DATE() GROUP BY PD.pd_produto_id ORDER BY quantidade_vendida DESC LIMIT 5";
                                    $resultado_melhores_produtos = mysqli_query($conectar, $query_melhores_produtos);

                                        echo"
                                        <div class='melhores-produtos'>
                                            <h2>Produtos Mais Vendidos</h2>
                                            <table border='2'>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Quantidade</th>
                                                </tr>
                                        ";

                                        while ($registro2 = mysqli_fetch_array($resultado_melhores_produtos)) {
                                            $produto_nome = $registro2['produto_nome'];
                                            $quantidade_vendida = $registro2['quantidade_vendida'];

                                            echo"
                                            <tr>
                                                <td>".$produto_nome."</td>
                                                <td>".$quantidade_vendida."</td>
                                            </tr>
                                            ";
                                        }
                                        echo"
                                                </table>
                                            </div>
                                        ";
                                        $query_melhores_clientes = "SELECT cliente_nome, SUM(pedido_valor) AS 'valor_comprado' FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id 
                                        WHERE pedido_status = 1 AND pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -'$periodo' DAY) AND CURRENT_DATE() GROUP BY pedido_cliente_id ORDER BY `valor_comprado` DESC LIMIT 5";
                                        $resultado_melhores_clientes = mysqli_query($conectar, $query_melhores_clientes);

                                        echo"
                                            <div class='melhores-clientes'>
                                                <h2>Melhores Clientes</h2>
                                                <table border='2'>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>V. Comprado</th>
                                                    </tr>
                                        ";

                                        while ($registro3 = mysqli_fetch_array($resultado_melhores_clientes)) {
                                            $cliente_nome = $registro3['cliente_nome'];
                                            $valor_comprado = $registro3['valor_comprado'];

                                            echo"
                                                <tr>
                                                    <td>".$cliente_nome."</td>
                                                    <td>".$valor_comprado."</td>
                                                </tr>
                                            ";
                                        }
                                        echo"
                                                </table>
                                            </div>
                                        ";
                                }else {
                                    $query_valor_vendido = "SELECT SUM(pedido_valor) AS 'valor_vendido' FROM pedido WHERE pedido_status = 1 AND pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE()";
                                    $resultado_valor_vendido = mysqli_query($conectar, $query_valor_vendido);

                                    while ($registro1 = mysqli_fetch_array($resultado_valor_vendido)) {
                                        $valor_vendido = $registro1['valor_vendido'];
                                            echo "
                                            <div class='valor-vendido'>
                                                <h2>Valor Vendido</h2>
                                                <p>R$ <span>".$valor_vendido."</span></p>
                                                <h4>Nos últimos 30 dias</h4>
                                            </div>";
                                    }

                                    $query_melhores_produtos = "SELECT produto_nome, SUM(pd_quantidade) AS 'quantidade_vendida' FROM pedido_produtos PD INNER JOIN produto PR ON PD.pd_produto_id = 
                                    PR.produto_id INNER JOIN pedido PE ON PD.pd_pedido_id = PE.pedido_id WHERE PE.pedido_status = 1 AND PE.pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), 
                                    INTERVAL -30 DAY) AND CURRENT_DATE() GROUP BY PD.pd_produto_id ORDER BY quantidade_vendida DESC LIMIT 5";
                                    $resultado_melhores_produtos = mysqli_query($conectar, $query_melhores_produtos);

                                    echo"
                                        <div class='melhores-produtos'>
                                            <h2>Produtos Mais Vendidos</h2>
                                            <table border='2'>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Quantidade</th>
                                                </tr>
                                        ";

                                    while ($registro2 = mysqli_fetch_array($resultado_melhores_produtos)) {
                                        $produto_nome = $registro2['produto_nome'];
                                        $quantidade_vendida = $registro2['quantidade_vendida'];

                                        echo"
                                            <tr>
                                                <td>".$produto_nome."</td>
                                                <td>".$quantidade_vendida."</td>
                                            </tr>
                                        ";
                                    }
                                    echo"
                                            </table>
                                        </div>
                                    ";
                                    $query_melhores_clientes = "SELECT cliente_nome, SUM(pedido_valor) AS 'valor_comprado' FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id 
                                    WHERE pedido_status = 1 AND pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE() GROUP BY pedido_cliente_id ORDER BY `valor_comprado` DESC LIMIT 5";
                                    $resultado_melhores_clientes = mysqli_query($conectar, $query_melhores_clientes);

                                        echo"
                                            <div class='melhores-clientes'>
                                                <h2>Melhores Clientes</h2>
                                                <table border='2'>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>V. Comprado</th>
                                                    </tr>
                                        ";

                                    while ($registro3 = mysqli_fetch_array($resultado_melhores_clientes)) {
                                        $cliente_nome = $registro3['cliente_nome'];
                                        $valor_comprado = $registro3['valor_comprado'];

                                        echo"
                                            <tr>
                                                <td>".$cliente_nome."</td>
                                                <td>".$valor_comprado."</td>
                                            </tr>
                                        ";
                                    }
                                    echo"
                                                </table>
                                            </div>
                                    ";
                                }
                }else {
                    echo"
                    <div class='faturamento'>
                        <div class='titulos-vg'><i class='fa-solid fa-chart-line'></i></i>Estatísticas</div>
                        <form action='' method='POST'>
                            <h2>Selecione o Período</h2>
                            <select name='periodos'>
                                <option value='30'>1 mês</option>
                                <option value='90'>3 meses</option>
                                <option value='365'>1 ano</option>
                            </select>
                            <input type='submit' name='btn_periodo' value='Buscar'>
                        </form>
                        <div class='estatisticas'>
                    ";
                                if(isset($_POST["btn_periodo"])) {
                                    $periodo = $_POST['periodos'];
                                    
                                    $query_valor_vendido = "SELECT SUM(pedido_valor) AS 'valor_vendido' FROM pedido WHERE pedido_status = 1 AND pedido_usuario_id = '$id_logado' AND pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -'$periodo' DAY) AND CURRENT_DATE()";
                                    $resultado_valor_vendido = mysqli_query($conectar, $query_valor_vendido);

                                    while ($registro1 = mysqli_fetch_array($resultado_valor_vendido)) {
                                        $valor_vendido = $registro1['valor_vendido'];
                                            echo "
                                            <div class='valor-vendido'>
                                                <h2>Valor Vendido</h2>
                                                <p>R$ <span>".$valor_vendido."</span></p>
                                                <h4>Nos últimos ".$periodo." dias</h4>
                                            </div>";
                                    }

                                    $query_melhores_produtos = "SELECT produto_nome, SUM(pd_quantidade) AS 'quantidade_vendida' FROM pedido_produtos PD INNER JOIN produto PR ON PD.pd_produto_id = 
                                    PR.produto_id INNER JOIN pedido PE ON PD.pd_pedido_id = PE.pedido_id WHERE PE.pedido_status = 1 AND pedido_usuario_id = '$id_logado' AND PE.pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), 
                                    INTERVAL -'$periodo' DAY) AND CURRENT_DATE() GROUP BY PD.pd_produto_id ORDER BY quantidade_vendida DESC LIMIT 5";
                                    $resultado_melhores_produtos = mysqli_query($conectar, $query_melhores_produtos);

                                        echo"
                                        <div class='melhores-produtos'>
                                            <h2>Produtos Mais Vendidos</h2>
                                            <table border='2'>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Quantidade</th>
                                                </tr>
                                        ";

                                        while ($registro2 = mysqli_fetch_array($resultado_melhores_produtos)) {
                                            $produto_nome = $registro2['produto_nome'];
                                            $quantidade_vendida = $registro2['quantidade_vendida'];

                                            echo"
                                            <tr>
                                                <td>".$produto_nome."</td>
                                                <td>".$quantidade_vendida."</td>
                                            </tr>
                                            ";
                                        }
                                        echo"
                                                </table>
                                            </div>
                                        ";
                                        $query_melhores_clientes = "SELECT cliente_nome, SUM(pedido_valor) AS 'valor_comprado' FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id 
                                        WHERE pedido_status = 1 AND pedido_usuario_id = '$id_logado' AND pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -'$periodo' DAY) AND CURRENT_DATE() GROUP BY pedido_cliente_id ORDER BY `valor_comprado` DESC LIMIT 5";
                                        $resultado_melhores_clientes = mysqli_query($conectar, $query_melhores_clientes);

                                        echo"
                                            <div class='melhores-clientes'>
                                                <h2>Melhores Clientes</h2>
                                                <table border='2'>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>V. Comprado</th>
                                                    </tr>
                                        ";

                                        while ($registro3 = mysqli_fetch_array($resultado_melhores_clientes)) {
                                            $cliente_nome = $registro3['cliente_nome'];
                                            $valor_comprado = $registro3['valor_comprado'];

                                            echo"
                                                <tr>
                                                    <td>".$cliente_nome."</td>
                                                    <td>".$valor_comprado."</td>
                                                </tr>
                                            ";
                                        }
                                        echo"
                                                </table>
                                            </div>
                                        ";
                                }else {
                                    $query_valor_vendido = "SELECT SUM(pedido_valor) AS 'valor_vendido' FROM pedido WHERE pedido_status = 1 AND pedido_usuario_id = '$id_logado' AND pedido_data 
                                    BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE()";
                                    $resultado_valor_vendido = mysqli_query($conectar, $query_valor_vendido);

                                    while ($registro1 = mysqli_fetch_array($resultado_valor_vendido)) {
                                        $valor_vendido = $registro1['valor_vendido'];
                                            echo "
                                            <div class='valor-vendido'>
                                                <h2>Valor Vendido</h2>
                                                <p>R$ <span>".$valor_vendido."</span></p>
                                                <h4>Nos últimos 30 dias</h4>
                                            </div>";
                                    }

                                    $query_melhores_produtos = "SELECT produto_nome, SUM(pd_quantidade) AS 'quantidade_vendida' FROM pedido_produtos PD INNER JOIN produto PR ON PD.pd_produto_id = 
                                    PR.produto_id INNER JOIN pedido PE ON PD.pd_pedido_id = PE.pedido_id WHERE PE.pedido_status = 1 AND pedido_usuario_id = '$id_logado' AND PE.pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), 
                                    INTERVAL -30 DAY) AND CURRENT_DATE() GROUP BY PD.pd_produto_id ORDER BY quantidade_vendida DESC LIMIT 5";
                                    $resultado_melhores_produtos = mysqli_query($conectar, $query_melhores_produtos);

                                    echo"
                                        <div class='melhores-produtos'>
                                            <h2>Produtos Mais Vendidos</h2>
                                            <table border='2'>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Quantidade</th>
                                                </tr>
                                        ";

                                    while ($registro2 = mysqli_fetch_array($resultado_melhores_produtos)) {
                                        $produto_nome = $registro2['produto_nome'];
                                        $quantidade_vendida = $registro2['quantidade_vendida'];

                                        echo"
                                            <tr>
                                                <td>".$produto_nome."</td>
                                                <td>".$quantidade_vendida."</td>
                                            </tr>
                                        ";
                                    }
                                    echo"
                                            </table>
                                        </div>
                                    ";
                                    $query_melhores_clientes = "SELECT cliente_nome, SUM(pedido_valor) AS 'valor_comprado' FROM pedido P INNER JOIN cliente C ON P.pedido_cliente_id = C.cliente_id 
                                    WHERE pedido_status = 1 AND pedido_usuario_id = '$id_logado' AND pedido_data BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE() GROUP BY pedido_cliente_id ORDER BY `valor_comprado` DESC LIMIT 5";
                                    $resultado_melhores_clientes = mysqli_query($conectar, $query_melhores_clientes);

                                        echo"
                                            <div class='melhores-clientes'>
                                                <h2>Melhores Clientes</h2>
                                                <table border='2'>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>V. Comprado</th>
                                                    </tr>
                                        ";

                                    while ($registro3 = mysqli_fetch_array($resultado_melhores_clientes)) {
                                        $cliente_nome = $registro3['cliente_nome'];
                                        $valor_comprado = $registro3['valor_comprado'];

                                        echo"
                                            <tr>
                                                <td>".$cliente_nome."</td>
                                                <td>".$valor_comprado."</td>
                                            </tr>
                                        ";
                                    }
                                    echo"
                                                </table>
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