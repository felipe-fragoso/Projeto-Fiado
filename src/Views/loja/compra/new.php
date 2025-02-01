<main class="main-content-aside">
    <section class="system-section">
        <header class="form-header">
            <h2 class="page-header">Cadastro de Fiado</h2>
        </header>
        <form id="form-compra" method="POST" action="<?=$_SERVER["BASE_URL"]?>compra/salvar" class="form-box">
            <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
            <div class="full-input">
                <label for="sel-cliente">Cliente:</label>
                <select name="sel-cliente" id="sel-cliente" class="select-searchable">
                    <option value="" selected>Selecione um cliente...</option>
                    <?php
                        if ($data->listCliente):
                            foreach ($data->listCliente as $item):
                    ?>
                    <option value="<?=$item->id?>" <?=$flash?->form?->{'sel-cliente'} == $item->id ? 'selected' : ''?>>
                        <?=$item->nome?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </select>
            </div>
            <input type="hidden" name="ipt-list-produto" id="list-produto"
                value="<?=htmlentities(json_encode((array) $flash?->form?->{'ipt-list-produto'}))?>">
        </form>
    </section>
    <section class="system-section">
        <div class="add-fiado-btn-wrapper">
            <a href="javascript:;" onclick="showModal('modal-add-produto')" class="new-btn">
                Adicionar Produto
            </a>
            <input type="submit" value="Cadastrar" class="new-btn" form="form-compra">
        </div>
        <header class="section-header section-header-padding">
            <h3>Lista produtos</h3>
        </header>
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Qtde</th>
                        <th>Valor Total</th>
                        <th class="th-center" colspan="2">Opções</th>
                    </tr>
                </thead>
                <tbody id="tablelist-produto"></tbody>
            </table>
        </div>
    </section>
    <div id="modal-add-produto" class="full-modal">
        <div class="modal-content">
            <section>
                <header>
                    <h3>
                        Adicionar Produto
                    </h3>
                </header>
                <div class="form-box add-produto-box">
                    <div class="add-produto-search">
                        <label for="ipt-pesq">Produto:</label>
                        <input type="search" name="ipt-pesq" id="ipt-pesq" class="full-input">
                    </div>
                    <div class="table-box">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Valor</th>
                                    <th>Qtde</th>
                                    <th>Valor Total</th>
                                    <th class="th-center">Opções</th>
                                </tr>
                            </thead>
                            <tbody id="pesq-list"></tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section>
                <header class="section-header section-header-padding">
                    <h4>Lista de Produtos</h4>
                </header>
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Qtde</th>
                                <th>Valor Total</th>
                                <th class="th-center">Opções</th>
                            </tr>
                        </thead>
                        <tbody id="tablelist-produto-modal"></tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</main>
<script src="<?=$_SERVER["BASE_URL"]?>js/modal-produto.js"></script>
<script src="<?=$_SERVER["BASE_URL"]?>js/modal.js"></script>
<script src="<?=$_SERVER["BASE_URL"]?>js/searchable-select.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$_SERVER["BASE_URL"]?>css/searchable-select.css" />