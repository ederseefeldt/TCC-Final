<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$_SESSION['nome_logado'];
$_SESSION['id_logado'];

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
                <li id="li-clientes"><i class="fa-solid fa-person-arrow-down-to-line"></i></i></i><a href="clientes.php">Clientes</a></li>
                <li id="li-vendedores" class="active"><i class="fa-solid fa-person-arrow-up-from-line"></i><a href="vendedores.php">Vendedores</a></li>
                <li id="li-relatorios"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
        <footer><h1>Desenvolvido por <span>Eder Seefeldt</span></h1></footer>
    </header>

    <section class="section-vendedores">
        <div class="display-1">
            <div class="header-lista-1">
                <div class="titulos-vg"><i class="fa-solid fa-note-sticky"></i>Lista de Vendedores</div>
                <form action="" method="POST" autocomplete="off">
                    <input type="text" name="result_busca" placeholder="Busque por ID, nome ou CPF...">
                    <input type="submit" name="btn_buscar" value="Buscar">
                </form>
                <button class="btn-add" onclick="abrirCadastro()">Novo Vendedor</button>
            </div>

            <div class="lista-1">
                <table border="1">
                    <tr class="header-row">
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    if (isset($_POST["btn_buscar"])) {
                        $busca = $_POST['result_busca'];
    
                        if (!empty($busca)) {
                            $sql = "SELECT * FROM usuario WHERE usuario_id LIKE '%$busca%' OR usuario_nome LIKE '%$busca%' OR usuario_cpf LIKE '%$busca%' AND usuario_status = 0";
                            $resultado = mysqli_query($conectar, $sql);

                            while($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['usuario_id'];
                                $nome = $registro['usuario_nome'];
                                $sobrenome = $registro['usuario_sobrenome'];
                                $cpf = $registro['usuario_cpf'];
                                $email = $registro['usuario_email'];
                                $telefone = $registro['usuario_telefone'];

                                    echo"<tr class='body-row'>
                                        <td>".$id."</td>
                                        <td>".$nome." ".$sobrenome."</td>
                                        <td>".$cpf."</td>
                                        <td>".$email."</td>
                                        <td>".$telefone."</td>
                                        <td class='actions'>
                                            <a class='list-btn-edit' href='editarvendedor.php?id=".$id."'>Editar</a>
                                            <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_vendedor' value=".$id.">Remover</button></form>
                                        </td>
                                    </tr>";
                            }
                        }else {
                            $sql = "SELECT * FROM usuario WHERE usuario_status = 0";
                            $resultado = mysqli_query($conectar, $sql);

                            while($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['usuario_id'];
                                $nome = $registro['usuario_nome'];
                                $sobrenome = $registro['usuario_sobrenome'];
                                $cpf = $registro['usuario_cpf'];
                                $email = $registro['usuario_email'];
                                $telefone = $registro['usuario_telefone'];

                                    echo"<tr class='body-row'>
                                        <td>".$id."</td>
                                        <td>".$nome." ".$sobrenome."</td>
                                        <td>".$cpf."</td>
                                        <td>".$email."</td>
                                        <td>".$telefone."</td>
                                        <td class='actions'>
                                            <a class='list-btn-edit' href='editarvendedor.php?id=".$id."'>Editar</a>
                                            <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_vendedor' value=".$id.">Remover</button></form>
                                        </td>
                                    </tr>";
                            }
                        }
                    }else {
                        $sql = "SELECT * FROM usuario WHERE usuario_status = 0";
                            $resultado = mysqli_query($conectar, $sql);

                            while($registro = mysqli_fetch_array($resultado)) {
                                $id = $registro['usuario_id'];
                                $nome = $registro['usuario_nome'];
                                $sobrenome = $registro['usuario_sobrenome'];
                                $cpf = $registro['usuario_cpf'];
                                $email = $registro['usuario_email'];
                                $telefone = $registro['usuario_telefone'];

                                    echo"<tr class='body-row'>
                                        <td>".$id."</td>
                                        <td>".$nome." ".$sobrenome."</td>
                                        <td>".$cpf."</td>
                                        <td>".$email."</td>
                                        <td>".$telefone."</td>
                                        <td class='actions'>
                                            <a class='list-btn-edit' href='editarvendedor.php?id=".$id."'>Editar</a>
                                            <form action='code.php' method='POST'><button class='list-btn-delete' name='btn_remover_vendedor' value=".$id.">Remover</button></form>
                                        </td>
                                    </tr>";
                            }
                }
                        mysqli_close($conectar);
                    ?>
                </table>
            </div>

            <div id="teste3" class="tela-cadastro-1">
                <div class="header-lista-1">
                    <div class="titulos-vg"><i class="fa-solid fa-note-sticky"></i>Cadastrar Vendedor</div>
                    <button onclick="fecharCadastro()" class="btn-back">Voltar</button>
                </div>

                <form action="code.php" method="post" class="form-crud-vendedor" autocomplete="off">
                    <div class="inputs">
                        <div class="input"><span>Nome</span><input type="text" name="vendedor_nome" required></div>
                        <div class="input"><span>Sobrenome</span><input type="text" name="vendedor_sobrenome" required></div>
                        <div class="input"><span>CPF</span><input type="text" name="vendedor_cpf" required></div>
                        <div class="input"><span>Email</span><input type="email" name="vendedor_email" required></div>
                        <div class="input"><span>Telefone</span><input type="text" name="vendedor_telefone" required></div>
                    </div>
                    

                    <div class="btns-cadastro-vendedor">
                        <input class="list-btn-delete" type="reset" value="Apagar">
                        <input class="list-btn-edit" name="btn_cadastrar_vendedor" type="submit" value="Cadastrar">
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>