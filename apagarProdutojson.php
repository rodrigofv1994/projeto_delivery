<?php

$arquivo = file_get_contents('produtos.json');

$objetoProdutos = json_decode($arquivo,true);

$indice = 0;

$tamanho = sizeof($objetoProdutos);


for($indice;$indice<=$tamanho;$indice++)
{
    echo " Objeto do array   "   . $objetoProdutos[$indice]['id'];
    echo " post recebido   "   . $_POST['id'];
            
    if($objetoProdutos[$indice]['id']===$_POST['id'])
    {             
        unset($objetoProdutos[$indice]);    

        $dados_json = json_encode($objetoProdutos,JSON_PRETTY_PRINT);
    
        $arquivoProdutos = fopen('produtos.json','w');
        
        fwrite($arquivoProdutos,$dados_json);
        
        fclose($arquivoProdutos);
        break;
    }     
    
}


?>