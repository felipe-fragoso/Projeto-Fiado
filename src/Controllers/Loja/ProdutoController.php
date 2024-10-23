<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Models\Service\ProdutoService;

class ProdutoController extends Controller
{
    public function index()
    {
        $data['view'] = 'loja/produto/home';
        $data['produtos'] = array_map(fn ($produto) => new ViewHelper($produto), ProdutoService::listProduto(0, 9));

        $this->load('loja/template', $data);
    }

    public function novo()
    {
        $data['view'] = 'loja/produto/new';

        $this->load('loja/template', $data);
    }

    /**
     * @param int $id
     */
    public function editar(int $id = null)
    {
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $data['produto'] = new ViewHelper(ProdutoService::getProduto($id));
        $data['view'] = 'loja/produto/edit';

        $this->load('loja/template', $data);
    }

    /**
     * @param int $id
     */
    public function detalhe(int $id = null)
    {
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $data['view'] = 'loja/produto/detail';
        $data['produto'] = new ViewHelper(ProdutoService::getProduto($id));

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $id = $_POST['ipt-id'] ?? null;
        $name = $_POST['ipt-nome'] ?? null;
        $price = $_POST['ipt-preco'] ?? null;
        $active = $_POST['sel-ativo'] ?? null;
        $active = ($active == 'S') ? true : false;
        $description = $_POST['txta-descricao'] ?? null;

        if (ProdutoService::salvar($id, $name, $price, $active, $description)) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        if ($id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto/editar/' . $id);
        }

        $this->redirect($_SERVER["BASE_URL"] . 'produto/novo');
    }
}