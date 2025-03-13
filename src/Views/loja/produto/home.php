<main class="main-content-aside">
    <section class="system-section">
        <a href="<?=$_SERVER["BASE_URL"]?>produto/novo" class="new-btn">Novo Produto</a>
    </section>
    <section class="system-section">
        <?php
            $this->loadComponent('searchBar', ['search' => $data->search, 'placeholder' => 'Pesquisar produto...'])
        ?>
        <header class="section-header section-header-padding">
            <h2>Produtos</h2>
        </header>
        <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
        <div class="table-box">
            <table>
                <thead>
                    <th>
                        Nome
                    </th>
                    <th>
                        Valor
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
                        if (!$data->produtos):
                    ?>
                    <tr>
                        <td class="th-center" colspan="6">Nenhum produto encontrado</td>
                    </tr>
                    <?php
                        else:
                            /** @var \Fiado\Core\ViewHelper $produto */
                            foreach ($data->produtos as $produto):
                    ?>
                    <tr>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>produto/detalhe/<?=$produto->formatIdx('id')?>">
                                <?=$produto->nome?>
                            </a>
                        </td>
                        <td>R$ <?=$produto->formatToReal('preco')?></td>
                        <td><?=$produto->dateToBr('data')?></td>
                        <td><?=$produto->ativo ? 'Sim' : 'Não'?></td>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>produto/detalhe/<?=$produto->formatIdx('id')?>">
                                Detalhe
                            </a>
                        </td>
                        <td>
                            <a href="<?=$_SERVER["BASE_URL"]?>produto/editar/<?=$produto->formatIdx('id')?>">Editar</a>
                        </td>
                    </tr>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </tbody>
            </table>
            <?php $this->loadComponent('pagination', ['pagination' => $data->produtoPagination])?>
        </div>
    </section>
</main>