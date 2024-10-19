<main class="main-content-aside">
    <section class="system-section">
        <a href="<?=$_SERVER["BASE_URL"]?>produto/novo" class="new-btn">Novo Produto</a>
    </section>
    <section class="system-section">
        <header class="section-header section-header-padding">
            <h2>Produtos</h2>
        </header>
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
                        if (!$produtos):
                    ?>
                    <tr>
                        <td class="th-center" colspan="6">Nenhum produto encontrado</td>
                    </tr>
                    <?php
                        else:
                            foreach ($produtos as $produto):
                        ?>
                    <tr>
                        <td><a
                                href="<?=$_SERVER["BASE_URL"]?>produto/detalhe/<?= $produto['id'] ?>"><?= $produto['name'] ?></a>
                        </td>
                        <td>R$ <?= number_format($produto['price'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($produto['date'])) ?></td>
                        <td><?= $produto['active'] ? 'Sim' : 'Não' ?></td>
                        <td><a href="<?=$_SERVER["BASE_URL"]?>produto/detalhe/<?= $produto['id'] ?>">Detalhe</a></td>
                        <td><a href="<?=$_SERVER["BASE_URL"]?>produto/editar/<?= $produto['id'] ?>">Editar</a></td>
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