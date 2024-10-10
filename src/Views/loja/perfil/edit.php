<main class="main-content-aside">
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Detalhe Minha Loja</h3>
        </header>
        <div class="form-box">
            <form method="POST" action="<?= $_SERVER["BASE_URL"] ?>perfil/salvar">
                <div class="full-input">
                    <label for="ipt-nome">Nome:</label>
                    <input type="text" name="" id="ipt-nome" value="Xxxxx xxxx">
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
                    <input type="datetime-local" name="" id="ipt-criada" value="2024-12-25T12:00:00">
                </div>
                <div class="full-input multiple-input">
                    <label for="ipt-funcionamento">Hora funcionamento:</label>
                    <input type="time" name="" id="ipt-funcionamento" value="12:00:00">
                    <label for="ipt-funcionamento-ate" class="inline-label">Até</label>
                    <input type="time" name="" id="ipt-funcionamento-ate" value="20:00:00">
                </div>
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
    <section class="system-section">
        <header class="section-header form-header">
            <h3>Descrição loja</h3>
        </header>
        <div class="form-box">
            <form method="POST" action="<?= $_SERVER["BASE_URL"] ?>perfil/salvar">
                <div class="full-input">
                    <label for="ipt-descricao">Descrição:</label>
                    <textarea name=""
                        id="ipt-descricao">Loja do Xxxx, venha para comprar na nossa loja xxxxxx xxxxx.</textarea>
                </div>
                <input type="submit" class="btn-enviar" value="Salvar">
            </form>
        </div>
    </section>
</main>