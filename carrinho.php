<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ESTILOS -->
  <link rel="stylesheet" href="assets/css/carrinho.css">
  <!-- SCRIPTS -->
  <script src="assets/js/carrinho/carrinho.js" defer></script>
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

 <!-- CARRINHO -->
<section class="container normal-section">
  <h2 class="section-title">CARRINHO</h2>

  <table class="cart-table">
    <thead>
      <tr>
        <th class="table-head-item first-col">Imagem</th>
        <th class="table-head-item first-col">Item</th>
        <th class="table-head-item second-col">Preço</th>
        <th class="table-head-item third-col">Quantidade</th>
        <th class="table-head-item fourth-col">Remover</th>
      </tr>
    </thead>

    <tbody class="tbody-carrinho">
      <!-- AQUI VÃO SER INSERIDOS OS PRODUTOS -->
    </tbody>

    <tfoot>
      <tr>
        <td colspan="4" class="cart-total-container">
          <strong>Total</strong>
          <span>R$0,00</span>
        </td>
      </tr>
    </tfoot>
  </table>

  <button type="button" class="purchase-button" onclick="makePurchase()">Finalizar Compra</button>
</section>

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
        <p>(79) 99824-XXXX</p>
      </section>
      <section>
        <h3>Email</h3>
        <p>info@xxuxxtled.tld</p>
      </section>
      <section>
        <h3>Redes Sociais</h3>
        <ul class="icons">
          <li><a href="https://wa.me/+5579XXXXXXXX?text=Olá, gostaria de mais informações dos produtos da loja!" target="_blank"><img src="assets/img/icons-whats.png" alt="Ícone Whatsapp"></a></li>
          <li><a href="https://instagram.com/sequenciasurfclub/" target="_blank"><img src="assets/img/icone-insta.png" alt="Ícone Instagram"></a></li>
        </ul>
      </section>
    </section>
  </footer>
</body>