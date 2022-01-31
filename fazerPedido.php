<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu pedido</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

    <?php
    session_start();

    if(!$_SESSION["logado"])
    {
        header("location: inicio.php");
    }

    $arquivo = file_get_contents('produtos.json');
    
    $arquivo = json_decode($arquivo);
   
    ?>
    <section id="divZoom" class="divZoom" style="display:none">
    <button onclick="fecharImagem()" class="buttonFecharImagem" id="buttonFecharImagem">Fechar</button>
    </section>
    <a href="http://api.whatsapp.com/send?1=pt_BR&phone=5521964841834&text=Quero%20ter%20o%20app%20de%20delivery.">Obtenha o seu app aqui.</a>
    <h1>Lanchonete</h1>
    <?php
         
    echo "<span id='nomeCliente'>". $_SESSION['nome']. "</span>";
    echo "</br>";
    echo "<span id='endereco'>".$_SESSION['endereco']."</span>";
    echo "</br>";
    echo "<span id='celular'>".$_SESSION['celular']."</span>";

    ?>
    <a href="finalizarSessao.php">Trocar dados</a>
    <h2>Cardápio</h2>

    <?php

    if(empty($arquivo))
    {
        echo "Sem produtos cadastrados" . "</br>";
    }
    else
    {
        $id = 0;
        foreach($arquivo as $registro){
            $id++;
            $nomeid ="inputNumber"; 
            $inputCheckbox = "inputCheckbox";       
            echo "<section class='sectionProduto'>";
            echo "<input type='checkbox' name='".str_replace(" ","%20",$registro->nome)."' id=$inputCheckbox$id value=$registro->preco onchange='adicionarPedido(this.name,this.value,this,$nomeid$id)'>";
            echo "<img src=$registro->imagem alt=$registro->nome class='fotoProduto' onclick='zoom(this)'>";
            echo "<span class='nomeProduto'>$registro->nome </br>".str_replace('.',',', $registro->preco)."</span>";
            echo "<input type='number' name='quantidade' min='0' value='0' onchange=atualizarCarrinho($inputCheckbox$id) class='inputNumber' datanome=$registro->nome datavalor=$registro->preco id=$nomeid$id>";
            echo "</section>";
        }
    }
    ?> 

    <section class="carrinho">
        Carrinho: <span id="qtdItens"></span></br>       
        Total a pagar: <span id="totalItens"></span><br/>
        <span id="trocoPraQuanto">Troco pra quanto?</span><input type="number" name="troco" id="troco" placeholder="R$" class="inputNumberCarrinho" value="0" min="0">
    </section>


    <input type="radio" name="formaPagamento" id="dinheiro" value="dinheiro"> Dinheiro 
    <input type="radio" name="formaPagamento" id="credito" value="credito"> Crédito 
    <input type="radio" name="formaPagamento" id="debito" value="debito"> Débito </br>
    <button onclick="fazerPedido()">Fazer pedido</button>

    

    <script language="javascript">

        var pedido = [];  
        var endereco = document.getElementById("endereco").innerText;
        var nome = document.getElementById("nomeCliente").innerText;  
        var celular = document.getElementById("celular").innerText;        

        document.getElementById("debito").addEventListener("click",function(){
            document.getElementById("trocoPraQuanto").style.display="none";
            document.getElementById("troco").style.display="none";
            document.getElementById("troco").value = 0;
        });

        document.getElementById("credito").addEventListener("click",function(){
            document.getElementById("trocoPraQuanto").style.display="none";
            document.getElementById("troco").style.display="none";
            document.getElementById("troco").value = 0;
        });

        document.getElementById("dinheiro").addEventListener("click",function(){
            document.getElementById("trocoPraQuanto").style.display="inline-block";
            document.getElementById("troco").style.display="inline-block";
        });
        
        function formatarMoeda(valor)
        {
            return valor.toLocaleString('pt-br',
            {
                style: 'currency', 
                currency: 'BRL\n\ '
            });
        }
            

        function adicionarPedido(nomeProduto,valorProduto,checkbox,inputNumber)
        {

            if(checkbox.checked)
            {

                if(inputNumber.value==0)
                {
                    alert("Selecione a quantidade antes de marcar o produto.");
                    checkbox.checked = false;
                    
                }
                else
                {   
                    valorProduto = parseFloat(valorProduto);
                    var produto =
                    {
                        'nome': nomeProduto,
                        'valor': valorProduto,
                        'quantidade': inputNumber.value,
                        'valorTotalProduto': inputNumber.value * valorProduto
                    }
                    
                    pedido.push(produto);

                    console.log("Itens no carrinho---------------------");
                    var valorTotalPedido = 0;
                    var valorTotalItens = 0;
                    pedido.forEach(function(item)
                    { 
                        valorTotalItens += parseFloat(item.quantidade);  
                        valorTotalPedido += item.valorTotalProduto;
                        console.log(item.nome + " " + item.valor + " qtd:" + item.quantidade + " Total = " + item.valorTotalProduto);
                                           
                    });
                    console.log("Total do pedido = " + valorTotalPedido);
                    document.getElementById("qtdItens").innerText =  valorTotalItens + " produtos";
                    document.getElementById("totalItens").innerText = formatarMoeda(valorTotalPedido) ;
                }             

            }
            else
            {  
                pedido.forEach(function(nome,indice) {
                    if(nome.nome==nomeProduto)
                    {                        
                        pedido.splice(indice,1);
                    }
                })
                
                var valorTotalPedido = 0;
                var valorTotalItens = 0;
                pedido.forEach(function(item)
                { 
                    valorTotalItens += parseFloat(item.quantidade);    
                    valorTotalPedido += item.valorTotalProduto;
                    console.log(item.nome + " " + item.valor + " qtd:" + item.quantidade + " Total = " + item.valorTotalProduto);
                                           
                });
                console.log("Total do pedido = " + valorTotalPedido);
                document.getElementById("qtdItens").innerText = valorTotalItens + " produtos";
                document.getElementById("totalItens").innerText =  formatarMoeda(valorTotalPedido);
            }   
        }

        function atualizarCarrinho(checkbox)
        {
            if(checkbox.checked)
            {
                alert("Para atualizar o carrinho desmarque e marque o produto novamente.");  
            }                        
          
        }

        function fazerPedido()
        {
            var dinheiro = document.getElementById("dinheiro");
            var debito = document.getElementById("debito");
            var credito = document.getElementById("credito");
            var valorPago = parseFloat(document.getElementById("troco").value);
            var valorTotalPedido = 0;
            var valorTotalItens = 0;                     
            pedido.forEach(function(item)
            { 
                valorTotalItens += parseFloat(item.quantidade);    
                valorTotalPedido += item.valorTotalProduto;
                console.log(item.nome + " " + item.valor + " qtd:" + item.quantidade + " Total = " + item.valorTotalProduto);
                                                    
            });
            if(dinheiro.checked)
            {                 

                if(valorPago<0 || valorPago < valorTotalPedido)
                {
                    alert("Valor pago não pode ser menor que o valor total do pedido.");
                    var inputTroco = document.getElementById("troco");
                    inputTroco.classList.add("inputNumberCarrinho2");
                    inputTroco.focus();
                }
                else
                {
                    var valorTotalPedido = 0;
                    var valorTotalItens = 0; 
                    var itensPedidoText = "";                  
                    pedido.forEach(function(item)
                    { 
                         valorTotalItens += parseFloat(item.quantidade);    
                        valorTotalPedido += item.valorTotalProduto;
                        itensPedidoText += "\n"+ item.nome + "%20Valor:" +  formatarMoeda(item.valor) + "%20qtd:" + item.quantidade + "%20Total%20=%20" +  formatarMoeda(item.valorTotalProduto)+"%20";
                        console.log(item.nome + " Valor:" + item.valor + " qtd:" + item.quantidade + " Total = " + item.valorTotalProduto);
                                
                                                        
                    });                        

                    if(valorPago ==="" || valorPago === 0 || valorPago ==="0")
                    {
                                troco = 0;
                    }
                    else
                    {
                        troco = valorPago - valorTotalPedido;                                
                    }

                    if(valorPago == 0)
                    {
                        valorPago = valorTotalPedido;
                    }

                    var resumoPedido = "Pedido%20realizado%20no%20dinheiro.%20Total%20do%20pedido:%20" +  formatarMoeda(valorTotalPedido) + "%20Valor%20a%20pagar%20de:%20" +  formatarMoeda(valorPago) + "%20Troco deste pedido sera de:%20" +  formatarMoeda(troco) + "%20Resumo do pedido:%20" + itensPedidoText;
                    window.location.href = "http://api.whatsapp.com/send?1=pt_BR&phone=5521964841834&text="+resumoPedido + "%20Endereço%20de%20entrega: %20"+endereco+"%20"+"Cliente:%20"+nome+"%20Celular:%20"+celular;
                    console.log("Total do pedido = " + valorTotalPedido);
                    document.getElementById("qtdItens").innerText = valorTotalItens + " produtos";
                    document.getElementById("totalItens").innerText =  formatarMoeda(valorTotalPedido);
                }  
            }

            if(debito.checked)
            {
                
                var valorTotalPedido = 0;
                var valorTotalItens = 0; 
                var itensPedidoText = "";                  
                pedido.forEach(function(item)
                { 
                    valorTotalItens += parseFloat(item.quantidade);    
                    valorTotalPedido += item.valorTotalProduto;
                    itensPedidoText += "%20"+ item.nome + "%20Valor:" +  formatarMoeda(item.valor) + "%20qtd:" + item.quantidade + "%20Total%20=%20" +  formatarMoeda(item.valorTotalProduto)+"%20";
                    console.log(item.nome + " Valor:" + item.valor + " qtd:" + item.quantidade + " Total = " + item.valorTotalProduto);
                });                        

                valorPago = valorTotalPedido;
                troco = 0;

                var resumoPedido = "Pedido%20realizado%20no%20débito.%20Total%20do%20pedido:%20" +  formatarMoeda(valorTotalPedido) + "%20Valor%20a%20pagar%20de:%20" +  formatarMoeda(valorPago) + "%20Troco deste pedido será de:%20" +  formatarMoeda(troco) + "%20Resumo do pedido:%20" + itensPedidoText;
                window.location.href = "http://api.whatsapp.com/send?1=pt_BR&phone=5521964841834&text="+resumoPedido + "%20Endereço%20de%20entrega: %20"+endereco+"%20"+"Cliente:%20"+nome+"%20Celular:%20"+celular;
                console.log("Total do pedido = " + valorTotalPedido);
                document.getElementById("qtdItens").innerText = valorTotalItens + " produtos";
                document.getElementById("totalItens").innerText =  formatarMoeda(valorTotalPedido); 
            }   

            if(credito.checked)
            {
                var valorTotalPedido = 0;
                var valorTotalItens = 0; 
                var itensPedidoText = "";                  
                pedido.forEach(function(item)
                { 
                    valorTotalItens += parseFloat(item.quantidade);    
                    valorTotalPedido += item.valorTotalProduto;                    
                    itensPedidoText += "%20"+ item.nome + "%20Valor:" + formatarMoeda(item.valor) + "%20qtd:" + item.quantidade + "%20Total%20=%20" +  formatarMoeda(item.valorTotalProduto)+"%20";
                    console.log(item.nome + " Valor:" +   formatarMoeda(item.valor) + " qtd:" + item.quantidade + " Total = " + formatarMoeda(item.valorTotalProduto));
                });                        

                valorPago = valorTotalPedido;
                troco = 0;

                var resumoPedido = "Pedido%20realizado%20no%20crédito.%20Total%20do%20pedido:%20" + formatarMoeda(valorTotalPedido) + "%20Valor%20a%20pagar%20de:%20" +  formatarMoeda(valorPago) + "%20Troco deste pedido sera de:%20" +  formatarMoeda(troco) + "%20Resumo do pedido:%20" + itensPedidoText;
                window.location.href = "http://api.whatsapp.com/send?1=pt_BR&phone=5521964841834&text="+resumoPedido + "%20Endereço%20de%20entrega: %20"+endereco+"%20"+"Cliente:%20"+nome+"%20Celular:%20"+celular;
                console.log("Total do pedido = " + valorTotalPedido);
                document.getElementById("qtdItens").innerText = valorTotalItens + " produtos";
                document.getElementById("totalItens").innerText =  formatarMoeda(valorTotalPedido);
                
            }   
        }  

        function zoom(elementoImagem){
            var divZoom = document.getElementById("divZoom");
            var imagem = document.createElement("img");

            divZoom.style.display="flex";
            console.log("Clicou");

            imagem.classList.add("imagemZoom");
            imagem.src= elementoImagem.src;
            imagem.id= elementoImagem.id;

            divZoom.appendChild(imagem);
        }

        function fecharImagem(){
            var buttonFecharImagem = document.getElementById("buttonFecharImagem");
            var divZoom = document.getElementById("divZoom");
            divZoom.style.display="none";
            divZoom.innerHTML = "";

            

            buttonFecharImagem.id = "buttonFecharImagem";
            buttonFecharImagem.setAttribute("onclick","fecharImagem()");
            buttonFecharImagem.classList.add("buttonFecharImagem");

            divZoom.appendChild(buttonFecharImagem);
        }
      

    </script>
</body>
</html>