<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$id = $_GET['id'];

$sql = "SELECT * FROM usuario where usuario_id = '$id'";
$resultado = mysqli_query($conectar, $sql);
$row_usuario = mysqli_fetch_assoc($resultado);

$_SESSION['nome_logado'];
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
            <div id="teste3" class="tela-cadastro-1" style="display: flex;">
                <div class="header-lista-1">
                    <div class="titulos-vg"><i class="fa-solid fa-note-sticky"></i>Atualizar Vendedor</div>
                    <a href="vendedores.php" class="btn-back">Voltar</a>
                </div>

                <form action="code.php" method="post" class="form-crud-vendedor" autocomplete="off">
                    <div class="inputs">
                        <input type="hidden" name="vendedor_id" value="<?php echo $row_usuario['usuario_id']?>">
                        <div class="input"><span>Nome</span><input type="text" name="vendedor_nome" value="<?php echo $row_usuario['usuario_nome']?>" required></div>
                        <div class="input"><span>Sobrenome</span><input type="text" name="vendedor_sobrenome" value="<?php echo $row_usuario['usuario_sobrenome']?>" required></div>
                        <div class="input"><span>CPF</span><input type="text" name="vendedor_cpf" value="<?php echo $row_usuario['usuario_cpf']?>" required></div>
                        <div class="input"><span>Email</span><input type="email" name="vendedor_email" value="<?php echo $row_usuario['usuario_email']?>" required></div>
                        <div class="input"><span>Telefone</span><input type="text" name="vendedor_telefone" value="<?php echo $row_usuario['usuario_telefone']?>" required></div>
                    </div>

                    <div class="btns-cadastro-vendedor">
                        <input class="list-btn-edit" type="submit" name="btn_atualizar_vendedor" value="Atualizar">
                    </div>
                </form>
            </div>
        </div>    
    </section>

    <script src="script.js"></script>
</body>
</html>