<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Detalhe Minha Loja</h3>
        </header>
        <div class="form-box">
            <?php $this->load('components/flashBar', $viewData)?>
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
                    <input type="text" name="ipt-telefone" id="ipt-telefone" value="<?=$data->telefone?>">
                </div>
                <div class="full-input">
                    <label for="ipt-criada">Criada em:</label>
                    <input type="datetime-local" name="ipt-criada" id="ipt-criada" value="<?=$data->criada?>">
                </div>
                <div class="full-input multiple-input">
                    <label for="ipt-funcionamento">Hora funcionamento:</label>
                    <input type="time" name="ipt-abre" id="ipt-funcionamento" value="<?=$data->abre?>">
                    <label for="ipt-funcionamento-ate" class="inline-label">Até</label>
                    <input type="time" name="ipt-fecha" id="ipt-funcionamento-ate" value="<?=$data->fecha?>">
                </div>
                <input type="hidden" name="ipt-id" value="<?=$data->id?>">
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Descrição loja</h3>
        </header>
        <div class="form-box">
            <form method="POST" action="<?=$_SERVER["BASE_URL"]?>perfil/salvar">
                <div class="full-input">
                    <label for="ipt-descricao">Descrição:</label>
                    <textarea name="txt-descricao" id="ipt-descricao"><?=$data->descricao?></textarea>
                </div>
                <input type="hidden" name="ipt-id" value="<?=$data->id?>">
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
</main>