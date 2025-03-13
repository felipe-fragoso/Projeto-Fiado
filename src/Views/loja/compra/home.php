<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-big">
                <h3 class="card-title">Detalhe Compras</h3>
                <div class="card-content">
                    <p><b>Este mês:</b> R$ <?=$data->formatToReal('esteMes')?></p>
                    <p><b>Total:</b> R$ <?=$data->formatToReal('total')?></p>
                    <p><b>Pendente:</b> R$ <?=$data->formatToReal('pendente')?></p>
                </div>
            </div>
            <div class="card card-big">
                <h3 class="card-title">Meus Dados</h3>
                <div class="card-content">
                    <p><b>Nome:</b> <?=$data->nome?></p>
                    <p><b>Email:</b> <?=$data->email?></p>
                    <p><a href="<?=$_SERVER["BASE_URL"]?>perfil">Mais Detalhes</a></p>
                </div>
            </div>
        </div>
    </section>
    <section class="system-section">
        <?php
            $this->loadComponent('searchBar', ['search' => $data->search, 'placeholder' => 'Pesquisar compra por cliente...'])
        ?>
        <header class="section-header section-header-padding">
            <h2>Compras</h2>
        </header>
        <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
        <div class="table-box">
            <table>
                <thead>
                    <th>
                        Cliente
                    </th>
                    <th>
                        Valor
                    </th>
                    <th>
                        Data
                    </th>
                    <th>
                        Pago
                    </th>
                    <th>
                        Opções
                    </th>
                </thead>
                <tbody>
                    <?php
                        if ($data->list):
                            /** @var Fiado\Core\ViewHelper $item */
                            foreach ($data->list as $item):
                    ?>
                    <tr>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>cliente/ver/<?=$item->formatIdx('idClienteLoja')?>">
                                <?=$item->nome?>
                            </a>
                        </td>
                        <td>R$ <?=$item->formatToReal('total')?></td>
                        <td><?=$item->dateToBr('data')?></td>
                        <td><?=$item->pago ? 'Sim' : 'Não';?></td>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?=$item->formatIdx('id')?>">Detalhe</a>
                        </td>
                    </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
            <?php $this->loadComponent('pagination', ['pagination' => $data->compraPagination])?>
        </div>
    </section>
</main>