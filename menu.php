<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width"  initial-scale=1.0">
    <title>Menu - Administração</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <style>

    </style>
</head>
<body> 
    
    <?php
       
    if($_POST['usuario']!=="admin" || $_POST['senha']!=="admin"){
        header("location: loginAdm.php");
    }
    
    ?>
    <section class="menu">
        <h2>Menu administrador</h2>
        <a href="cadastrarProduto.php" class="a"><i class="far fa-plus-square"></i>&nbsp&nbspCadastrar novo produto</a>
        <a href="apagarProduto.php" class="a"><i class="far fa-trash-alt"></i>&nbsp&nbspApagar produto</a>   
        <a href="fazerPedido.php" class="a"><i class="fas fa-utensils"></i>&nbsp&nbspFazer pedido</a>   
    </section>
</body>
</html>