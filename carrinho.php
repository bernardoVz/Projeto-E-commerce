<?php
session_start();
include "conexao.php";

/* REMOVER PRODUTO */
if (isset($_GET['remover'])) {
    $id = $_GET['remover'];
    unset($_SESSION['carrinho'][$id]);
}

/* BUSCAR IMAGEM POR NOME */
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

    return $imagens[$nome] ?? "https://via.placeholder.com/80";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho - E-Music Store</title>
    <link rel="stylesheet" href="ecommerce.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fugaz+One&family=Titan+One&display=swap"
      rel="stylesheet"
    />
</head>
<body>

<section>
    <div class="cabecalho-nav">
        <img class="img-produtos" src="./vinyl_PNG63.png" alt="">
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
    <section class="carrinho-section">
        <h2>Carrinho de Compras</h2>

        <table class="carrinho">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Qtd</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $total = 0;

            if (!empty($_SESSION['carrinho'])) {

                foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {

                    $resultado = $conn->query("SELECT * FROM produtos WHERE id = $id_produto");
                    $produto = $resultado->fetch_assoc();

                    if(!$produto) continue;

                    $subtotal = $produto['preco'] * $quantidade;
                    $total += $subtotal;
            ?>

                <tr>
                    <td>
                        <img src="<?= pegarImagemProduto($produto['nome']) ?>" alt="Imagem">
                    </td>
                    <td><?= $produto['nome'] ?></td>
                    <td><?= $produto['descricao'] ?></td>
                    <td><?= $quantidade ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                    <td>
                        <a href="carrinho.php?remover=<?= $produto['id'] ?>">Remover</a>
                    </td>
                </tr>

            <?php
                }

            } else {
                echo "<tr><td colspan='7'>Seu carrinho está vazio</td></tr>";
            }
            ?>

            </tbody>
        </table>

        <div class="resumo-carrinho">
            <h3>Total: R$ <?= number_format($total, 2, ',', '.') ?></h3>

            <div class="acoes-carrinho">
                <a href="produtos.php">
                    <button class="btn-continuar">Continuar Comprando</button>
                </a>

                <button class="btn-finalizar">Finalizar Compra</button>
            </div>
        </div>
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