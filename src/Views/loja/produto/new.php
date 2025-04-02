<main class="main-content-aside">
    <section class="system-section">
        <header class="form-header">
            <h2 class="page-header">Cadastro de Produto</h2>
        </header>
        <form method="post" action="<?=$_SERVER["BASE_URL"]?>produto/salvar" class="form-box">
            <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
            <div class="full-input">
                <label for="ipt-nome">Nome:</label>
                <input type="text" name="ipt-nome" id="ipt-nome" value="<?=$flash?->form?->{'ipt-nome'}?>">
            </div>
            <div class="full-input">
                <div class="half-input">
                    <label for="ipt-preco">Valor:</label>
                    <input type="number" name="ipt-preco" id="ipt-preco" min="0" max="9999" step="0.01"
                        value="<?=$flash?->form?->formatNumber('ipt-preco', 2)?>">
                </div>
                <div class="half-input">
                    <label for="sel-ativo">Ativo:</label>
                    <select name="sel-ativo" id="sel-ativo">
                        <option value="S" <?=$flash?->form?->{'sel-ativo'} === true ? 'selected' : ''?>>Sim</option>
                        <option value="N" <?=$flash?->form?->{'sel-ativo'} === false ? 'selected' : ''?>>Não</option>
                    </select>
                </div>
            </div>
            <div class="full-input">
                <label for="txta-descricao">Descrição:</label>
                <textarea name="txta-descricao" id="txta-descricao"><?=$flash?->form?->{'txta-descricao'}?></textarea>
            </div>

            <div>
                <input type="hidden" name="hidden-token" value="<?=$token?>">
                <input type="submit" value="Cadastrar" class="btn-enviar">
            </div>
        </form>
    </section>
</main>