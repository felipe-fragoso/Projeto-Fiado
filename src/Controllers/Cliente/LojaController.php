<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Helpers\SqidsWrapper;
use Fiado\Models\Entity\LojaPI;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\LojaPiService;
use Fiado\Models\Service\LojaService;

class LojaController extends Controller
{
    /**
     * @param $idLoja
     */
    public function index($idLoja = null)
    {
        $idUser = Auth::getIdCliente();

        if (!$idLoja || !$idUser) {
            $this->redirect($_SERVER["BASE_URL"]);
        }

        $idLoja = SqidsWrapper::decode($idLoja);
        $lojaPI = LojaPiService::getLojaPiByLoja($idLoja);
        $listCompra = CompraService::listCompraLojaCliente($idLoja, $idUser) ?: [];

        if (!$lojaPI) {
            $lojaPI = new LojaPI(
                null,
                LojaService::getLojaById($idLoja),
                'Endereço vazio',
                'Telefone vazio',
                '',
                '',
                '',
                '',
            );
        }

        $data = [
            'id' => $lojaPI->getId(),
            'nome' => $lojaPI->getLoja()?->getName(),
            'endereco' => $lojaPI->getAddress(),
            'telefone' => $lojaPI->getTelephone(),
            'list' => array_map(fn($compra) => [
                'id' => $compra->getId(),
                'valor' => $compra->getTotal(),
                'data' => $compra->getDate(),
                'pago' => $compra->getPaid(),
            ], $listCompra),
        ];

        $data['view'] = 'cliente/loja/home';

        $this->load('cliente/template', $data);
    }

    /**
     * @param $idLoja
     */
    public function detalhe($idLoja = null)
    {
        if (!$idLoja) {
            $this->redirect($_SERVER["BASE_URL"]);
        }

        $idLoja = SqidsWrapper::decode($idLoja);
        $lojaPI = LojaPiService::getLojaPiByLoja($idLoja);

        if (!$lojaPI) {
            $lojaPI = new LojaPI(
                null,
                LojaService::getLojaById($idLoja),
                'Endereço vazio',
                'Telefone vazio',
                'Descrição vazia',
                '',
                '00:00',
                '00:00'
            );
        }

        $data = [
            'nome' => $lojaPI->getLoja()->getName(),
            'email' => $lojaPI->getLoja()->getEmail(),
            'cnpj' => $lojaPI->getLoja()->getCnpj(),
            'endereco' => $lojaPI->getAddress(),
            'telefone' => $lojaPI->getTelephone(),
            'data' => $lojaPI->getEstablished(),
            'abre' => $lojaPI->getOpenHour(),
            'fecha' => $lojaPI->getCloseHour(),
            'descricao' => $lojaPI->getDescription(),
        ];
        $data['view'] = 'cliente/loja/detail';

        $this->load('cliente/template', $data);
    }
}