const formatReal = (value) => {
    return Number(value).toLocaleString('pt-BR', { style: "currency", currency: "BRL" });
}

class ItemRowTable {
    constructor(cells) {
        this.cells = cells;
    }

    getItem() {
        let item = document.createElement('tr');

        this.cells.forEach(cell => {
            item.append(cell.getCell());
        });

        return item;
    }
}

class ItemCellTable {
    constructor(content, colspan) {
        this.content = content;
        this.colspan = colspan;
    }

    getCell() {
        let cell = document.createElement('td');
        cell.colSpan = this.colspan;

        cell.appendChild(this.content);

        return cell;
    }
}

class ProdutoTable {
    constructor() {
        this.listInput = document.getElementById('list-produto');
        this.list = this.getListProduto();
        this.searchList = [];
        this.total = 0.00;
    }

    createLink(name, url) {
        let link = document.createElement('a');
        link.href = url;
        link.target = '_blank';

        let span = this.createSpan(name);

        link.appendChild(span);

        return link;
    }

    createSpan(textContent, className = '') {
        let span = document.createElement('span');
        span.setAttribute('class', className);
        span.textContent = textContent;

        return span;
    }

    createInput(value, type, className, min = null, max = null, step = null) {
        let input = document.createElement('input');

        input.setAttribute('type', type || 'text');
        input.setAttribute('step', step || '');
        input.setAttribute('min', min || '');
        input.setAttribute('max', max || '');
        input.setAttribute('class', className);
        input.value = value;

        return input;
    }

    wrapInputWithLabel(label, input, className) {
        let div = document.createElement('div');
        div.setAttribute('class', className);

        let span = this.createSpan(label);

        div.append(span);
        div.append(input);

        return div;
    }

    getAddTable() {
        let rows = document.createDocumentFragment();

        this.searchList.forEach((produto) => {
            let cells = [];

            let precoInput = this.createInput(produto.preco, 'number', 'table-min-input', '0.01', '999', '0.01');
            let quantidadeInput = this.createInput(produto.quantidade || 1, 'number', '', '1', '999', '1')
            let total = this.createSpan(formatReal(precoInput.value * quantidadeInput.value));
            let addBtn = this.createInput('Adicionar', 'button', 'new-btn basic-btn');

            cells.push(new ItemCellTable(this.createLink(produto.nome, '/produto/detalhe/' + produto.idEncoded)));
            cells.push(new ItemCellTable(this.wrapInputWithLabel("R$", precoInput, "table-form-input")));
            cells.push(new ItemCellTable(quantidadeInput));
            cells.push(new ItemCellTable(total));
            cells.push(new ItemCellTable(addBtn));

            addBtn.addEventListener('click', () => this.addProduto(produto.id, produto.idEncoded, produto.nome, precoInput.value, quantidadeInput.value));
            precoInput.addEventListener('input', () => total.textContent = formatReal(precoInput.value * quantidadeInput.value));
            quantidadeInput.addEventListener('input', () => total.textContent = formatReal(precoInput.value * quantidadeInput.value));

            let item = new ItemRowTable(cells);

            rows.append(item.getItem());
        });

        return rows;
    }

    getDelTable() {
        let rows = document.createDocumentFragment();

        if (this.list.length < 1) {
            let row = new ItemRowTable([new ItemCellTable(this.createSpan('Nenhum produto registrado', 'full-span text-center'), 6)]);
            rows.append(row.getItem());
        }

        this.list.forEach((produto) => {
            let cells = [];

            let delBtn = this.createInput('Excluir', 'button', 'del-btn basic-btn');

            cells.push(new ItemCellTable(this.createLink(produto.nome, '/produto/detalhe/' + produto.idEncoded)));
            cells.push(new ItemCellTable(this.createSpan(formatReal(produto.preco))));
            cells.push(new ItemCellTable(this.createSpan(produto.quantidade)));
            cells.push(new ItemCellTable(this.createSpan(formatReal(produto.preco * produto.quantidade))));
            cells.push(new ItemCellTable(delBtn));

            delBtn.addEventListener('click', () => this.removeProduto(produto.id));

            let item = new ItemRowTable(cells);

            rows.append(item.getItem());
        });

        return rows;
    }

