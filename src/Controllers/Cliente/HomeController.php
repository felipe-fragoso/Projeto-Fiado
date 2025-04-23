<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Graph\BarGraph;
use Fiado\Graph\GetCompraClienteGraph;
use Fiado\Graph\IntervalGraphType;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Service\CompraService;

class HomeController extends Controller
{
    public function index()
    {
        $idCliente = Auth::getIdCliente();
        $ultimasCompras = CompraService::listCompraCliente($idCliente, 0, 10);
        $ultimasPendentes = CompraService::listCompraPendenteCliente($idCliente, 0, 10);

        $dayGraph = new BarGraph(new GetCompraClienteGraph($idCliente), IntervalGraphType::Day);
        $monthGraphPending = new BarGraph(new GetCompraClienteGraph($idCliente, false));
        $monthGraph = new BarGraph(new GetCompraClienteGraph($idCliente));

        $data = [
            'ultimasCompras' => array_map(fn(Fiado $compra) => [
                'id' => $compra->getId(),
                'total' => $compra->getTotal(),
                'data' => $compra->getDate(),
                'loja' => $compra->getLoja()->getName(),
                'pago' => $compra->getPaid(),
            ], $ultimasCompras ?: []),
            'ultimasPendentes' => array_map(fn(Fiado $compra) => [
                'id' => $compra->getId(),
                'total' => $compra->getTotal(),
                'data' => $compra->getDate(),
                'loja' => $compra->getLoja()->getName(),
            ], $ultimasPendentes ?: []),
            'graficos' => [
                'dias' => ($dayGraph->getGraph)(5),
                'mes' => ($monthGraph->getGraph)(5),
                'mesPendente' => ($monthGraphPending->getGraph)(5),
            ],
        ];
        $data['view'] = 'cliente/home';

        $this->load('cliente/template', $data);
    }
}