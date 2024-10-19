<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Produto</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?= $produto['name'] ?></p>
                    <p><b>Valor:</b> R$ <?= number_format($produto['price'], 2, ',', '.') ?></p>
                    <p><b>Cadastrado em:</b> <?= date('d/m/Y H:i:s', strtotime($produto['date'])) ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <div class="card card-full">
            <h3 class="card-title">Descrição Produto</h3>
            <div class="card-content">
                <?= $produto['description'] ?>
            </div>
        </div>
    </section>
</main>