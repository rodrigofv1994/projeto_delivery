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
    <form action="menu.php" method="post">
        <input type="text" name="usuario" id="usuario" placeholder="Digite seu nome de usuário administrador" required>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha de administrador" required>         
        <button>Entrar</button>
    </form>
    
</body>
</html>