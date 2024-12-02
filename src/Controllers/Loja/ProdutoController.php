<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Models\Entity\Produto;
use Fiado\Models\Service\ProdutoService;

class ProdutoController extends Controller
{
    public function index()
    {
        $data['view'] = 'loja/produto/home';
        $data['produtos'] = array_map(fn(Produto $produto) => new ViewHelper([
            'id' => $produto->getId(),
            'nome' => $produto->getName(),
            'preco' => $produto->getPrice(),
            'data' => $produto->getDate(),
            'ativo' => $produto->getActive(),
        ]), ProdutoService::listProduto(0, 9) ?: []);

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

        $produto = ProdutoService::getProduto($id);

        if (!$produto) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $data['data'] = new ViewHelper([
            'id' => $produto->getId(),
            'nome' => $produto->getName(),
            'preco' => $produto->getPrice(),
            'ativo' => $produto->getActive(),
            'descricao' => $produto->getDescription(),
        ]);
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

        $produto = ProdutoService::getProduto($id);

        if (!$produto) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $data['view'] = 'loja/produto/detail';
        $data['data'] = new ViewHelper([
            'nome' => $produto->getName(),
            'preco' => $produto->getPrice(),
            'data' => $produto->getDate(),
            'descricao' => $produto->getDescription(),
        ]);

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

        $idLoja = Auth::getId();

        if (ProdutoService::salvar($id, $idLoja, $name, $price, $active, $description)) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        if ($id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto/editar/' . $id);
        }

        $this->redirect($_SERVER["BASE_URL"] . 'produto/novo');
    }

    public function listProdutoWithJSON()
    {
        $text = $_POST['texto'] ?? "";

        $produtos = ProdutoService::listProdutoWith($text, 10);

        if ($produtos) {
            $list = array_map(function (Produto $item) {
                return [
                    'id' => $item->getId(),
                    'nome' => $item->getName(),
                    'preco' => $item->getPrice(),
                ];
            }, $produtos);

            echo json_encode($list);
        }
    }
}