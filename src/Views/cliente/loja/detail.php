<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Detalhe Loja</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?=$data->nome?></p>
                    <p><b>Email:</b> <?=$data->email?></p>
                    <p><b>CNPJ:</b> <?=$data->formatCnpj('cnpj')?></p>
                    <p><b>Endereço:</b> <?=$data->endereco?></p>
                    <p><b>Telefone:</b> <?=$data->formatPhone('telefone')?></p>
                    <p><b>Criada em:</b> <?=$data->dateToBr('data')?></p>
                    <p><b>Hora funcionamento:</b> <?=$data->abre?> até <?=$data->fecha?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <div class="card card-full">
            <h3 class="card-title">Descrição loja</h3>
            <div class="card-content">
                <?=$data->descricao?>
            </div>
        </div>
    </section>
</main>