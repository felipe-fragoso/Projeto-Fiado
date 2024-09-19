<main class="main-content-aside">
    <section class="system-section">
        <header class="form-header">
            <h2 class="page-header">Cadastro de Cliente</h2>
        </header>
        <div class="selecao-um-dois form-box">
            <div class="selecao-header-box">
                <div class="selecao-header">
                    <label for="novo-cliente">Novo Cliente</label>
                    <input type="radio" name="tipo-cliente" value="form-um" id="novo-cliente"
                        onchange="mudaSelecao(this)" checked />
                </div>
                <div class="selecao-header">
                    <label for="fiado-cliente">Cliente FiadoFacil</label>
                    <input type="radio" name="tipo-cliente" value="form-dois" id="fiado-cliente"
                        onchange="mudaSelecao(this)" />
                </div>
            </div>
            <div class="selecao-form-box">
                <div class="selecao-form-um">
                    <form method="post" action="/loja/clienteSalvar">
                        <div class="full-input">
                            <label for="ipt-nome">Nome:</label>
                            <input type="text" name="" id="ipt-nome" value="">
                        </div>
                        <div class="full-input">
                            <label for="ipt-email">Email:</label>
                            <input type="email" name="" id="ipt-email" value="">
                        </div>
                        <div class="full-input">
                            <label for="ipt-tel">Telefone (DDD):</label>
                            <input type="text" name="" id="ipt-tel" value="">
                        </div>
                        <div class="full-input">
                            <label for="ipt-endereco">Endereço:</label>
                            <input type="text" name="" id="ipt-endereco" value="">
                        </div>
                        <div>
                            <input type="submit" value="Cadastrar" class="btn-enviar">
                        </div>
                    </form>
                </div>
                <div class="selecao-form-dois">
                    <form method="post" action="/loja/clienteSalvar">
                        <div class="full-input">
                            <label for="ipt-email2">Email:</label>
                            <input type="email" name="" id="ipt-email2" value="">
                        </div>
                        <div>
                            <input type="submit" value="Cadastrar" class="btn-enviar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<link rel="stylesheet" type="text/css" href="../css/selecao-um-dois.css">
<script src="../js/selecao-um-dois.js"></script>