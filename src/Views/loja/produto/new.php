<main class="main-content-aside">
    <section class="system-section">
        <header class="form-header">
            <h2 class="page-header">Cadastro de Produto</h2>
        </header>
        <form method="post" action="/loja/produtoSalvar" class="form-box">
            <div class="full-input">
                <label for="ipt-nome">Nome:</label>
                <input type="text" name="" id="ipt-nome" value="">
            </div>
            <div class="full-input">
                <div class="half-input">
                    <label for="ipt-preco">Valor:</label>
                    <input type="number" name="" id="ipt-preco" value="" min="0" max="999" step="0.01">
                </div>
                <div class="half-input">
                    <label for="sel-ativo">Ativo:</label>
                    <select name="" id="sel-ativo">
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
            </div>
            <div class="full-input">
                <label for="txta-descricao">Descrição:</label>
                <textarea name="" id="txta-descricao"></textarea>
            </div>

            <div>
                <input type="submit" value="Cadastrar" class="btn-enviar">
            </div>
        </form>
    </section>
</main>