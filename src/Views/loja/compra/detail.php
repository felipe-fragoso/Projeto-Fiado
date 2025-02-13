<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Compra</h3>
                <div class="card-content">
                    <p><b>Cliente:</b>
                        <a href="<?=$_SERVER["BASE_URL"]?>cliente/ver/<?=$data->formatIdx('idClienteLoja')?>">
                            <?=$data->cliente?>
                        </a>
                    </p>
                    <p><b>Total:</b> R$ <?=$data->formatToReal('total')?></p>
                    <p><b>Data compra:</b> <?=$data->dateToBr('data')?></p>
                    <p><b>Data Vencimento:</b> <?=$data->dateToBr('dataVencimento')?></p>
                    <p><b>Pago:</b> <?=$data->pago ? 'Sim' : 'Não'?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h3>Lista de itens</h3>
        </header>
        <div class="list-card list-card-fix-3">
            <?php
                if ($data->itens):
                    /** @var Fiado\Core\ViewHelper $item */
                    foreach ($data->itens as $item):
            ?>
            <div class="card card-medium">
                <h3 class="card-title">Produto: <?=$item->formatIdx('idProduto')?></h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?=$item->nomeProduto?></p>
                    <p><b>Preço:</b> R$ <?=$item->formatToReal('preco')?></p>
                    <p><b>Quantidade:</b> <?=$item->quantidade?></p>
                    <p><b>Subtotal:</b> R$ <?=$item->formatToReal('subtotal')?></p>
                </div>
            </div>
            <?php
                    endforeach;
                else:
            ?>
            <div class="card card-medium">
                <h3 class="card-title">Produto vazio</h3>
                <div class="card-content">
                    <p>Nenhum Produto encontrado</p>
                </div>
            </div>
            <?php
                endif;
            ?>
        </div>
    </section>
</main>