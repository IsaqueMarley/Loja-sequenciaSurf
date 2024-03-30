<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ESTILOS -->
  <link rel="stylesheet" href="assets/css/styles.css">
  <!-- FONT-AWESOME -->
  <script src="https://kit.fontawesome.com/65f22fe718.js" crossorigin="anonymous"></script>
  <!-- SCRIPTS -->
  <script src="assets/js/index/pg-inicial.js" defer></script>
  <title>SEQUENCIA</title>
</head>

<body>
  <!-- BARRA DE NAVEGAÇÃO -->
  <nav class="navbar">
    <div class="logo">
      <a href="index.php" id="logo">
        <img src="assets/img/logo-sequencia.png" alt="LOGO SEQUENCIA" id="logo">
      </a>
    </div>
    <ul class="navbar-menu">
      <li><a href="/acesso_produtos/login.php">LOGIN</a></li>
      <li><a href="produtos.php">PRODUTOS</a></li>
      <li><a href="tab-mares/index.html">MARÉS</a></li>
      <li id="contatos"><a href="#">CONTATOS</a></li>
      <li><a href="carrinho.php"><img src="assets/img/icone-carrinho.png" alt="Carrinho" id="carrinho"></a></li>
    </ul>

    <!-- BOTÃO PARA ABRIR MENU LATERAL -->
    <div class="carrinho-container">
      <a href="carrinho.php"><img src="assets/img/icone-carrinho.png" alt="Carrinho"></a>
    </div>
    <button class="menu-toggle" aria-label="menu-toggle">
      <span class="menu-icon" id="menuIcon">&#9776;</span>
      <span class="close-icon" id="closeIcon">&#10006;</span>
    </button>
  </nav>

  <!-- BARRA DE NAVEGAÇÃO RESPONSIVA - MENU LATERAL -->
  <div class="sidebar" id="sidebar">
    <div class="img-sidebar">
      <a href="index.php">
        <img src="assets/img/logo-sequencia.png" alt="Logo Sequência">
      </a>
    </div>
    <ul class="sidebar-menu">
      <li><a href="/acesso_produtos/login.php">LOGIN</a></li>
      <li><a href="produtos.php">PRODUTOS</a></li>
      <li><a href="tab-mares/index.html">MARÉS</a></li>
      <li id="contatos-resp"><a href="#">CONTATOS</a></li>
    </ul>
  </div>

  <!-- BANNER PRINCIPAL -->
  <section class="banner">
    <!-- BANNER NO INDEX -->
    <picture>
      <!-- IMAGEM PARA DESKTOP -->
      <source media="(min-width: 768px)" srcset="/assets/img/banner-surf.jpg">

      <!-- IMAGEM PARA DISPOSITIVOS MÓVEIS -->
      <img src="/assets/img/banner-surf-responsive.jpg" alt="Imagem de fundo" class="background-image" loading="eager">
    </picture>

    <div class="texto">
      <h1 class="titulo">Surf é a nossa Praia</h1>
      <h2 class="sub_titulo">Conheça nossos Produtos</h2>
      <svg id="seta-baixo" width="120" height="120" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="m7 13 5 5 5-5"></path>
        <path d="m7 6 5 5 5-5"></path>
      </svg>
    </div>
  </section>

  <!-- PRODUTOS EM DESTAQUE -->
  <!-- CARDS DOS PRODUTOS -->
  <section id="produtos">
    <h2 class="titulo-produtos">PRODUTOS</h2>

    <div class="produtos">

      <?php
      include_once('config.php');

      $query = "SELECT * FROM produtos ORDER BY idprodutos DESC LIMIT 6";
      $resultado = $conexao->query($query);

      if ($resultado) {

        //  $produto = $resultado->fetch(PDO::FETCH_OBJ);

        foreach ($resultado as $produto_) {
          $produto_ = (object) $produto_;

          $conexao = null;
      ?>

          <div class="produto">
            <img class="pegar_imagem_produto" src="uploads/<?= $produto_->imagem ?>" alt="<?= $produto_->descricao ?>">
            <h2 class="pegar_titulo_produto"><?= $produto_->titulo ?></h2>
            <p class="pegar_descricao_produto" style="display: none;"><?= $produto_->descricao ?></p>
            <p class="pegar_preco_produto" style="display: none;"><?= 'R$ ' . $produto_->preco ?></p>
            <button class="ver-mais">VER MAIS</button>
          </div>

      <?php

        }
      }
      ?>

    </div>

   <!-- MOLDE PARA O MENU SUSPENSO -->
   <div class="modal">
      <div class="modal-content">
        <span class="close-button">&times;</span>
        <div class="img-product-container">
          <img class="img-product" id="modal-product-image" src="" />
        </div>
        <div class="info-product-container">
          <div class="container-title">
            <h1>TÍTULO DO PRODUTO</h1>
            <h2 class="name-product" id="modal-product-name"></h2>
          </div>
          <div class="container-description">
            <h1>DESCRIÇÃO DO PRODUTO</h1>
            <p class="desc-product" id="modal-product-description"></p>
          </div>
          <div class="price-container">
            <h1>PREÇO:</h1>
            <p class="price-product" id="modal-product-price"></p>
          </div>
          <button onclick="closeWhenAddProdToCart()" class="add-carrinho">Adicionar ao Carrinho <span class="cart-icon"></span></button>
        </div>
      </div>
    </div>

    <p id="mensagem" style="display: none;">Nenhum produto relacionado encontrado.</p>
  </section>

  <button id="mostrar-mais"><a href="produtos.php">Mostrar Mais</a></button>

  <!-- FOOTER -->
  <footer id="footer">
    <section id="map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.578927571452!2d-37.059107021088415!3d-10.995121461235685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x71ab12fb7780363%3A0x5f792d8a48cdc2d1!2sSequ%C3%AAncia%20Surf%20Shop!5e0!3m2!1spt-BR!2sbr!4v1698175318643!5m2!1spt-BR!2sbr" width="450" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <div class="vertical-line"></div>

    <section class="info">
      <section>
        <h3>Endereço</h3>
        <p>R. Niceu Dantas, 918 - Atalaia,<br />
          Aracaju - SE, 49037-470</p>
      </section>
      <section>
        <h3>Telefone</h3>
        <p>(79) 99824-8796</p>
      </section>
      <section>
        <h3>Email</h3>
        <p>info@untitled.tld</p>
      </section>
      <section>
        <h3>Redes Sociais</h3>
        <ul class="icons">
          <li><a href="https://wa.me/+5579998248796?text=Olá, gostaria de mais informações dos produtos da loja!" target="_blank"><img src="assets/img/icons-whats.png" alt="Ícone Whatsapp"></a></li>
          <li><a href="https://instagram.com/sequenciasurfclub/" target="_blank"><img src="assets/img/icone-insta.png" alt="Ícone Instagram"></a></li>
        </ul>
      </section>
    </section>
  </footer>

</body>

</html>