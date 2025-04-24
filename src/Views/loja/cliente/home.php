<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Cliente</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?=$data->nome?></p>
                    <p><b>Email:</b> <?=$data->email?></p>
                    <p><b>Telefone:</b> <?=$data->formatPhone('telefone')?></p>
                    <p>
                        <b>
                            <a href="<?=$_SERVER["BASE_URL"]?>cliente/detalhe/<?=$data->formatIdx('id')?>">
                                Mais detalhes
                            </a>
                        </b>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h3>Compras na loja</h3>
        </header>
        <div class="list-card list-card-fix-3">
            <?php
                if ($data->list && !empty((array) $data->list)):
                    /** @var Fiado\Core\ViewHelper $compra */
                    foreach ($data->list as $compra):
            ?>
            <div class="card card-medium">
                <h3 class="card-title">Compra: <?=$compra->formatIdx('id')?></h3>
                <div class="card-content">
                    <p><b>Valor:</b> R$ <?=$compra->formatToReal('valor')?></p>
                    <p><b>Data:</b> <?=$compra->dateToBr('data')?></p>
                    <p><b>Pago:</b> <?=$compra->pago ? 'Sim' : 'Não'?></p>
                    <p>
                        <b>
                            <a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?=$compra->formatIdx('id')?>">
                                Mais Detalhes
                            </a>
                        </b>
                    </p>
                </div>
            </div>
            <?php
                    endforeach;
                else:
            ?>
            <div class="card card-full">
                <h3 class="card-title text-center">Vazio</h3>
                <div class="card-content text-center">
                    <p>Nenhum registro encontrado</p>
                </div>
            </div>
            <?php
                endif;
            ?>
        </div>
        <?php $this->loadComponent('pagination', ['pagination' => $data->compraPagination])?>
    </section>
</main>