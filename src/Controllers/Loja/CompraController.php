<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
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
        $loja = LojaService::getLojaById(Auth::getId());

        $list = array_map(function (Fiado $item) {
            $clienteLoja = ClienteLojaService::getClienteLoja($item->getLoja()->getId(), $item->getCliente()->getId());

            return new ViewHelper([
                'id' => $item->getId(),
                'idClienteLoja' => $clienteLoja->getId(),
                'nome' => $item->getCliente()->getName(),
                'total' => $item->getTotal(),
                'data' => $item->getDate(),
                'pago' => $item->getPaid(),
            ]);
        }, CompraService::listCompraLoja($loja->getId()) ?: []);

        $data['data'] = new ViewHelper([
            'email' => $loja->getEmail(),
            'nome' => $loja->getName(),
            'esteMes' => CompraService::getTotal($loja->getId(), new \DateTime('first day of')),
            'total' => CompraService::getTotal($loja->getId(), 0),
            'pendente' => CompraService::getTotal($loja->getId(), 0, new \DateTime(), false),
            'list' => $list,
        ]);
        $data['view'] = 'loja/compra/home';

        $this->load('loja/template', $data);
    }

    public function pendente()
    {
        $loja = LojaService::getLojaById(Auth::getId());
        
        $data['data'] = new ViewHelper([
            'email' => $loja->getEmail(),
            'nome' => $loja->getName(),
            'esteMes' => CompraService::getTotal($loja->getId(), new \DateTime('first day of'), new \DateTime(), false),
            'total' => CompraService::getTotal($loja->getId(), 0, new \DateTime(), false),
            'list' => array_map(function (Fiado $item) {
                $clienteLoja = ClienteLojaService::getClienteLoja($item->getLoja()->getId(), $item->getCliente()->getId());

                return new ViewHelper([
                    'id' => $item->getId(),
                    'idCliente' => $clienteLoja->getId(),
                    'nome' => $item->getCliente()->getName(),
                    'total' => $item->getTotal(),
                    'data' => $item->getDate(),
                    'vencimento' => $item->getDueDate(),
                ]);
            }, CompraService::listCompraPendenteLoja($loja->getId()) ?: []),
        ]);
        $data['view'] = 'loja/compra/pending';

        $this->load('loja/template', $data);
    }

    /**
     * @param int $id
     */
    public function detalhe(int $id = null)
    {
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $fiado = CompraService::getCompra($id);

        if (!$fiado) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $itensFiado = FiadoItemService::listFiadoItem($fiado->getId());

        $data['data'] = new ViewHelper([
            'total' => $fiado->getTotal(),
            'data' => $fiado->getDate(),
            'dataVencimento' => $fiado->getDueDate(),
            'pago' => $fiado->getPaid(),
            'itens' => array_map(function (FiadoItem $item) {return new ViewHelper([
                'idProduto' => $item->getProduto()->getId(),
                'nomeProduto' => $item->getProduto()->getName(),
                'preco' => $item->getValue(),
                'quantidade' => $item->getQuantity(),
                'subtotal' => $item->getQuantity() * $item->getValue(),
            ]);}, $itensFiado ?: []),
        ]);
        $data['view'] = 'loja/compra/detail';

        $this->load('loja/template', $data);
    }

    public function nova()
    {
        $data['data'] = new ViewHelper([
            'listCliente' => array_map(function (ClienteLoja $item) {return new ViewHelper([
                'id' => $item->getCliente()->getId(),
                'nome' => $item->getCliente()->getName(),
            ]);}, ClienteLojaService::listClienteLoja(Auth::getId()) ?: []),
        ]);
        $data['view'] = 'loja/compra/new';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $idCliente = $_POST['sel-cliente'] ?? null;
        $listProduto = $_POST['ipt-list-produto'] ?? null;

        $idLoja = Auth::getId();
        $configLoja = ConfigService::getConfigByLoja($idLoja) ?: null;
        $payLimit = $configLoja?->getPayLimit() ?? 0;

        $id = null;
        $date = date('Y-m-d H:i:s');
        $paid = false;
        $dueDate = new \DateTime();
        $listProduto = $listProduto ? json_decode($listProduto) : [];
        $dueDate = $dueDate->modify("+{$payLimit} day")->format('Y-m-d H:i:s');

        if (!$idCliente || !$listProduto) {
            $this->redirect($_SERVER["BASE_URL"] . 'compra/nova');
        }

        $total = 0;
        foreach ($listProduto as $produto) {
            $total += $produto->preco * $produto->quantidade;
        }

        if ($idFiado = CompraService::salvar($id, $idCliente, $idLoja, $total, $date, $dueDate, $paid)) {
            foreach ($listProduto as $item) {
                FiadoItemService::salvar(null, $idFiado, $item->id, $item->preco, $item->quantidade);
            }

            $this->redirect($_SERVER["BASE_URL"] . 'compra');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'compra/nova');
    }
}