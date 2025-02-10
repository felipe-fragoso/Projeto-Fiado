<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Editar Minhas Configurações</h3>
        </header>
        <div class="form-box">
            <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
            <form method="POST" action="<?=$_SERVER["BASE_URL"]?>config/salvar">
                <div class="full-input">
                    <label for="ipt-prazo">Prazo(Dias):</label>
                    <input type="number" name="ipt-prazo" id="ipt-prazo" value="<?=$data->prazo?>" min="1" max="999"
                        step="1">
                </div>
                <div class="full-input">
                    <label for="ipt-credito">Credito Máximo(Reais):</label>
                    <input type="number" name="ipt-credito" id="ipt-credito" value="<?=$data->credito?>" min="0.01"
                        max="9999" step="0.01">
                </div>
                <input type="hidden" name="hidden-token" value="<?=$token?>">
                <input type="hidden" name="ipt-id" value="<?=$data->id?>">
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
</main>