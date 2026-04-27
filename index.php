<?php
include "conexao.php";

// NOVO: Lógica para remover produto da seção de destaque
if (isset($_GET['remover_destaque'])) {
    $id = $_GET['remover_destaque'];
    // Ação: Define 'destaque' para 0. O produto permanece na tabela.
    $conn->query("UPDATE produtos SET destaque = 0 WHERE id = $id");

    // Redireciona para limpar o parâmetro da URL
    header("Location: index.php");
    exit();
}

// Função para buscar a URL da imagem (copiada de produtos.php)
function pegarImagemProduto($nome) {

    $imagens = [
        "Pioneer CDJ 3000" => "https://cdn11.bigcommerce.com/s-7659a/images/stencil/1280x1280/products/29482/104414/CDJ-3000-angle-hero__52825.1599758273.png?c=2",
        "Monitores Adam T7V" => "https://www.inta-audio.com/images/adam-audio-t5v-pair-with-komplete-audio-2-interface-iso-pads-leads-p12686-35096_image.jpg",
        "Interface Focusrite" => "https://barramusic.com.br/wp-content/uploads/2024/07/scarlett-2i2-top-image-2400-2400__78159.webp",
        "Mixer Pioneer DJM-900NXS2" => "https://www.pioneerdj.com/-/media/pioneerdj/images/products/mixer/djm-900nxs2/black/djm-900nxs2-main2.png",
        "Sintetizador Nord Lead 4" => "https://www.manual.com.ve/thumbs/products/l/1298366-nord-lead-4.webp",
        "Cabo P10 XLR" => "https://matchmusic.cl/wp-content/uploads/2025/01/santo-angelo-ninja-cable-microfono-xlr-a-xlr-ofhc-largo-1220-mt.png",
        "Licença Ableton Live" => "https://i.redd.it/9vuao7i2qwy51.png",
        "Controladora Pioneer XDJ-XZ" => "https://shopmundodigital.com.br/cdn/shop/files/XDJ-XZ_prm_top.png",
        "Audio-Technica ATH-M50x" => "https://alldaz.com.br/wp-content/uploads/2023/04/ath-m50x_01_1.png",
        "Microfone condensador AT2020" => "https://www.audio-technica.com/media/catalog/product/a/t/at2020_02a.png",
        "Teclado MPK Mini MK2" => "https://www.sweetspot.com.br/wp-content/uploads/2013/06/product_a_k_akai_mpkmini_mkii_main.png",
        "Mixer Behringer Xenyx 802S" => "https://cdn.sistemawbuy.com.br/arquivos/90abc409b16b6fea717168e986ba981b/produtos/67b379f55db90/15245493700-behringer-802s-67b37a67178fd.png"
    ];

    return $imagens[$nome] ?? "https://via.placeholder.com/250x250?text=Sem+Imagem";
}

// Consulta para buscar os produtos em destaque (destaque = 1)
$destaques = $conn->query("SELECT * FROM produtos WHERE destaque = 1 LIMIT 3");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fugaz+One&family=Titan+One&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="ecommerce.css" />
    <title>E-Music WebStore</title>
  </head>
  <body>
    <section>
      <div class="cabecalho-nav">
        <img class="img-produtos" src="./vinyl_PNG63.png" alt="" />
        <h1 style="padding-left: 1rem">E-Music Store</h1>
      </div>
      <header>
        <nav>
          <ul class="menunav" style="gap: 2rem">
            <li><a href="./index.php">Página Inicial</a></li>
            <li><a href="./produtos.php">Produtos</a></li>
            <li><a href="./carrinho.php">Carrinho</a></li>
            <li><a href="./faleconosco.html">Fale Conosco</a></li>
          </ul>
        </nav>
      </header>
    </section>

    <main>
      <article id="noticiadestaque">
        <h2 style="text-align: center">
          Oficina de Música de Curitiba terá curso de DJ e vinil em teatro da
          CIC
        </h2>
        <img
          class="img-noticia"
          src="https://rollingstone.com.br/wp-content/uploads/legacy/2016/img-1038765-record-store-day-minidocumentario.jpg"
          alt="imagem noticia"
        />
        <p>
          A 42ª Oficina de Música de Curitiba, que começa em 22 de janeiro,
          oferece 89 cursos que abrangem desde música antiga e erudita até
          música eletrônica e inclusão social. Um dos destaques é a oficina
          prática “Vinil: A Arte de Manipular os Discos”, ministrada pelo DJ
          Popson, que ensinará fundamentos do turntablismo, técnicas de scratch
          e beat juggling para iniciantes, com aulas gratuitas no bairro CIC, o
          mais populoso da cidade. A proposta reforça o compromisso do evento
          com a democratização do acesso à cultura, unindo teoria e prática.
          <br />Além do curso de DJ, a programação da oficina inclui iniciativas
          voltadas à inclusão, como aulas de musicografia em braille com a
          doutora Fabiana Bonilha e estratégias de ensino musical para autistas
          com a pianista Liana Monteiro. Essas ações mostram como o evento
          integra tecnologia, acessibilidade e diversidade, consolidando-se como
          um dos principais festivais de formação musical do Brasil.
        </p>
      </article>
      <br />
      <h2>Produtos em Destaque:</h2>
      <section class="main-produtos">
        
        <?php if($destaques->num_rows > 0): ?>
            <?php while($produto = $destaques->fetch_assoc()): ?>
                <div class="card">
                    <h2><?= $produto['nome'] ?></h2>
                    <img
                        src="<?= pegarImagemProduto($produto['nome']) ?>"
                        alt="Imagem do produto: <?= $produto['nome'] ?>"
                    />
                    <p style="text-align: center">
                        <?= $produto['descricao'] ?>
                    </p>
                    <h2>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></h2>
                    
                    <div class="addcarrinho">
                        <a href="./produtos.php?add_carrinho=<?= $produto['id'] ?>"><span>🛒</span> Adicionar ao carrinho</a>
                    </div>
                    
                    <div class="addcarrinho" style="margin-top:8px; display: flex; justify-content: center;">
                        <a href="./index.php?remover_destaque=<?= $produto['id'] ?>" onclick="return confirm('Deseja remover o produto \'<?= $produto['nome'] ?>\' dos destaques? Ele continuará no catálogo.')">❌ Remover Destaque</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
             <p style="text-align: center; margin-top: 20px;">Nenhum produto em destaque no momento. Adicione e marque um produto como destaque em 'Produtos'.</p>
        <?php endif; ?>
        
      </section>
    </main>

    <footer>
      <div>
        <p>Desenvolvedor: Arthur Coutinho</p>
        <p>Telefone: (31) 91234-5678</p>
        <p>Email: arthur.coutinho@gmail.com</p>
      </div>
    </footer>
  </body>
</html>