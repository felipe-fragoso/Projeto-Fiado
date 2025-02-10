<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Helpers\Pagination;
use Fiado\Helpers\SqidsWrapper;
use Fiado\Models\Entity\ClienteLoja;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Entity\FiadoItem;
use Fiado\Models\Service\ClienteLojaService;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\ConfigService;
use Fiado\Models\Service\FiadoItemService;
use Fiado\Models\Service\LojaService;

class CompraController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getId();
        $loja = LojaService::getLojaById($idLoja);
        $pagination = new Pagination(CompraService::totalCompraLoja($idLoja), $_SERVER["BASE_URL"] . 'compra');

        $list = array_map(function (Fiado $item) {
            $clienteLoja = ClienteLojaService::getClienteLoja($item->getLoja()->getId(), $item->getCliente()->getId());

            return [
                'id' => $item->getId(),
                'idClienteLoja' => $clienteLoja->getId(),
                'nome' => $item->getCliente()->getName(),
                'total' => $item->getTotal(),
                'data' => $item->getDate(),
                'pago' => $item->getPaid(),
            ];
        }, CompraService::listCompraLoja($loja->getId(), $pagination->getFirstItemIndex(), $pagination->getItensPerPage()) ?: []);

        $data = [
            'email' => $loja->getEmail(),
            'nome' => $loja->getName(),
            'esteMes' => CompraService::getTotal($loja->getId(), new \DateTime('first day of')) ?? 0,
            'total' => CompraService::getTotal($loja->getId(), 0) ?? 0,
            'pendente' => CompraService::getTotal($loja->getId(), 0, new \DateTime(), false) ?? 0,
            'list' => $list,
        ];
        $data['view'] = 'loja/compra/home';
        $data['compraPagination'] = $pagination;

        $this->load('loja/template', $data);
    }

    public function pendente()
    {
        $idLoja = Auth::getId();
        $loja = LojaService::getLojaById($idLoja);
        $pagination = new Pagination(CompraService::totalCompraPendenteLoja($idLoja), $_SERVER["BASE_URL"] . 'compra/pendente');

        $data = [
            'email' => $loja->getEmail(),
            'nome' => $loja->getName(),
            'esteMes' => CompraService::getTotal($loja->getId(), new \DateTime('first day of'), new \DateTime(), false) ?? 0,
            'total' => CompraService::getTotal($loja->getId(), 0, new \DateTime(), false) ?? 0,
            'list' => array_map(function (Fiado $item) {
                $clienteLoja = ClienteLojaService::getClienteLoja($item->getLoja()->getId(), $item->getCliente()->getId());

                return [
                    'id' => $item->getId(),
                    'idCliente' => $clienteLoja->getId(),
                    'nome' => $item->getCliente()->getName(),
                    'total' => $item->getTotal(),
                    'data' => $item->getDate(),
                    'vencimento' => $item->getDueDate(),
                ];
            }, CompraService::listCompraPendenteLoja($loja->getId(), $pagination->getFirstItemIndex(), $pagination->getItensPerPage()) ?: []),
        ];
        $data['view'] = 'loja/compra/pending';
        $data['pendentePagination'] = $pagination;

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function detalhe($id = null)
    {
        $id = SqidsWrapper::decode($id);

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $fiado = CompraService::getCompra($id);

        if (!$fiado) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $itensFiado = FiadoItemService::listFiadoItem($fiado->getId());

        $data = [
            'total' => $fiado->getTotal(),
            'data' => $fiado->getDate(),
            'dataVencimento' => $fiado->getDueDate(),
            'pago' => $fiado->getPaid(),
            'itens' => array_map(fn(FiadoItem $item) => [
                'idProduto' => $item->getProduto()->getId(),
                'nomeProduto' => $item->getProduto()->getName(),
                'preco' => $item->getValue(),
                'quantidade' => $item->getQuantity(),
                'subtotal' => $item->getQuantity() * $item->getValue(),
            ], $itensFiado ?: []),
        ];
        $data['view'] = 'loja/compra/detail';

        $this->load('loja/template', $data);
    }

    public function nova()
    {
        $data = [
            'listCliente' => array_map(fn(ClienteLoja $item) => [
                'id' => $item->getCliente()->getId(),
                'nome' => $item->getCliente()->getName(),
            ], ClienteLojaService::listClienteLoja(Auth::getId(), 0, 9) ?: []),
        ];
        $data['view'] = 'loja/compra/new';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $this->checkToken($_SERVER["BASE_URL"] . 'compra');

        $idLoja = Auth::getId();
        $configLoja = ConfigService::getConfigByLoja($idLoja) ?: null;

        $form = new FormData();

        $form->setItem('idCliente', FormDataType::Int)->getValueFrom('sel-cliente', 0);
        $form->setItem('listProduto', FormDataType::JsonText)->getValueFrom('ipt-list-produto', []);

        Flash::setForm($form->getArray());

        $payLimit = $configLoja?->getPayLimit() ?? 0;

        $id = null;
        $date = date('Y-m-d H:i:s');
        $paid = false;
        $dueDate = new \DateTime();
        $dueDate = $dueDate->modify("+{$payLimit} day")->format('Y-m-d H:i:s');

        $total = 0;
        foreach ($form->listProduto as $produto) {
            $total += $produto->preco * $produto->quantidade;
        }

        if ($idFiado = CompraService::salvar($id, $form->idCliente, $idLoja, $total, $date, $dueDate, $paid)) {
            foreach ($form->listProduto as $item) {
                FiadoItemService::salvar(null, $idFiado, $item->id, $item->preco, $item->quantidade);
            }

            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'compra/nova');
    }
}