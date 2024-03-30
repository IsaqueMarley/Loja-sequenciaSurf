<?php

require_once('conexao.php'); // Inclui o arquivo de conexão

try {
    $conexao = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// OBTER O ID DO PRODUTO
$idProduto = $_POST['idProduto'];

/* IMAGEM */
// VERIFICAR SE UMA NOVA IMAGEM FOI ENVIADA
if (!empty($_FILES['nova_imagem']['tmp_name'])) {
    // OBTER O NOME DA IMAGEM ATUAL NO BANCO DE DADOS
    $stmt = $conexao->prepare("SELECT imagem FROM produtos WHERE idprodutos = :idProduto");
    $stmt->bindParam(':idProduto', $idProduto);
    $stmt->execute();
    $imagemAntiga = $stmt->fetchColumn();

    // SE HOUVER UMA IMAGEM ANTERIOR, EXCLUA-A
    if (!empty($imagemAntiga) && file_exists('../uploads/' . $imagemAntiga)) {
        unlink('../uploads/' . $imagemAntiga);
    }

    // PROCESSAR A NOVA IMAGEM DA MESMA FORMA QUE NO FORMULÁRIO DE CADASTRO
    $tmp_name = $_FILES['nova_imagem']['tmp_name'];
    $imnname = $_FILES['nova_imagem']['name'];
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

    // ATUALIZAR O CAMINHO DA IMAGEM NO BANCO DE DADOS
    $stmt = $conexao->prepare("UPDATE produtos SET imagem = :imagem WHERE idprodutos = :idProduto");
    $stmt->bindParam(':imagem', $imnname);
    $stmt->bindParam(':idProduto', $idProduto);
    $stmt->execute();
}

// VALIDAR E FILTRAR OS DADOS PARA EVITAR INJEÇÃO DE SQL
var_dump($_POST);

// OBTER OS DADOS DO POST
$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : ''; 
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];
$descricao = $_POST['descricao'];

// VERIFICA SE OS DADOS DO POST FORAM ENVIADOS CORRETAMENTE
if (!$idProduto || !$titulo || !$preco || !$quantidade || !$descricao) {
    die("Dados do formulário incompletos. Dados recebidos: " . json_encode($_POST));
}

// INICIALIZAR UM ARRAY PARA ARMAZENAR AS COLUNAS E VALORES A SEREM ATUALIZADOS
$atualizacoes = array();

// ADICIONAR CADA CAMPO DO FORMULÁRIO AO ARRAY DE ATUALIZAÇÕES, CASO ESTEJA PRESENTE
if ($titulo !== '') {
    $atualizacoes[] = "titulo = :titulo";
}

if ($preco !== '') {
    $atualizacoes[] = "preco = :preco";
}

if ($quantidade !== '') {
    $atualizacoes[] = "quantidade = :quantidade";
}

if ($descricao !== '') {
    $atualizacoes[] = "descricao = :descricao";
}

// MONTAR A STRING SQL USANDO AS COLUNAS A SEREM ATUALIZADAS
$sql = "UPDATE produtos SET " . implode(", ", $atualizacoes) . " WHERE idprodutos = :idProduto";

$stmt = $conexao->prepare($sql);

// ADICIONAR OS PARÂMETROS AOS CAMPOS DO FORMULÁRIO, CASO ESTEJAM PRESENTES
if ($titulo !== '') {
    $stmt->bindParam(':titulo', $titulo);
}

if ($preco !== '') {
    $stmt->bindParam(':preco', $preco);
}

if ($quantidade !== '') {
    $stmt->bindParam(':quantidade', $quantidade);
}

if ($descricao !== '') {
    $stmt->bindParam(':descricao', $descricao);
}

$stmt->bindParam(':idProduto', $idProduto);

try {
    $stmt->execute();
    echo "Dados atualizados com sucesso";
} catch (PDOException $e) {
    // TRATAR ERROS DE EXECUÇÃO DA CONSULTA
    echo "Erro ao atualizar dados: " . $e->getMessage();
}

?>
