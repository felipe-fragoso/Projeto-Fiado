<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Graph\BarGraph;
use Fiado\Graph\GetCompraLojaGraph;
use Fiado\Graph\IntervalGraphType;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Service\CompraService;

class HomeController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getIdLoja();
        $ultimasCompras = CompraService::listCompraLoja($idLoja, 0, 10);
        $ultimasPendentes = CompraService::listCompraPendenteLoja($idLoja, 0, 10);

        $dayGraph = new BarGraph(new GetCompraLojaGraph($idLoja), IntervalGraphType::Day);
        $monthGraphPending = new BarGraph(new GetCompraLojaGraph($idLoja, false));
        $monthGraph = new BarGraph(new GetCompraLojaGraph($idLoja));

        $data = [
            'ultimasCompras' => array_map(fn(Fiado $compra) => [
                'id' => $compra->getId(),
                'total' => $compra->getTotal(),
                'data' => $compra->getDate(),
                'pago' => $compra->getPaid(),
            ], $ultimasCompras ?: []),
            'ultimasPendentes' => array_map(fn(Fiado $compra) => [
                'id' => $compra->getId(),
                'total' => $compra->getTotal(),
                'data' => $compra->getDate(),
            ], $ultimasPendentes ?: []),
            'graficos' => [
                'dias' => ($dayGraph->getGraph)(5),
                'mes' => ($monthGraph->getGraph)(5),
                'mesPendente' => ($monthGraphPending->getGraph)(5),
            ],
        ];
        $data['view'] = 'loja/home';

        $this->load('loja/template', $data);
    }
}