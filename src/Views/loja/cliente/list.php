<main class="main-content-aside">
    <section class="system-section">
        <a href="<?=$_SERVER["BASE_URL"]?>cliente/novo" class="new-btn">Novo Cliente</a>
    </section>
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h2>Clientes</h2>
        </header>
        <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
        <div class="table-box">
            <table>
                <thead>
                    <th>
                        Nome
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Data Cadastro
                    </th>
                    <th>
                        Ativo
                    </th>
                    <th colspan="2" class="th-center">
                        Opções
                    </th>
                </thead>
                <tbody>
                    <?php
                        if (!$data->list):
                    ?>
                    <tr>
                        <td colspan="6" class="th-center">Nenhum registro encontrado</td>
                    </tr>
                    <?php
                        else:
                            foreach ($data->list as $clienteLoja):
                    ?>
                    <tr>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>cliente/ver/<?=$clienteLoja->formatIdx('id')?>">
                                <?=$clienteLoja->nome?>
                            </a>
                        </td>
                        <td><?=$clienteLoja->email?></td>
                        <td><?=$clienteLoja->dateToBr('data')?></td>
                        <td><?=$clienteLoja->ativo ? 'Sim' : 'Não'?></td>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>cliente/detalhe/<?=$clienteLoja->formatIdx('id')?>">
                                Detalhe
                            </a>
                        </td>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>cliente/editar/<?=$clienteLoja->formatIdx('id')?>">
                                Editar
                            </a>
                        </td>
                    </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
            <?php $this->loadComponent('pagination', ['pagination' => $data->clientePagination])?>
        </div>
    </section>
</main>