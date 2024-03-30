<?php

require_once('conexao.php'); // Inclui o arquivo de conexão

try {
    $conexao = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// VALIDAR E FILTRAR OS DADOS PARA EVITAR INJEÇÃO DE SQL
var_dump($_POST);

// OBTER OS DADOS DO POST
$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : ''; 
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];
$descricao = $_POST['descricao'];

// VERIFICA SE OS DADOS DO POST FORAM ENVIADOS CORRETAMENTE
if (!$titulo || !$preco || !$quantidade || !$descricao) {
    die("Dados do formulário incompletos. Dados recebidos: " . json_encode($_POST));
}

// PROCESSAR A IMAGEM
$imnname = null;  // Inicializa a variável $imnname como null

if (!empty($_FILES['up_imagem']['tmp_name'])) {
    // Se uma nova imagem foi enviada, realize o processamento
    $tmp_name = $_FILES['up_imagem']['tmp_name'];
    $imnname = $_FILES['up_imagem']['name'];
    $dir = '../uploads/';

    // VERIFICAÇÃO PARA GARANTIR QUE O ARQUIVO ENVIADO SEJA UMA IMAGEM VÁLIDA
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
    $fileExtension = strtolower(pathinfo($imnname, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        die('Erro: Por favor, envie apenas arquivos de imagem válidos (jpg, jpeg, png, gif, bmp, webp, svg).');
    }

    // VERIFICAR SE O DIRETÓRIO UPLOADS EXISTE, CASO NÃO, CRIAR ELE
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    // MOVER O ARQUIVO PARA O DIRETÓRIO UPLOADS
    move_uploaded_file($tmp_name, $dir . $imnname);
}

// ADAPTAÇÃO PARA INSERIR NOVO PRODUTO
$stmt = $conexao->prepare("INSERT INTO produtos (imagem, titulo, preco, quantidade, descricao) VALUES (:imagem, :titulo, :preco, :quantidade, :descricao)");
$stmt->bindParam(':imagem', $imnname, PDO::PARAM_STR);  // Altera para PDO::PARAM_STR
$stmt->bindParam(':titulo', $titulo);
$stmt->bindParam(':preco', $preco);
$stmt->bindParam(':quantidade', $quantidade);
$stmt->bindParam(':descricao', $descricao);

try {
    $stmt->execute();
    echo "Novo produto adicionado com sucesso";
} catch (PDOException $e) {
    // TRATAR ERROS DE EXECUÇÃO DA CONSULTA
    echo "Erro ao adicionar novo produto: " . $e->getMessage();
}

?>
