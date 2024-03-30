<?php 
    $dbHost = '2cc149d1d993d1db32fd1403265c';
    $dbUsername = 'sequencia';
    $dbPassword = 'WMefHmcbkurh97GoxR';
    $dbName = 'foSuSotxeB8WkCkGgZztG9';


    $conexao = new PDO("mysql:host=2cc149d1d993d1db32fd1403265c;dbname=$dbName",$dbUsername,$dbPassword);
    
    $estado = $conexao->getAttribute(PDO::ATTR_CONNECTION_STATUS);

    //echo $estado . "  PRODUTO CADASTRADO!";


    
?>