<main class="main-content-aside">
    <section class="system-section">
        <a href="<?=$_SERVER["BASE_URL"]?>cliente/novo" class="new-btn">Novo Cliente</a>
    </section>
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h2>Clientes</h2>
        </header>
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
                            <a href="<?=$_SERVER["BASE_URL"]?>cliente/ver/<?=$clienteLoja->id?>">
                                <?=$clienteLoja->nome?>
                            </a>
                        </td>
                        <td><?=$clienteLoja->email?></td>
                        <td><?=$clienteLoja->dateToBr('data')?></td>
                        <td><?=$clienteLoja->ativo ? 'Sim' : 'Não'?></td>
                        <td><a href="<?=$_SERVER["BASE_URL"]?>cliente/detalhe/<?=$clienteLoja->id?>">Detalhe</a></td>
                        <td><a href="<?=$_SERVER["BASE_URL"]?>cliente/editar/<?=$clienteLoja->id?>">Editar</a></td>
                    </tr>
                    <?php
                            endforeach;
                            endif

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