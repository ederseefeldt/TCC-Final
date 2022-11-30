<?php

session_start();

include_once('conectar.php');

if(!isset($_SESSION['nome_logado'])){
    header("Location: login.html");
}

$id = $_GET['id'];

$sql = "SELECT * FROM produto where produto_id = '$id'";
$resultado = mysqli_query($conectar, $sql);
$dados_produto = mysqli_fetch_assoc($resultado);

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
                <li id="li-produtos" class="active"><i class="fa-solid fa-bag-shopping"></i><a href="produtos.php">Produtos</a></li>
                <li id="li-visao-geral"><i class="fa-solid fa-cart-shopping"></i><a href="pedidos.php">Pedidos</a></li>
                <li id="li-clientes"><i class="fa-solid fa-person-arrow-down-to-line"></i></i></i><a href="clientes.php">Clientes</a></li>
                <li id="li-vendedores"><i class="fa-solid fa-person-arrow-up-from-line"></i><a href="vendedores.php">Vendedores</a></li>
                <li id="li-relatorios"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
        <footer><h1>Desenvolvido por <span>Eder Seefeldt</span></h1></footer>
    </header>

    <section class="section-produtos">
        <div id="display-editar-produto" class="editar-produto">
            <div class="header-lista-1">
                <div class="titulos-vg"><i class="fa-solid fa-note-sticky"></i>Atualizar Produto</div>
                <a href="produtos.php" class="btn-back">Voltar</a>
            </div>

            <div class="form-cadastro-produto">
                <form action="code.php" method="POST" enctype="multipart/form-data">
                    <div class="inputs">
                        <input type="hidden" name="produto_id" value="<?php echo $dados_produto['produto_id']?>">
                        <div class="input"><span>Nome</span><input type="text" name="produto_nome" value="<?php echo $dados_produto['produto_nome']?>" placeholder="Digite o nome do produto" required></div>
                        <div class="input"><span>Valor</span><input type="number" name="produto_valor" value="<?php echo $dados_produto['produto_valor']?>" placeholder="R$" required></div>
                        <div class="input"><span>Descrição</span><input type="text" name="produto_descricao" value="<?php echo $dados_produto['produto_descricao']?>" placeholder="Informações sobre o produto" required></div>
                        <div class="input"><span>Categoria</span><input type="text" name="produto_categoria" value="<?php echo $dados_produto['produto_categoria']?>" placeholder="Escolha a categoria do produto" required></div>
                        <div class="input"><span>Fabricante</span><input type="text" name="produto_fabricante" value="<?php echo $dados_produto['produto_fabricante']?>" placeholder="Escolha o fabricante do produto" required></div>
                        <div class="input"><input class="input-imagem" type="file" name="produto_imagem"></div>
                    </div>

                    <div class="imagem-atual">
                        <h1>Imagem Atual</h1>
                        <?php echo "<img src='abrir_imagens.php?id=".$id."'/>";?>
                        <p>Você pode inserir uma nova imagem abaixo</p>
                    </div>

                    <div class="btns-forms">
                        <input class="list-btn-edit" type="submit" name="btn_atualizar_produto" value="Atualizar">
                        <input class="btn-back" type="reset" value="Excluir">
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>