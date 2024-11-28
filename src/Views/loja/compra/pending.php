<?php /** @var Fiado\Core\ViewHelper $data */?>
<main class="main-content-aside">
    <section class="system-section">
        <div class="list-card">
            <div class="card card-big">
                <h3 class="card-title">Detalhe Compras Pendentes</h3>
                <div class="card-content">
                    <p><b>Este mês:</b> R$ <?=$data->formatToReal('esteMes')?></p>
                    <p><b>Total:</b> R$ <?=$data->formatToReal('total')?></p>
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
        <header class="section-header section-header-padding">
            <h2>Compras Pendentes</h2>
        </header>
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
                        Vencimento
                    </th>
                    <th colspan="2" class="th-center">
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
                            <a href="<?=$_SERVER["BASE_URL"]?>cliente/ver/<?= $item->idCliente ?>">
                                <?= $item->nome ?>
                            </a>
                        </td>
                        <td>R$ <?= $item->formatToReal('total') ?></td>
                        <td><?= $item->dateToBr('data') ?></td>
                        <td><?= $item->dateToBr('vencimento') ?></td>
                        <td><a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?= $item->id ?>">Detalhe</a></td>
                        <td><a href="<?=$_SERVER["BASE_URL"]?>compra/detalhe/<?= $item->id ?>">Encerrar</a></td>
                    </tr>
                    <?php
                            endforeach;
                            endif;
                        ?>
                </tbody>
            </table>
            <div class="pagination">
                <ol>
                    <li><a href="">Primeira</a></li>
                    <li><a href="">Anterior</a></li>
                    <li><span>1</span></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                    <li><a href="">5</a></li>
                    <li><a href="">Próximo</a></li>
                    <li><a href="">Última</a></li>
                </ol>
            </div>
        </div>
    </section>
</main>