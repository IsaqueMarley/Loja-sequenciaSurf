<?php

$dbHost = '2cc149d1d993d1db32fd1403265c';
$dbUsername = 'sequencia';
$dbPassword = 'WMefHmcbkurh97GoxR';
$dbName = 'foSuSotxeB8WkCkGgZztG9';


try {
    $conexao = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

?>