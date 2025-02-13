<?php /** @var \Fiado\core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Cliente</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?=$data->nome?></p>
                    <p><b>Email:</b> <?=$data->email?></p>
                    <p><b>Crédito máximo:</b> R$ <?=$data->formatToReal('credito')?></p>
                    <p><b>Telefone:</b> <?=$data->formatPhone('telefone')?></p>
                    <p><b>Endereço:</b> <?=$data->endereco?></p>
                    <p><b>Criado em:</b> <?=$data->dateToBr('data')?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <div class="card card-full">
            <h3 class="card-title">Descrição cliente</h3>
            <div class="card-content">
                <?=$data->descricao?>
            </div>
        </div>
    </section>
</main>