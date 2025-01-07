<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Enums\FormDataType;
use Fiado\Helpers\FormData;
use Fiado\Models\Entity\ClienteLoja;
use Fiado\Models\Service\ClienteLojaService;
use Fiado\Models\Service\ClientePIService;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\ConfigService;
use Fiado\Models\Service\LojaService;

class ClienteController extends Controller
{
    public function index()
    {
        $loja = LojaService::getLojaById(Auth::getId());

        $data['listData'] = array_map(function (ClienteLoja $clienteLoja) {return new ViewHelper([
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'ativo' => $clienteLoja->getActive(),
            'data' => $clienteLoja->getCliente()->getDate(),
        ]);}, ClienteLojaService::listClienteLoja($loja->getId()) ?: []);
        $data['view'] = 'loja/cliente/list';

        $this->load('loja/template', $data);
    }

    /**
     * @param int $id
     */
    public function ver(int $id = null)
    {
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clientePI = ClientePIService::getClientePI($clienteLoja->getCliente()->getId());
        $listCompra = CompraService::listCompraLojaCliente($clienteLoja->getLoja()->getId(), $clienteLoja->getCliente()->getId()) ?: [];

        $data['data'] = new ViewHelper([
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'telefone' => $clientePI ? $clientePI->getTelephone() : null,
            'list' => array_map(function ($compra) {return new ViewHelper([
                'id' => $compra->getId(),
                'valor' => $compra->getTotal(),
                'data' => $compra->getDate(),
                'pago' => $compra->getPaid(),
            ]);}, $listCompra),
        ]);
        $data['view'] = 'loja/cliente/home';

        $this->load('loja/template', $data);
    }

    /**
     * @param int $id
     */
    public function detalhe(int $id = null)
    {
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clientePI = ClientePIService::getClientePI($clienteLoja->getCliente()->getId());

        $data['data'] = new ViewHelper([
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'data' => $clienteLoja->getCliente()->getDate(),
            'telefone' => $clientePI ? $clientePI->getTelephone() : null,
            'endereco' => $clientePI ? $clientePI->getAddress() : null,
            'descricao' => $clientePI ? $clientePI->getDescription() : null,
        ]);
        $data['view'] = 'loja/cliente/detail';

        $this->load('loja/template', $data);
    }

    public function novo()
    {
        $data['tipo'] = $_GET['tipo'] ?? 'n';
        $data['view'] = 'loja/cliente/new';

        $this->load('loja/template', $data);
    }

    /**
     * @param int $id
     */
    public function editar(int $id = null)
    {
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $data['data'] = new ViewHelper([
            'id' => $clienteLoja->getId(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'creditoMaximo' => $clienteLoja->getMaxCredit() ?? 0,
            'ativo' => $clienteLoja->getActive(),
        ]);
        $data['tipo'] = $_GET['tipo'] ?? 'n';
        $data['view'] = 'loja/cliente/edit';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $form = new FormData();
        $idLoja = Auth::getId();
        $configLoja = ConfigService::getConfigByLoja($idLoja) ?: null;

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id');
        $form->setItem('name')->getValueFrom('ipt-nome');
        $form->setItem('email')->getValueFrom('ipt-email');
        $form->setItem('emailCliente')->getValueFrom('ipt-email-cliente');
        $form->setItem('cpf', FormDataType::Cpf)->getValueFrom('ipt-cpf');
        $form->setItem('phone', FormDataType::Telephone)->getValueFrom('ipt-tel');
        $form->setItem('address')->getValueFrom('ipt-endereco');

        $form->setItem('credit', FormDataType::Float)->getValueFrom('ipt-credito', $configLoja?->getMaxCredit());
        $form->setItem('active', FormDataType::YesNoInput)->getValueFrom('sel-ativo', true);

        $page = $form->id ? '/editar' : '/novo';
        $type = $form->emailCliente ? '?tipo=c' : '';
        $baseUrl = $_SERVER["BASE_URL"] . 'cliente';
        $backUrl = $baseUrl . $page . $type;

        if ($form->email && !$form->emailCliente && !$form->id) {
            if (!$idCliente = ClienteService::salvar(null, $form->cpf, $form->name, $form->email, null)) {
                $this->redirect($backUrl);
            }

            ClientePIService::salvar(null, $idCliente, $form->address, $form->phone, null);
        } elseif ($form->emailCliente && !$form->id) {
            if ($cliente = ClienteService::getClienteByEmail($form->emailCliente)) {
                $idCliente = $cliente->getId();
            }
        }

        if ($form->id) {
            $idCliente = ClienteLojaService::getClienteLojaById($form->id)->getCliente()->getId();
        }

        if (!isset($idCliente)) {
            $this->redirect($backUrl);
        }

        if (ClienteLojaService::salvar($form->id, $idLoja, $idCliente, $form->credit, $form->active)) {
            $this->redirect($baseUrl);
        }

        $this->redirect($backUrl);
    }
}