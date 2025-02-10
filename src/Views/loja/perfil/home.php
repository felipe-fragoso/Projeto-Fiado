<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Minha Loja</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?=$data->nome?></p>
                    <p><b>Endereço:</b> <?=$data->endereco?></p>
                    <p><b>Telefone:</b> <?=$data->formatPhone('telefone')?></p>
                    <p><b>Criada em:</b> <?=$data->dateToBr('criada')?></p>
                    <p><b>Hora funcionamento:</b> <?=$data->abre?> até <?=$data->fecha?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <div class="card card-full">
            <h3 class="card-title">Descrição loja</h3>
            <div class="card-content">
                <?=$data->descricao?>
            </div>
        </div>
    </section>
</main>