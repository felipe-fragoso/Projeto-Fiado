<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Graph\BarGraph;
use Fiado\Graph\GetCompraGraph;
use Fiado\Graph\IntervalGraphType;
use Fiado\Models\Entity\Fiado;
use Fiado\Models\Service\CompraService;

class HomeController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getId();
        $UltimasCompras = CompraService::listCompraLoja($idLoja);
        $UltimasPendentes = CompraService::listCompraPendenteLoja($idLoja);

        $dayGraph = new BarGraph(new GetCompraGraph($idLoja), IntervalGraphType::Day);
        $monthGraphPending = new BarGraph(new GetCompraGraph($idLoja, false));
        $monthGraph = new BarGraph(new GetCompraGraph($idLoja));

        $dados['view'] = 'loja/home';
        $dados['data'] = new ViewHelper([
            'ultimasCompras' => array_map(function (Fiado $compra) {
                return new ViewHelper([
                    'id' => $compra->getId(),
                    'total' => $compra->getTotal(),
                    'data' => $compra->getDate(),
                    'pago' => $compra->getPaid(),
                ]);
            }, $UltimasCompras ?: []),
            'ultimasPendentes' => array_map(function (Fiado $compra) {
                return new ViewHelper([
                    'id' => $compra->getId(),
                    'total' => $compra->getTotal(),
                    'data' => $compra->getDate(),
                ]);
            }, $UltimasPendentes ?: []),
            'graficos' => new ViewHelper([
                'dias' => ($dayGraph->getGraph)(5),
                'mes' => ($monthGraph->getGraph)(5),
                'mesPendente' => ($monthGraphPending->getGraph)(5),
            ]),
        ]);

        $this->load('loja/template', $dados);
    }
}