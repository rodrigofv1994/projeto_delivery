<?php

header('Content-Type: application/json'); 

$formatos = array("png", "jpg", "gif", "jpeg"); //Cria um array com extensões permitidas
$extensaoDoArquivo = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION)); //pega a extensão do arquivo sem o ponto
if (in_array($extensaoDoArquivo, $formatos))
{//se o arquivo possui extensão válida
    $pasta = "imagens/"; //Tem que criar dentro da pasta raíz do sistema uma pasta chamada imagens e dentro da imagens, criar fotos-perfil
    $nomeTemp = $_FILES['imagem']['tmp_name']; //pega o nome temporário que o php dá pro arquivo
    $novoNome = uniqid() . ".$extensaoDoArquivo"; //Cria um novo nome para o arquivo concatenando com a extensão com o ponto

    $diretorio = $pasta;
    if (!is_dir($diretorio))
    {
        mkdir($diretorio, 0777, true);
        chmod($diretorio, 0777);
    }
    $upload = move_uploaded_file($nomeTemp, $pasta . $novoNome); //Faz upload do arquivo e envia pro endereço
    $imagem = "https://devrodrigo.com/lanchonete_netbeans/" . $pasta . $novoNome; //gera o link de recuperação da imagem
    //está cadastrando com as barras invertidas.
}

$novoProduto = array(
    'id' => uniqid(),
    'nome' => $_POST["nome"],
    'preco' => $_POST["preco"],
    'tipoProduto' => $_POST["tipoProduto"],
    'imagem' => $imagem
);


$arquivo = file_get_contents('produtos.json');

$array = json_decode($arquivo,true);

$array = empty($array) ? [] : $array;

array_push($array,$novoProduto);

$dados_json = json_encode($array,JSON_PRETTY_PRINT);

$arquivoProdutos = fopen('produtos.json','w');

fwrite($arquivoProdutos,$dados_json);

fclose($arquivoProdutos);

header("location: cadastrarProduto.php");

?>