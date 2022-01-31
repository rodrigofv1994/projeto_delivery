<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar produto</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h2>Cadastrar produto</h2>
    <form  action="cadastrarProdutojson.php" method="post" name="formCadastraProduto" id="frmCadastroProduto" enctype="multipart/form-data">
    <input type="text" name="nome" id="nome" placeholder="Nome do produto">
    <input type="number" name="preco" id="preco" placeholder="Preço do produto" class="inputPrecoProduto">
    <select name="tipoProduto" id="tipoProduto">
        <option value="refrigerante">Refrigerante</option>
        <option value="suco">Suco</option>
        <option value="hamburguer">Hamburguer</option>
        <option value="salgado">Salgado</option>
        <option value="pizza">Pizza</option>
        <option value="combo">Combo</option>
        <option value="doce">Doce</option>
        <option value="Batata-frita">Batata frita</option>
        
    </select>
    <a href="#" onclick="imagem.click()" class="buttonEscolherImagem">Escolher imagem</a></br>
    <input type="file" name="imagem" id="imagem" style="display:none">
    <button>Cadastrar produto</button>
    </form>  
</body>
</html>