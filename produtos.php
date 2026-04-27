<?php
session_start();
include "conexao.php";

if (isset($_GET['add_carrinho'])) {

    $id_produto = $_GET['add_carrinho'];

    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    if (isset($_SESSION['carrinho'][$id_produto])) {
        $_SESSION['carrinho'][$id_produto]++;
    } else {
        $_SESSION['carrinho'][$id_produto] = 1;
    }

    header("Location: produtos.php");
    exit();
}

if (isset($_POST['inserir'])) {

    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    // NOVO: Captura o valor de destaque (1 se marcado, 0 se não)
    $destaque = isset($_POST['destaque']) ? 1 : 0; 

    // ATUALIZAÇÃO DO SQL: Adiciona a coluna 'destaque'
    $conn->query("INSERT INTO produtos (nome, preco, descricao, destaque) VALUES ('$nome', '$preco', '$descricao', '$destaque')");
}

if (isset($_GET['excluir'])) {

    $id = $_GET['excluir'];
    $conn->query("DELETE FROM produtos WHERE id = $id");

    header("Location: produtos.php");
    exit();
}

if (isset($_POST['editar'])) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    // NOVO: Captura o valor de destaque (1 se marcado, 0 se não)
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    
    // ATUALIZAÇÃO DO SQL: Adiciona a coluna 'destaque'
    $conn->query("UPDATE produtos SET nome='$nome', preco='$preco', descricao='$descricao', destaque='$destaque' WHERE id=$id");

    header("Location: produtos.php");
    exit();
}

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

$produtos = $conn->query("SELECT * FROM produtos");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos - E-Music Store</title>
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
    <h2>Catálogo completo de produtos:</h2>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome do produto" required>
        <input type="number" step="0.01" name="preco" placeholder="Preço" required>
        <input type="text" name="descricao" placeholder="Descrição" required>
        
        <label style="color: white;"><input type="checkbox" name="destaque" value="1"> Produto de Destaque?</label>

        <button type="submit" name="inserir">Adicionar produto</button>
    </form>
<br><br>
    <section class="produtos-lista">
        <div class="bloco-card">

        <?php while($produto = $produtos->fetch_assoc()): ?>

            <?php if(isset($_GET['editar_form']) && $_GET['editar_form'] == $produto['id']): ?>

                <form method="POST" style="background:#2d2d44;padding:1rem;border-radius:10px;">
                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                    <input type="text" name="nome" value="<?= $produto['nome'] ?>" required>
                    <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required>
                    <input type="text" name="descricao" value="<?= $produto['descricao'] ?>" required>
                    
                    <label style="color: white; margin-top: 10px;">
                        <input type="checkbox" name="destaque" value="1" <?= $produto['destaque'] == 1 ? 'checked' : '' ?>> 
                        Produto de Destaque?
                    </label>

                    <button type="submit" name="editar">Salvar</button>
                </form>

            <?php else: ?>

                <div class="card">

                    <h2><?= $produto['nome'] ?></h2>
                    
                    <?php if($produto['destaque'] == 1): ?>
                        <p style="color: #ffcc00; font-weight: bold;">✨ DESTAQUE ✨</p>
                    <?php endif; ?>

                    <img src="<?= pegarImagemProduto($produto['nome']) ?>" alt="Imagem do produto">

                    <p><?= $produto['descricao'] ?></p>

                    <h2>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></h2>

                    <div class="addcarrinho">
                        <a href="produtos.php?add_carrinho=<?= $produto['id'] ?>">🛒 Carrinho</a>
                    </div>

                    <div class="addcarrinho" style="margin-top:8px;">
                        <a href="produtos.php?editar_form=<?= $produto['id'] ?>">✏️ Editar</a>
                        |
                        <a href="produtos.php?excluir=<?= $produto['id'] ?>" onclick="return confirm('Excluir produto?')">🗑️ Excluir</a>
                    </div>

                </div>

            <?php endif; ?>

        <?php endwhile; ?>

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