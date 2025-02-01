<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Minhas Configurações</h3>
                <div class="card-content">
                    <p><b>Prazo pagamento:</b> <?=$data->prazo?> dias</p>
                    <p><b>Limite crédito:</b> R$ <?=$data->formatToReal('credito')?></p>
                    <p><a href="<?=$_SERVER["BASE_URL"]?>config/editar">Editar</a></p>
                </div>
            </div>
        </div>
    </section>
</main>