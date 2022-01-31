<?php

    session_start();
    $_SESSION["nome"] = $_POST['nome'];
    $_SESSION["endereco"] = $_POST['endereco'];
    $_SESSION["celular"] = $_POST['celular'];
    $_SESSION["logado"] = true;    
    
    header("location: fazerPedido.php"); 
    
    ?>


