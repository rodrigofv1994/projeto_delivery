<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar pedido</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<h2>Lanchonete</h2>
<h2>Preenca os dados para iniciar o pedido</h2>
    <form action="cadastrarUsuario.php" method="post">
        <input type="text" name="nome" id="nome" placeholder="Digite seu nome completo" required>
        <input type="text" name="endereco" id="endereco" placeholder="Digite seu endereço completo" required> 
        <input type="text" name="celular" id="celular" placeholder="Digite seu celular" required> 
        <button>Iniciar pedido</button>
    </form>
    
</body>
</html>