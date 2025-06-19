<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\InputType;
use Fiado\Helpers\FormData;
use Fiado\Helpers\Pagination;
use Fiado\Helpers\SqidsWrapper;
use Fiado\Helpers\StripeWrapper;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Entity\FiadoItem;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\FiadoItemService;

class CompraController extends Controller
{
    public function index()
    {
        $idCliente = Auth::getIdCliente();
        $cliente = ClienteService::getClienteById($idCliente);
        $form = new FormData();

        $form->setItem('search')->getValueFrom('q', null, InputType::Get);

        $page_url = $_SERVER["BASE_URL"] . 'compra' . $form->search ? "?q={$form->search}" : '';

        $pagination = new Pagination(CompraService::totalCompraCliente($cliente->getId(), $form->search), $page_url);

        $list = array_map(function (Fiado $item) {
            return [
                'id' => $item->getId(),
                'idLoja' => $item->getLoja()->getId(),
                'nome' => $item->getLoja()->getName(),
                'total' => $item->getTotal(),
                'data' => $item->getDate(),
                'pago' => $item->getPaid(),
            ];
        }, CompraService::listCompraCliente(
            $cliente->getId(),
            $pagination->getFirstItemIndex(),
            $pagination->getItensPerPage(),
            null,
            $form->search
        ) ?: []);

        $data = [
            'nome' => $cliente->getName(),
            'email' => $cliente->getEmail(),
            'esteMes' => CompraService::getTotalCliente($cliente->getId(), new \DateTime('first day of')) ?? 0,
            'total' => CompraService::getTotalCliente($cliente->getId(), 0) ?? 0,
            'pendente' => CompraService::getTotalCliente($cliente->getId(), 0, new \DateTime(), false) ?? 0,
            'vencido' => CompraService::getTotalCliente($cliente->getId(), 0, new \DateTime(), false, true) ?? 0,
            'list' => $list,
        ];
        $data['search'] = $form->search;
        $data['compraPagination'] = $pagination;
        $data['view'] = 'cliente/compra/home';

        $this->load('cliente/template', $data);
    }

    public function pendente()
    {
        $idCliente = Auth::getIdCliente();
        $cliente = ClienteService::getClienteById($idCliente);
        $form = new FormData();

        $form->setItem('search')->getValueFrom('q', null, InputType::Get);

        $page_url = $_SERVER["BASE_URL"] . 'compra' . $form->search ? "?q={$form->search}" : '';

        $pagination = new Pagination(CompraService::totalCompraPendenteCliente($idCliente, $form->search), $page_url);

        $list = array_map(function (Fiado $item) {
            return [
                'id' => $item->getId(),
                'idLoja' => $item->getLoja()->getId(),
                'nome' => $item->getLoja()->getName(),
                'total' => $item->getTotal(),
                'data' => $item->getDate(),
                'vencimento' => $item->getDueDate(),
            ];
        }, CompraService::listCompraPendenteCliente(
            $cliente->getId(),
            $pagination->getFirstItemIndex(),
            $pagination->getItensPerPage(),
            null,
            $form->search
        ) ?: []);

        $data = [
            'email' => $cliente->getEmail(),
            'nome' => $cliente->getName(),
            'esteMes' => CompraService::getTotalCliente($cliente->getId(), new \DateTime('first day of'), new \DateTime(), false) ?? 0,
            'vencido' => CompraService::getTotalCliente($cliente->getId(), 0, new \DateTime(), false, true) ?? 0,
            'total' => CompraService::getTotalCliente($cliente->getId(), 0, new \DateTime(), false) ?? 0,
            'list' => $list,
        ];
        $data['search'] = $form->search;
        $data['pendentePagination'] = $pagination;
        $data['view'] = 'cliente/compra/pending';

        $this->load('cliente/template', $data);
    }

    public function vencida()
    {
        $idCliente = Auth::getIdCliente();
        $cliente = ClienteService::getClienteById($idCliente);
        $form = new FormData();

        $form->setItem('search')->getValueFrom('q', null, InputType::Get);

        $page_url = $_SERVER["BASE_URL"] . 'compra' . $form->search ? "?q={$form->search}" : '';

        $pagination = new Pagination(CompraService::totalCompraVencidaCliente($idCliente, $form->search), $page_url);

        $list = array_map(function (Fiado $item) {
            return [
                'id' => $item->getId(),
                'idLoja' => $item->getLoja()->getId(),
                'nome' => $item->getLoja()->getName(),
                'total' => $item->getTotal(),
                'data' => $item->getDate(),
                'vencimento' => $item->getDueDate(),
            ];
        }, CompraService::listCompraVencidaCliente(
            $cliente->getId(),
            $pagination->getFirstItemIndex(),
            $pagination->getItensPerPage(),
            null,
            $form->search
        ) ?: []);

        $data = [
            'email' => $cliente->getEmail(),
            'nome' => $cliente->getName(),
            'esteMes' => CompraService::getTotalCliente($cliente->getId(), new \DateTime('first day of'), new \DateTime(), false, true) ?? 0,
            'total' => CompraService::getTotalCliente($cliente->getId(), 0, new \DateTime(), false, true) ?? 0,
            'list' => $list,
        ];
        $data['view'] = 'cliente/compra/overdue';
        $data['search'] = $form->search;
        $data['vencidaPagination'] = $pagination;

        $this->load('cliente/template', $data);
    }

    /**
     * @param $id
     */
    public function detalhe($id = null)
    {
        $id = SqidsWrapper::decode($id ?? '');

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $fiado = CompraService::getCompra($id);

        if (!$fiado) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $itensFiado = FiadoItemService::listFiadoItem($fiado->getId());

        $idCliente = $fiado->getCliente()->getId();

        if ($idCliente !== Auth::getIdCliente()) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $data = [
            'id' => $fiado->getId(),
            'idLoja' => $fiado->getLoja()->getId(),
            'loja' => $fiado->getLoja()->getName(),
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
        $data['view'] = 'cliente/compra/detail';

        $this->load('cliente/template', $data);
    }

    /**
     * @param $id
     */
    public function pagar($id = null)
    {
        $id = SqidsWrapper::decode($id ?? '');

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $fiado = CompraService::getCompra($id);

        if (!$fiado) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $invoice = StripeWrapper::getInvoice($fiado->getId());

        if (!$invoice) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $this->redirect($invoice->hosted_invoice_url);
    }
}