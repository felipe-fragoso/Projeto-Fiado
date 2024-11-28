<?php /** @var \Fiado\Core\ViewHelper $data */ ?>
<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Produto</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?= $data->nome ?></p>
                    <p><b>Valor:</b> R$ <?= $data->formatToReal('preco') ?></p>
                    <p><b>Cadastrado em:</b> <?= $data->dateToBr('data') ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <div class="card card-full">
            <h3 class="card-title">Descrição Produto</h3>
            <div class="card-content">
                <?= $data->descricao ?>
            </div>
        </div>
    </section>
</main>