<main class="main-content-aside">
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Meus Detalhes</h3>
        </header>
        <div class="form-box">
            <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
            <form method="POST" action="<?=$_SERVER["BASE_URL"]?>perfil/salvar">
                <div class="full-input">
                    <label for="ipt-nome">Nome:</label>
                    <input type="text" name="ipt-nome" id="ipt-nome" value="<?=$data->nome?>">
                </div>
                <div class="full-input">
                    <label for="ipt-endereco">Endereço:</label>
                    <input type="text" name="ipt-endereco" id="ipt-endereco" value="<?=$data->endereco?>">
                </div>
                <div class="full-input">
                    <label for="ipt-telefone">Telefone:</label>
                    <input type="text" name="ipt-telefone" id="ipt-telefone"
                        value="<?=$data->formatPhone('telefone')?>">
                </div>
                <input type="hidden" name="hidden-token" value="<?=$token?>">
                <input type="hidden" name="ipt-id" value="<?=$data->id?>">
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Minha Descrição</h3>
        </header>
        <div class="form-box">
            <form method="POST" action="<?=$_SERVER["BASE_URL"]?>perfil/salvar">
                <div class="full-input">
                    <label for="ipt-descricao">Descrição:</label>
                    <textarea name="txt-descricao" id="ipt-descricao"><?=$data->descricao?></textarea>
                </div>
                <input type="hidden" name="hidden-token" value="<?=$token?>">
                <input type="hidden" name="ipt-id" value="<?=$data->id?>">
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
</main>