<main class="main-content-aside">
    <section class="system-section">
        <header class="form-header">
            <h2 class="page-header">Cadastro de Cliente</h2>
        </header>
        <div class="selecao-um-dois form-box">
            <div class="selecao-header-box">
                <div class="selecao-header">
                    <label for="novo-cliente">Novo Cliente</label>
                    <input type="radio" name="tipo-cliente" value="form-um" id="novo-cliente" class="selecao-radio"
                        onchange="mudaSelecao(this)" <?=$data->tipo === 'n' ? 'checked' : ''?> />
                </div>
                <div class="selecao-header">
                    <label for="fiado-cliente">Cliente FiadoFacil</label>
                    <input type="radio" name="tipo-cliente" value="form-dois" id="fiado-cliente" class="selecao-radio"
                        onchange="mudaSelecao(this)" <?=$data->tipo === 'c' ? 'checked' : ''?> />
                </div>
            </div>
            <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
            <div class="selecao-form-box">
                <div class="selecao-form-um">
                    <form method="post" action="<?=$_SERVER["BASE_URL"]?>cliente/salvar">
                        <div class="full-input">
                            <label for="ipt-nome">Nome:</label>
                            <input type="text" name="ipt-nome" id="ipt-nome" value="<?=$flash?->form?->{'ipt-nome'}?>">
                        </div>
                        <div class="full-input">
                            <label for="ipt-email">Email:</label>
                            <input type="email" name="ipt-email" id="ipt-email"
                                value="<?=$flash?->form?->{'ipt-email'}?>">
                        </div>
                        <div class="full-input">
                            <label for="ipt-cpf">CPF:</label>
                            <input type="text" name="ipt-cpf" id="ipt-cpf" value="<?=$flash?->form?->{'ipt-cpf'}?>">
                        </div>
                        <div class="full-input">
                            <label for="ipt-tel">Telefone (DDD):</label>
                            <input type="text" name="ipt-tel" id="ipt-tel" value="<?=$flash?->form?->{'ipt-tel'}?>">
                        </div>
                        <div class="full-input">
                            <label for="ipt-endereco">Endereço:</label>
                            <input type="text" name="ipt-endereco" id="ipt-endereco"
                                value="<?=$flash?->form?->{'ipt-endereco'}?>">
                        </div>
                        <div>
                            <input type="hidden" name="ipt-tipo" value="n">
                            <input type="submit" value="Cadastrar" class="btn-enviar">
                        </div>
                    </form>
                </div>
                <div class="selecao-form-dois">
                    <form method="post" action="<?=$_SERVER["BASE_URL"]?>cliente/salvar">
                        <div class="full-input">
                            <label for="ipt-email2">Email:</label>
                            <input type="email" name="ipt-email-cliente" id="ipt-email2"
                                value="<?=$flash?->form?->{'ipt-email-cliente'}?>">
                        </div>
                        <div>
                            <input type="hidden" name="ipt-tipo" value="c">
                            <input type="submit" value="Cadastrar" class="btn-enviar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<link rel="stylesheet" type="text/css" href="<?=$_SERVER["BASE_URL"]?>css/selecao-um-dois.css">
<script src="<?=$_SERVER["BASE_URL"]?>js/selecao-um-dois.js"></script>