    getListTable() {
        let rows = document.createDocumentFragment();
        this.total = 0.0;

        if (this.list.length < 1) {
            let row = new ItemRowTable([new ItemCellTable(this.createSpan('Nenhum produto registrado', 'full-span text-center'), 6)]);
            rows.append(row.getItem());
        }

        this.list.forEach((produto) => {
            this.total += produto.preco * produto.quantidade;
            let cells = [];

            let editBtn = this.createInput('Editar', 'button', 'new-btn basic-btn');
            let delBtn = this.createInput('Excluir', 'button', 'del-btn basic-btn');

            cells.push(new ItemCellTable(this.createLink(produto.nome, '/produto/detalhe/' + produto.idEncoded)));
            cells.push(new ItemCellTable(this.createSpan(formatReal(produto.preco))));
            cells.push(new ItemCellTable(this.createSpan(produto.quantidade)));
            cells.push(new ItemCellTable(this.createSpan(formatReal(produto.preco * produto.quantidade))));
            cells.push(new ItemCellTable(editBtn));
            cells.push(new ItemCellTable(delBtn));

            editBtn.addEventListener('click', () => this.editProduto(produto.nome));
            delBtn.addEventListener('click', () => this.removeProduto(produto.id));

            let item = new ItemRowTable(cells);

            rows.append(item.getItem());
        });

        return rows;
    }

    updateTable(id, table) {
        let total = document.querySelectorAll('.list-produto-total');

        total.forEach((element) => {
            element.querySelector('span').textContent = this.total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        });

        let tBody = document.getElementById(id);
        tBody.innerHTML = "";

        tBody.appendChild(table);
    }

    updateSearchTable() {
        this.updateTable('pesq-list', this.getAddTable());
    }

    updateListTable() {
        this.updateTable('tablelist-produto', this.getListTable());
        this.updateTable('tablelist-produto-modal', this.getDelTable());
    }

    getListProduto() {
        if (this.listInput.value) {
            return JSON.parse(this.listInput.value);
        }

        return [];
    }

    updateListInput(list) {
        this.listInput.value = JSON.stringify(list);
        this.listInput.dispatchEvent(new Event('change', { bubbles: true }));
    }

    updateSearchList(list) {
        this.searchList = list;
        this.updateSearchTable();
    }

    addProduto(id, idEncoded, nome, preco, quantidade) {
        if (preco < 0.01 || quantidade < 1) {
            return;
        }

        let idx = this.list.findIndex((produto) => produto.id === id);

        if (idx !== -1) {
            this.list[idx].quantidade = Number(this.list[idx].quantidade) + Number(quantidade);
        } else {
            this.list.push({ id: id, idEncoded: idEncoded, nome: nome, preco: preco, quantidade: quantidade });
        }

        this.updateListInput(this.list);
        this.updateListTable();
    }

    editProduto(name) {
        let pesqInput = document.getElementById('ipt-pesq');
        pesqInput.value = name;
        this.searchProduto(name);

        showModal('modal-add-produto');
    }

    removeProduto(id) {
        let idx = this.list.findIndex((produto) => produto.id === id);

        if (idx !== -1) {
            this.list.splice(idx, 1);

            this.updateListInput(this.list);
        }

        this.updateListTable();
    }

    searchProduto(texto) {
        fetch('/produto/listProdutoWithJSON', {
            method: 'POST',
            body: "texto=" + texto,
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        }).then(response => response.json())
            .then(data => {
                this.updateSearchList(data);
            })
            .catch((e) => {
                console.warn('Warning: nenhum produto encontrado');
            });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    let timer = null;
    let tableManager = new ProdutoTable();
    let searchBar = document.getElementById('ipt-pesq');

    tableManager.updateListTable();

    searchBar.addEventListener('input', function (e) { delaySearch(e.target.value); });

    function delaySearch(texto) {
        clearTimeout(timer)

        timer = setTimeout(function () { tableManager.searchProduto(texto) }, 700);
    }
});