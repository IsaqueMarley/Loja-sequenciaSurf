<?php
require_once('conexao.php');

// Obtém o ID do produto a ser removido da requisição POST
$idProduto = isset($_POST['idProduto']) ? $_POST['idProduto'] : '';

// Validação básica do ID do produto
if (empty($idProduto) || !is_numeric($idProduto)) {
    die(json_encode(['error' => 'ID de produto inválido.']));
}

try {
    $conexao = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Busca a imagem do produto antes de removê-lo
    $stmtImagem = $conexao->prepare("SELECT imagem FROM produtos WHERE idprodutos = :idProduto");
    $stmtImagem->bindParam(':idProduto', $idProduto);
    $stmtImagem->execute();
    $imagemProduto = $stmtImagem->fetchColumn();

    // Lógica para remover o produto do banco de dados
    $stmtRemover = $conexao->prepare("DELETE FROM produtos WHERE idprodutos = :idProduto");
    $stmtRemover->bindParam(':idProduto', $idProduto);
    $stmtRemover->execute();

    // Caminho completo para a imagem
    $caminhoImagem = __DIR__ . '/../uploads/' . $imagemProduto;

    // Verifica se o arquivo da imagem existe antes de tentar excluí-lo
    if (file_exists($caminhoImagem)) {
        // Exclui o arquivo da imagem
        if (unlink($caminhoImagem)) {
            echo json_encode(['success' => 'Produto removido com sucesso.']);
        } else {
            echo json_encode(['error' => 'Erro ao excluir o arquivo de imagem.']);
        }
    } else {
        echo json_encode(['success' => 'Produto removido com sucesso.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao remover produto: ' . $e->getMessage()]);
}
?>
