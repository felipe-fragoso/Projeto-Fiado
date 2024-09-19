<main class="main-content-aside">
    <section class="system-section">
        <header class="form-header">
            <h2 class="page-header">Cadastro de Fiado</h2>
        </header>
        <form id="form-compra" method="post" action="/loja/compraSalvar" class="form-box">
            <div class="full-input">
                <label for="sel-cliente">Cliente:</label>
                <select name="sel-cliente" id="sel-cliente" class="select-searchable">
                    <option value="" selected>Selecione um cliente...</option>
                    <option value="1">Nome Cliente 1</option>
                    <option value="3">Nome Cliente 2</option>
                    <option value="2">Nome Cliente 3</option>
                </select>
            </div>
        </form>
    </section>
    <section class="system-section table-box">
        <div class="add-fiado-btn-wrapper">
            <a href="javascript:;" onclick="showModal('modal-add-produto')" class="new-btn">
                Adicionar Produto
            </a>
            <input type="submit" value="Cadastrar" class="new-btn" form="form-compra">
        </div>
        <header class="section-header section-header-padding">
            <h3>Lista produtos</h3>
        </header>
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
            <tbody>
                <tr>
                    <td><a href="/loja/produtoDetalhe">Nome Produto</a></td>
                    <td>R$ xx,xx</td>
                    <td>xx</td>
                    <td>R$ xxx,xx</td>
                    <td><a href="">Editar</a></td>
                    <td><a href="">Excluir</a></td>
                </tr>
                <tr>
                    <td><a href="/loja/produtoDetalhe">Nome Produto</a></td>
                    <td>R$ xx,xx</td>
                    <td>xx</td>
                    <td>R$ xxx,xx</td>
                    <td><a href="">Editar</a></td>
                    <td><a href="">Excluir</a></td>
                </tr>
                <tr>
                    <td><a href="/loja/produtoDetalhe">Nome Produto</a></td>
                    <td>R$ xx,xx</td>
                    <td>xx</td>
                    <td>R$ xxx,xx</td>
                    <td><a href="">Editar</a></td>
                    <td><a href="">Excluir</a></td>
                </tr>
            </tbody>
        </table>
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
                        <input type="search" name="ipt-pesq" id="ipt-pesq" class="full-input" value="Produto">
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
                            <tbody>
                                <tr>
                                    <td><a href="/loja/produtoDetalhe">Nome Produto</a></td>
                                    <td>
                                        <div class="table-form-input">
                                            <span>R$</span>
                                            <input type="number" value="1" step="0.01" min="1" max="999"
                                                class="table-min-input">
                                        </div>
                                    </td>
                                    <td><input type="number" value="1" min="1" max="999"></td>
                                    <td>R$ xxx,xx</td>
                                    <td>
                                        <input type="button" name="" id="" class="new-btn basic-btn" value="Adicionar">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="table-box">
                <header class="section-header section-header-padding">
                    <h4>Lista de Produtos</h4>
                </header>
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
                    <tbody>
                        <tr>
                            <td><a href="/loja/produtoDetalhe">Nome Produto</a></td>
                            <td>R$ xx,xx</td>
                            <td>xx</td>
                            <td>R$ xxx,xx</td>
                            <td>
                                <input type="button" name="" id="" class="del-btn basic-btn" value="Excluir">
                            </td>
                        </tr>
                        <tr>
                            <td><a href="/loja/produtoDetalhe">Nome Produto</a></td>
                            <td>R$ xx,xx</td>
                            <td>xx</td>
                            <td>R$ xxx,xx</td>
                            <td>
                                <input type="button" name="" id="" class="del-btn basic-btn" value="Excluir">
                            </td>
                        </tr>
                        <tr>
                            <td><a href="/loja/produtoDetalhe">Nome Produto</a></td>
                            <td>R$ xx,xx</td>
                            <td>xx</td>
                            <td>R$ xxx,xx</td>
                            <td>
                                <input type="button" name="" id="" class="del-btn basic-btn" value="Excluir">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
<script src="../js/modal.js"></script>
<script src="../js/searchable-select.js"></script>
<link rel="stylesheet" type="text/css" href="../css/searchable-select.css" />