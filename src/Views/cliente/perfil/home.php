<main class="main-content-aside">
    <section class="system-section">
        <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
        <div class="list-card">
            <div class="card card-full">
                <h3 class="card-title">Meus detalhes</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?=$data->nome?></p>
                    <p><b>Email:</b> <?=$data->email?></p>
                    <p><b>CPF:</b> <?=$data->formatCpf('cpf')?></p>
                    <p><b>Telefone:</b> <?=$data->formatPhone('telefone')?></p>
                    <p><b>Endereço:</b> <?=$data->endereco?></p>
                    <p><b>Conta criada em:</b> <?=$data->dateToBr('criado')?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <div class="card card-full">
            <h3 class="card-title">Minha Descrição</h3>
            <div class="card-content">
                <?=$data->descricao?>
            </div>
        </div>
    </section>
</main>