<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Models\Entity\Produto;
use Fiado\Models\Service\ProdutoService;

class ProdutoController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getId();

        $data['produtos'] = array_map(fn(Produto $produto) => [
            'id' => $produto->getId(),
            'nome' => $produto->getName(),
            'preco' => $produto->getPrice(),
            'data' => $produto->getDate(),
            'ativo' => $produto->getActive(),
        ], ProdutoService::listProduto($idLoja, 0, 9) ?: []);
        $data['view'] = 'loja/produto/home';

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

        $form = Flash::getForm();

        $data = [
            'id' => $produto->getId(),
            'nome' => $form['ipt-nome'] ?? $produto->getName(),
            'preco' => $form['ipt-preco'] ?? $produto->getPrice(),
            'ativo' => $form['sel-ativo'] ?? $produto->getActive(),
            'descricao' => $form['txta-descricao'] ?? $produto->getDescription(),
        ];
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

        $data = [
            'nome' => $produto->getName(),
            'preco' => $produto->getPrice(),
            'data' => $produto->getDate(),
            'descricao' => $produto->getDescription(),
        ];
        $data['view'] = 'loja/produto/detail';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $form = new FormData();
        $idLoja = Auth::getId();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id', null);
        $form->setItem('name')->getValueFrom('ipt-nome', '');
        $form->setItem('price', FormDataType::Float)->getValueFrom('ipt-preco', 0);
        $form->setItem('active', FormDataType::YesNoInput)->getValueFrom('sel-ativo', true);
        $form->setItem('description')->getValueFrom('txta-descricao', '');

        Flash::setForm($form->getArray());

        if (ProdutoService::salvar($form->id, $idLoja, $form->name, $form->price, $form->active, $form->description)) {
            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        if ($form->id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto/editar/' . $form->id);
        }

        $this->redirect($_SERVER["BASE_URL"] . 'produto/novo');
    }

    public function listProdutoWithJSON()
    {
        $idLoja = Auth::getId();

        $form = new FormData();
        $form->setItem('text')->getValueFrom('texto', '');

        $produtos = ProdutoService::listProdutoWith($idLoja, $form->text, 10);

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