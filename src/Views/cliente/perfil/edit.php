<main class="main-content-aside">
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Meus Detalhes</h3>
        </header>
        <div class="form-box">
            <form method="POST" action="<?= $_SERVER["BASE_URL"] ?>perfil/salvar">
                <div class="full-input">
                    <label for="ipt-nome">Nome:</label>
                    <input type="text" name="" id="ipt-nome" value="Xxxxx xxxx">
                </div>
                <div class="full-input">
                    <label for="ipt-funcionamento">Email:</label>
                    <input type="text" name="" id="ipt-funcionamento" value="xx:xx:xx até xx:xx:xx">
                </div>
                <div class="full-input">
                    <label for="ipt-endereco">Endereço:</label>
                    <input type="text" name="" id="ipt-endereco" value="Xxxxxxx xxxxx/XX">
                </div>
                <div class="full-input">
                    <label for="ipt-telefone">Telefone:</label>
                    <input type="text" name="" id="ipt-telefone" value="(xx) xxxxx-xxxx">
                </div>
                <div class="full-input">
                    <label for="ipt-criada">Criada em:</label>
                    <input type="datetime-local" name="" id="ipt-criada" value="2023-12-25T12:00:00">
                </div>
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Minha Descrição</h3>
        </header>
        <div class="form-box">
            <form method="POST" action="<?= $_SERVER["BASE_URL"] ?>perfil/salvar">
                <div class="full-input">
                    <label for="ipt-descricao">Descrição:</label>
                    <textarea name="" id="ipt-descricao">Cliente Xxxx, xxxxxx xxxxx.</textarea>
                </div>
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
</main>