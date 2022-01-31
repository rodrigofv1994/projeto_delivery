<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Apagar produto</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <section class="containerProdutosAdm">
            <h2>Apagar produtos</h2>
            <p>Para apagar basta selecionar produto e confirmar.</p>
            <?php
            session_start();

            $_SESSION["logadoAdm"] = true;

            if (!$_SESSION["logadoAdm"]) {
                header("location: fazerLoginAdm.php");
            }

            $arquivo = file_get_contents('produtos.json');

            $arquivo = json_decode($arquivo);

            if (empty($arquivo)) {
                echo "Sem produtos cadastrados" . "</br>";
            } else {
                $id = 0;
                foreach ($arquivo as $registro) {
                    $id++;
                    $nomeid = "inputNumber";
                    $inputCheckbox = "inputCheckbox";
                    echo "<section class='sectionProduto'>";
                    echo "<input type='checkbox' name='$registro->nome' id=$registro->id value=$registro->preco  onchange='apagarProduto(this.id,this)'>";
                    echo "<img src=$registro->imagem alt=$registro->nome class='fotoProduto' onclick='zoom(this)'>";
                    echo "<span class='nomeProduto'>$registro->nome </br> $registro->preco</span>";
                    echo "</section>";
                }
            }
            ?>        

        </section>

        <script language="javascript">
            var form = new FormData();
            var httpRequest;
            function apagarProduto(idProduto,checkbox)
            {
                var desejaApagar = confirm("Deseja realmente apagar?");
                if(desejaApagar)
                {
                    console.log("Javascript passando:" + idProduto);
                if (window.XMLHttpRequest)
                {
                    httpRequest = new XMLHttpRequest();
                }

                httpRequest.onreadystatechange = function ()
                {
                    if (httpRequest.readyState == 1)
                    {
                        console.log("Requisição será feita em segundos");
                    }

                    if (httpRequest.readyState == 4)
                    {
                        console.log("Requisição foi feita e foi entregue.");
                        if (httpRequest.status == 200)
                        {
                            console.log(httpRequest.responseText);
                            location.reload();
                        }
                    }
                }

                httpRequest.open('POST', 'apagarProdutojson.php', true);
                form.append("id", idProduto);
                httpRequest.send(form);
                    
                }
                else
                {
                    checkbox.checked = false;
                }
                
            }
        </script>

    </body>
</html>