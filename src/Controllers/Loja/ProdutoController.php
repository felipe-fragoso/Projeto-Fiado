<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Enums\InputType;
use Fiado\Enums\MessageType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Helpers\Pagination;
use Fiado\Helpers\SqidsWrapper;
use Fiado\Models\Entity\Produto;
use Fiado\Models\Service\ProdutoService;

class ProdutoController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getIdLoja();
        $form = new FormData();

        $form->setItem('search')->getValueFrom('q', null, InputType::Get);

        $page_url = $_SERVER["BASE_URL"] . 'produto' . $form->search ? "?q={$form->search}" : '';

        $pagination = new Pagination(ProdutoService::totalProduto($idLoja, $form->search), $page_url);

        $data['produtos'] = array_map(fn(Produto $produto) => [
            'id' => $produto->getId(),
            'nome' => $produto->getName(),
            'preco' => $produto->getPrice(),
            'data' => $produto->getDate(),
            'ativo' => $produto->getActive(),
        ], ProdutoService::listProduto($idLoja, $pagination->getFirstItemIndex(), $pagination->getItensPerPage(), null, $form->search) ?: []);
        $data['produtoPagination'] = $pagination;
        $data['search'] = $form->search;
        $data['view'] = 'loja/produto/home';

        $this->load('loja/template', $data);
    }

    public function novo()
    {
        $data['view'] = 'loja/produto/new';

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function editar($id = null)
    {
        $id = SqidsWrapper::decode($id);

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $produto = ProdutoService::getProduto($id);

        if (!$produto || $produto->getLoja()->getId() !== Auth::getIdLoja()) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $form = Flash::getForm();

        $data = [
            'id' => $produto->getId(),
            'nome' => $form['ipt-nome'] ?? $produto->getName(),
            'preco' => $form['ipt-preco'] ?? $produto->getPrice(),
            'ativo' => $form['sel-ativo'] ?? $produto->getActive(),
            'descricao' => $form['txta-descricao'] ?? $produto->getDescription(),
            'tokenData' => $produto->getId(),
        ];
        $data['view'] = 'loja/produto/edit';

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function detalhe($id = null)
    {
        $id = SqidsWrapper::decode($id);

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $produto = ProdutoService::getProduto($id);

        if (!$produto || $produto->getLoja()->getId() !== Auth::getIdLoja()) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        $data = [
            'nome' => $produto->getName(),
            'preco' => $produto->getPrice(),
            'data' => $produto->getDate(),
            'descricao' => $produto->getDescription() ?: 'Sem descrição',
        ];
        $data['view'] = 'loja/produto/detail';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $form = new FormData();
        $idLoja = Auth::getIdLoja();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id', null);
        $form->setItem('name')->getValueFrom('ipt-nome', '');
        $form->setItem('price', FormDataType::Float)->getValueFrom('ipt-preco', 0);
        $form->setItem('active', FormDataType::YesNoInput)->getValueFrom('sel-ativo', true);
        $form->setItem('description')->getValueFrom('txta-descricao', '');

        $this->checkToken($_SERVER["BASE_URL"] . 'produto', $form->id);

        Flash::setForm($form->getArray());

        if ($rowCount = ProdutoService::salvar($form->id, $idLoja, $form->name, $form->price, $form->active, $form->description)) {
            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($_SERVER["BASE_URL"] . 'produto');
        }

        if ($rowCount === 0) {
            Flash::setMessage('Nenhum registro alterado', MessageType::Warning);
        }

        if ($form->id) {
            $this->redirect($_SERVER["BASE_URL"] . 'produto/editar/' . SqidsWrapper::encode($form->id));
        }

        $this->redirect($_SERVER["BASE_URL"] . 'produto/novo');
    }

    public function listProdutoWithJSON()
    {
        $idLoja = Auth::getIdLoja();

        $form = new FormData();
        $form->setItem('text')->getValueFrom('texto', '');

        $produtos = ProdutoService::listProduto($idLoja, 0, 10, true, $form->text);

        if ($produtos) {
            $list = array_map(function (Produto $item) {
                return [
                    'id' => $item->getId(),
                    'idEncoded' => SqidsWrapper::encode($item->getId()),
                    'nome' => $item->getName(),
                    'preco' => $item->getPrice(),
                ];
            }, $produtos);

            echo json_encode($list);
        }
    }
}