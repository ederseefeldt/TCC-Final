<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$_SESSION['nome_logado'];
$id = $_SESSION['id_logado'];

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
    <header>
        <div class="login">
            <h1>Bem-vindo, <span><?php echo $_SESSION['nome_logado']; ?></span>!</h1>
        </div>
        <nav>
            <ul>
                <li id="li-visao-geral"><i class="fa-solid fa-house"></i><a href="index.php">Visão Geral</a></li>
                <li id="li-produtos"><i class="fa-solid fa-bag-shopping"></i><a href="produtos.php">Produtos</a></li>
                <li id="li-visao-geral"><i class="fa-solid fa-cart-shopping"></i><a href="pedidos.php">Pedidos</a></li>
                <li id="li-clientes" class="active"><i class="fa-solid fa-person-arrow-down-to-line"></i></i></i><a href="clientes.php">Clientes</a></li>
                <li id="li-vendedores"><i class="fa-solid fa-person-arrow-up-from-line"></i><a href="vendedores.php">Vendedores</a></li>
                <li id="li-relatorios"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
        <footer><h1>Desenvolvido por <span>Eder Seefeldt</span></h1></footer>
    </header>

    <section class="section-clientes">
        <div class="display-1">
            <div class="header-lista-1">
                <div class="titulos-vg"><i class="fa-solid fa-note-sticky"></i>Lista de Clientes</div>
                <form action="" method="POST" autocomplete="off">
                    <input type="text" name="result_busca" placeholder="Busque por ID, nome ou CNPJ...">
                    <input type="submit" name="btn_buscar" value="Buscar">
                </form>
                <button class="btn-add" onclick="abrirCadastroCliente()">Novo Cliente</button>
            </div>
            
            <div class="lista-1">
                <table border="1">
                    <tr class="header-row">
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    if (isset($_POST["btn_buscar"])) {
                        $busca = $_POST['result_busca'];
    
                        if (!empty($busca)) {
                            $sql = "SELECT * FROM cliente WHERE cliente_id LIKE '%$busca%' OR cliente_nome LIKE '%$busca%' OR cliente_cnpj LIKE '%$busca%'";
                            $resultado = mysqli_query($conectar, $sql);

                            while($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['cliente_id'];
                                $nome = $registro['cliente_nome'];
                                $cnpj = $registro['cliente_cnpj'];
                                $email = $registro['cliente_email'];
                                $telefone = $registro['cliente_telefone'];
                                    
                                    echo"<tr class='body-row'>
                                        <td>".$id."</td>
                                        <td>".$nome."</td>
                                        <td>".$cnpj."</td>
                                        <td>".$email."</td>
                                        <td>".$telefone."</td>
                                        <td class='actions'>
                                            <a class='list-btn-edit' href='editarcliente.php?id=".$id."'>Editar</a>
                                            <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_cliente' value=".$id.">Remover</button></form>
                                        </td>
                                    </tr>";
                            }
                        }else {
                            $sql = "SELECT * FROM cliente";
                            $resultado = mysqli_query($conectar, $sql);

                            while($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['cliente_id'];
                                $nome = $registro['cliente_nome'];
                                $cnpj = $registro['cliente_cnpj'];
                                $email = $registro['cliente_email'];
                                $telefone = $registro['cliente_telefone'];
                                    
                                    echo"<tr class='body-row'>
                                        <td>".$id."</td>
                                        <td>".$nome."</td>
                                        <td>".$cnpj."</td>
                                        <td>".$email."</td>
                                        <td>".$telefone."</td>
                                        <td class='actions'>
                                            <a class='list-btn-edit' href='editarcliente.php?id=".$id."'>Editar</a>
                                            <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_cliente' value=".$id.">Remover</button></form>
                                        </td>
                                    </tr>";
                            }
                        }
                    }else {
                        $sql = "SELECT * FROM cliente";
                        $resultado = mysqli_query($conectar, $sql);

                        while($registro = mysqli_fetch_array($resultado)) {
                            $id = $registro['cliente_id'];
                            $nome = $registro['cliente_nome'];
                            $cnpj = $registro['cliente_cnpj'];
                            $email = $registro['cliente_email'];
                            $telefone = $registro['cliente_telefone'];
                                
                                echo"<tr class='body-row'>
                                    <td>".$id."</td>
                                    <td>".$nome."</td>
                                    <td>".$cnpj."</td>
                                    <td>".$email."</td>
                                    <td>".$telefone."</td>
                                    <td class='actions'>
                                        <a class='list-btn-edit' href='editarcliente.php?id=".$id."'>Editar</a>
                                        <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_cliente' value=".$id.">Remover</button></form>
                                    </td>
                                </tr>";
                        }
                    }
                        mysqli_close($conectar);
                    ?>
                </table>
            </div>

            <div id="teste4" class="tela-cadastro-1">
                <div class="header-lista-1">
                    <div class="titulos-vg"><i class="fa-solid fa-note-sticky"></i>Cadastrar Cliente</div>
                    <button onclick="fecharCadastroCliente()" class="btn-back">Voltar</button>
                </div>

                <form action="code.php" method="post" class="form-crud-cliente" autocomplete="off">
                    <div class="inputs">
                        <div class="input"><span>Nome</span><input type="text" name="cliente_nome" required></div>
                        <div class="input"><span>Email</span><input type="email" name="cliente_email" required></div>
                        <div class="input"><span>CNPJ</span><input type="number" name="cliente_cnpj" required></div>
                        <div class="input"><span>Telefone</span><input type="number" name="cliente_telefone" required></div>
                        <div class="input"><span>Inscrição Estadual</span><input type="number" name="cliente_inscricaoestadual" required></div>
                        <div class="input"><span>Rua</span><input type="text" name="cliente_rua" required></div>
                        <div class="input"><span>Bairro</span><input type="text" name="cliente_bairro" required></div>
                        <div class="input"><span>CEP</span><input type="number" name="cliente_cep" required></div>
                        <div class="input"><span>Cidade</span><input type="text" name="cliente_cidade" required></div>
                        <div class="input"><span>Número</span><input type="number" name="cliente_numero" required></div>
                        <input type="hidden" name="cliente_uf" value="RS">
                    </div>

                    <div class="btns-cadastro-vendedor">
                        <input class="list-btn-delete" type="reset" value="Apagar">
                        <input class="list-btn-edit" name="btn_cadastrar_cliente" type="submit" value="Cadastrar">
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>