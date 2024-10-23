<?php /** @var \Fiado\Core\ViewHelper $produto */ ?>
<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Produto</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?= $produto->name ?></p>
                    <p><b>Valor:</b> R$ <?= $produto->formatToReal('price') ?></p>
                    <p><b>Cadastrado em:</b> <?= $produto->dateToBr('date') ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <div class="card card-full">
            <h3 class="card-title">Descrição Produto</h3>
            <div class="card-content">
                <?= $produto->description ?>
            </div>
        </div>
    </section>
</main>