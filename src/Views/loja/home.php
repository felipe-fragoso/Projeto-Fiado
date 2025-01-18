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
                <?php if ($data->ultimasCompras):
                    /** @var Fiado\Core\ViewHelper $compra */
                    foreach ($data->ultimasCompras as $compra): ?>
                <div class="card">
                    <h3 class="card-title">Compra Cliente: <?=$compra->id?></h3>
                    <div class="card-content">
                        <p><b>Valor:</b> R$ <?=$compra->formatToReal('total')?></p>
                        <p><b>Data:</b> <?=$compra->dateToBr('data')?></p>
                        <p><b>Pago:</b> <?=$compra->pago ? 'Sim' : 'Não'?></p>
                        <p><a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?=$compra->id?>">Mais Detalhes</a></p>
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
                <?php if ($data->ultimasPendentes):
                    /** @var Fiado\Core\ViewHelper $compra */
                    foreach ($data->ultimasPendentes as $compra): ?>
                <div class="card">
                    <h3 class="card-title">Compra Cliente: <?=$compra->id?></h3>
                    <div class="card-content">
                        <p><b>Valor:</b> R$ <?=$compra->formatToReal('total')?></p>
                        <p><b>Data:</b> <?=$compra->dateToBr('data')?></p>
                        <p><a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?=$compra->id?>">Mais Detalhes</a></p>
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
            <div class="card card-medium">
                <h3 class="card-title">Ultimas dias</h3>
                <div class="card-content">
                    <p><b>Total:</b> R$ <?=$data->graficos->dias->getTotal()?></p>
                    <div class="grafico-barra">
                        <div class="g-moeda"><?=$data->graficos->dias->getMoeda()?></div>
                        <?php
                            foreach ($data->graficos->dias->getBars() as $bar):
                        ?>
                        <div class="g-barra">
                            <div class="g-barra-titulo"><?=$bar->name?></div>
                            <div class="g-barra-valor"><?=$bar->value ?: 0?></div>
                        </div>
                        <?php
                            endforeach;
                        ?>
                    </div>
                    <p><a href="<?=$_SERVER["BASE_URL"]?>compra">Mais Detalhes</a></p>
                </div>
            </div>
            <div class="card card-medium">
                <h3 class="card-title">Valores pendentes</h3>
                <div class="card-content">
                    <p><b>Total:</b> R$ <?=$data->graficos->mesPendente->getTotal()?></p>
                    <div class="grafico-barra">
                        <div class="g-moeda"><?=$data->graficos->mesPendente->getMoeda()?></div>
                        <?php
                            foreach ($data->graficos->mesPendente->getBars() as $bar):
                        ?>
                        <div class="g-barra">
                            <div class="g-barra-titulo"><?=$bar->name?></div>
                            <div class="g-barra-valor"><?=$bar->value ?: 0?></div>
                        </div>
                        <?php
                            endforeach;
                        ?>
                    </div>
                    <p><a href="<?=$_SERVER["BASE_URL"]?>compra/pendente">Mais Detalhes</a></p>
                </div>
            </div>
            <div class="card card-medium">
                <h3 class="card-title">Compras</h3>
                <div class="card-content">
                    <p><b>Total:</b> R$ <?=$data->graficos->mes->getTotal()?></p>
                    <div class="grafico-barra">
                        <div class="g-moeda"><?=$data->graficos->mes->getMoeda()?></div>
                        <?php
                            foreach ($data->graficos->mes->getBars() as $bar):
                        ?>
                        <div class="g-barra">
                            <div class="g-barra-titulo"><?=$bar->name?></div>
                            <div class="g-barra-valor"><?=$bar->value ?: 0?></div>
                        </div>
                        <?php
                            endforeach;
                        ?>
                    </div>
                    <p><a href="<?=$_SERVER["BASE_URL"]?>compra">Mais Detalhes</a></p>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="<?=$_SERVER["BASE_URL"]?>js/grafico.js"></script>