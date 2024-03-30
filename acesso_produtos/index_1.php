<?php
// Defina o tempo máximo de inatividade da sessão (em segundos)
ini_set('session.gc_maxlifetime', 3600); // 1 hora

// Defina a duração do cookie de sessão (em segundos)
ini_set('session.cookie_lifetime', 3600); // 1 hora

// Inclua a verificação de autenticação no início
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Inclua a conexão com o banco de dados
require_once('conexao.php');

// carregar os dados (em formato de array de objetos)
$resultados = $conexao->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_OBJ);

// fechar a ligação
$ligacao = null;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACESSO PRODUTOS</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Adicione isso ao início do seu arquivo HTML, antes de incluir o bdprodutos.js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- BIBLIOTECA CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-....." crossorigin="anonymous" />
    <!-- <link rel="stylesheet" href="../assets/css/bdprodutos.css"> -->
    <script src="../assets/js/bdprodutos/bdprodutos.js" defer></script>
</head>

<body>

    <?php
    // Verifique se o usuário está autenticado antes de exibir o conteúdo
    if (isset($_SESSION['usuario_id'])) {
    ?>

        <!-- BARRA DE NAVEGAÇÃO -->
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php" id="logo">
                    <img src="../assets/img/logo-sequencia.png" alt="LOGO SEQUENCIA" id="logo">
                </a>
            </div>

            <form class="logout-form" method="post" action="logout.php">
                <input type="submit" value="Logout">
            </form>
        </nav>


        <!-- ESTOQUE -->
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h3>PRODUTOS:</h3>
                    <button onclick="exibirModalNovoProduto()">Novo Produto</button>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>ID Produto</th>
                                <th>Imagem</th>
                                <th>Título</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Descrição</th>
                                <th>Editar/Apagar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $produto_) : ?>
                                <tr data-id-produto="<?= isset($produto_->idProduto) ? htmlspecialchars($produto_->idProduto) : '' ?>">
                                    <!-- Adicionando um atributo data em cada célula -->
                                    <td class="pegar_id_produto"><?= $produto_->idprodutos ?></td>
                                    <td class="pegar_imagem_produto"><?= $produto_->imagem ?></td>
                                    <td class="pegar_titulo_produto"><?= $produto_->titulo ?></td>
                                    <td class="pegar_preco_produto"><?= $produto_->preco ?></td>
                                    <td class="pegar_quantidade_produto"><?= $produto_->quantidade ?></td>
                                    <td class="pegar_descricao_produto"><?= $produto_->descricao ?></td>
                                    <td class="acao-editar-remover">
                                        <img src="../assets/img/edit.png" class="imagem-editar" width="40px" onclick="editarProduto(event)">
                                        <i class="fas fa-trash acao-icon" onclick="removerProduto(<?php echo $produto_->idprodutos; ?>)"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- MODAL DE CONFIRMAÇÃO PARA REMOVER O PRODUTO -->
                    <div id="modalConfirmacao" class="modal">
                        <div class="modal-content" id="modalConfirm">
                            <p>Você tem certeza de que deseja remover este produto?</p>
                            <div class="botoes-confirm">
                                <button id="btnRemover" onclick="confirmarRemocao()">Remover</button>
                                <button onclick="fecharModalConfirmacao()">Cancelar</button>
                            </div>

                            <!-- Adicione um campo oculto para armazenar o idProduto -->
                            <input type="hidden" id="modalConfirmacaoIdProduto">
                        </div>
                    </div>

                    <!-- MODAL SUSPENSO PARA EDIÇÃO DO PRODUTO -->
                    <div id="modalEditar" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="fecharModal()">&times;</span>

                            <div class="modal-input">
                                <label for="nova_imagem">Imagem:</label>
                                <input type="file" id="nova_imagem" name="nova_imagem" accept="image/*">
                            </div>

                            <div class="modal-input">
                                <label>Título:</label>
                                <input type="text" id="editTitulo">
                            </div>

                            <div class="modal-input">
                                <label>Preço:</label>
                                <input type="text" id="editPreco">
                            </div>

                            <div class="modal-input">
                                <label>Quantidade:</label>
                                <input type="text" id="editQuantidade">
                            </div>

                            <div class="modal-input">
                                <label>Descrição:</label>
                                <textarea id="editDescricao"></textarea>
                            </div>

                            <div class="modal-buttons">
                                <button onclick="salvarEdicao()">Salvar</button>
                                <button onclick="fecharModal()">Cancelar</button>
                            </div>

                            <input type="hidden" id="editIdProduto">
                            <div id="mensagemAtualizacao" style="color: green; margin-top: 10px;"></div>
                        </div>
                    </div>

                    <!-- MODAL SUSPENSO PARA ADIÇÃO DE NOVO PRODUTO -->
                    <div id="modalNovoProduto" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="fecharModalNovoProduto()">&times;</span>

                            <div class="modal-input">
                                <label for="up_imagem">Imagem:</label>
                                <input type="file" id="up_imagem" name="up_imagem" accept="image/*">
                            </div>

                            <div class="modal-input">
                                <label>Título:</label>
                                <input type="text" id="novoTitulo">
                            </div>

                            <div class="modal-input">
                                <label>Preço:</label>
                                <input type="text" id="novoPreco">
                            </div>

                            <div class="modal-input">
                                <label>Quantidade:</label>
                                <input type="text" id="novoQuantidade">
                            </div>

                            <div class="modal-input">
                                <label>Descrição:</label>
                                <textarea id="novoDescricao"></textarea>
                            </div>

                            <div class="modal-buttons">
                                <button onclick="salvarNovoProduto()">Salvar</button>
                                <button onclick="fecharModalNovoProduto()">Cancelar</button>
                            </div>
                        </div>
                    </div>


                    <p class="mt-3">Total: <strong><?= count($resultados) ?></strong></p>

                </div>
            </div>
        </div>

    <?php
    } else {
        // Se o usuário não estiver autenticado, redirecione para a página de login
        header("Location: login.php");
        exit();
    }
    ?>

</body>

</html>