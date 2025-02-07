<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h2>Ultimas compras fiado</h2>
        </header>
        <div class="carrossel">
            <a class="carrossel-button carrossel-left" onclick="carrossel(this)"></a>
            <a class="carrossel-button carrossel-right" onclick="carrossel(this)"></a>
            <div class="carrossel-items">
                <?php
                    if ($data->ultimasCompras):
                        /** @var Fiado\Core\ViewHelper $compra */
                        foreach ($data->ultimasCompras as $compra):
                ?>
                <div class="card">
                    <h3 class="card-title">Compra Cliente: <?=$compra->formatIdx('id')?></h3>
                    <div class="card-content">
                        <p><b>Valor:</b> R$ <?=$compra->formatToReal('total')?></p>
                        <p><b>Data:</b> <?=$compra->dateToBr('data')?></p>
                        <p><b>Pago:</b> <?=$compra->pago ? 'Sim' : 'Não'?></p>
                        <p>
                            <a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?=$compra->formatIdx('id')?>">
                                Mais Detalhes
                            </a>
                        </p>
                    </div>
                </div>
                <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h2>Contas pendentes</h2>
        </header>
        <div class="carrossel">
            <a class="carrossel-button carrossel-left" onclick="carrossel(this)"></a>
            <a class="carrossel-button carrossel-right" onclick="carrossel(this)"></a>
            <div class="carrossel-items">
                <?php
                    if ($data->ultimasPendentes):
                        /** @var Fiado\Core\ViewHelper $compra */
                        foreach ($data->ultimasPendentes as $compra):
                ?>
                <div class="card">
                    <h3 class="card-title">Compra Cliente: <?=$compra->formatIdx('id')?></h3>
                    <div class="card-content">
                        <p><b>Valor:</b> R$ <?=$compra->formatToReal('total')?></p>
                        <p><b>Data:</b> <?=$compra->dateToBr('data')?></p>
                        <p>
                            <a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?=$compra->formatIdx('id')?>">
                                Mais Detalhes
                            </a>
                        </p>
                    </div>
                </div>
                <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h2>Meus dados</h2>
        </header>
        <div class="list-card">
            <?php
                $this->loadComponent(
                    'barGraph',
                    [
                        'title' => 'Últimos dias',
                        'url' => $_SERVER["BASE_URL"] . 'compra',
                        'graph' => $data->graficos->dias,
                    ]
                );
                $this->loadComponent(
                    'barGraph',
                    [
                        'title' => 'Valores pendentes',
                        'url' => $_SERVER["BASE_URL"] . 'compra/pendente',
                        'graph' => $data->graficos->mesPendente,
                    ]
                );
                $this->loadComponent(
                    'barGraph',
                    [
                        'title' => 'Compras',
                        'url' => $_SERVER["BASE_URL"] . 'compra',
                        'graph' => $data->graficos->mes,
                    ]
                );
            ?>
        </div>
    </section>
</main>
<script src="<?=$_SERVER["BASE_URL"]?>js/grafico.js"></script>