<main class="main-content-aside">
    <section class="system-section">
        <header class="form-header">
            <h2 class="page-header">Edição de Cliente</h2>
        </header>

        <div class="form-box">
            <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
            <form method="post" action="<?=$_SERVER["BASE_URL"]?>cliente/salvar">
                <div class="full-input">
                    <label for="ipt-email">Email:</label>
                    <input type="email" name="ipt-email" id="ipt-email" value="<?=$data->email?>" disabled>
                </div>
                <div class="full-input">
                    <label for="ipt-credito">Crédito Máximo:</label>
                    <input type="number" name="ipt-credito" id="ipt-credito"
                        value="<?=$data->formatNumber('creditoMaximo', 2)?>" min="0.00" max="9999" step="0.01">
                </div>
                <div class="full-input">
                    <label for="sel-ativo">Ativo:</label>
                    <select name="sel-ativo" id="sel-ativo">
                        <option value="S" <?=$data->ativo ? 'selected' : ''?>>Sim</option>
                        <option value="N" <?=$data->ativo ? '' : 'selected'?>>Não</option>
                    </select>
                </div>
                <div>
                    <input type="hidden" name="hidden-token" value="<?=$token?>">
                    <input type="hidden" name="ipt-id" value="<?=$data->id?>">
                    <input type="submit" value="Editar" class="btn-enviar">
                </div>
            </form>
        </div>
    </section>
</main>