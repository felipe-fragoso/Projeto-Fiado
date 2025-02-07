<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Enums\InputType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Helpers\Pagination;
use Fiado\Helpers\SqidsWrapper;
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
        $idLoja = Auth::getId();
        $pagination = new Pagination(ClienteLojaService::totalClienteLoja($idLoja), $_SERVER["BASE_URL"] . 'cliente');
        $loja = LojaService::getLojaById($idLoja);

        $data['list'] = array_map(fn(ClienteLoja $clienteLoja) => [
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'ativo' => $clienteLoja->getActive(),
            'data' => $clienteLoja->getCliente()->getDate(),
        ], ClienteLojaService::listClienteLoja($loja->getId(), $pagination->getFirstItemIndex(), $pagination->getItensPerPage()) ?: []);
        $data['view'] = 'loja/cliente/list';
        $data['clientePagination'] = $pagination;

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function ver($id = null)
    {
        $id = SqidsWrapper::decode($id);

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clientePI = ClientePIService::getClientePI($clienteLoja->getCliente()->getId()) ?: null;
        $listCompra = CompraService::listCompraLojaCliente($clienteLoja->getLoja()->getId(), $clienteLoja->getCliente()->getId()) ?: [];

        $data = [
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'telefone' => $clientePI?->getTelephone() ?? 'Telefone vazio',
            'list' => array_map(fn($compra) => [
                'id' => $compra->getId(),
                'valor' => $compra->getTotal(),
                'data' => $compra->getDate(),
                'pago' => $compra->getPaid(),
            ], $listCompra),
        ];
        $data['view'] = 'loja/cliente/home';

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function detalhe($id = null)
    {
        $id = SqidsWrapper::decode($id);

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clientePI = ClientePIService::getClientePI($clienteLoja->getCliente()->getId()) ?: null;

        $data = [
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'data' => $clienteLoja->getCliente()->getDate(),
            'telefone' => $clientePI?->getTelephone() ?? 'Telefone vazio',
            'endereco' => $clientePI?->getAddress() ?? 'Endereço vazio',
            'descricao' => $clientePI?->getDescription() ?? 'Descrição vazia',
        ];
        $data['view'] = 'loja/cliente/detail';

        $this->load('loja/template', $data);
    }

    public function novo()
    {
        $form = new FormData();
        $form->setItem('type')->getValueFrom('tipo', 'n', InputType::Get);

        $data['tipo'] = $form->type;
        $data['view'] = 'loja/cliente/new';

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function editar($id = null)
    {
        $id = SqidsWrapper::decode($id);

        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $form = Flash::getForm();

        $data = [
            'id' => $clienteLoja->getId(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'creditoMaximo' => $form['ipt-credito'] ?? $clienteLoja->getMaxCredit() ?? 0,
            'ativo' => $form['sel-ativo'] ?? $clienteLoja->getActive(),
        ];
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
        $form->setItem('type')->getValueFrom('ipt-tipo', 'n');

        $form->setItem('credit', FormDataType::Float)->getValueFrom('ipt-credito', $configLoja?->getMaxCredit());
        $form->setItem('active', FormDataType::YesNoInput)->getValueFrom('sel-ativo', true);

        Flash::setForm($form->getArray());

        $page = $form->id ? '/editar/' . SqidsWrapper::encode($form->id) : '/novo';
        $type = $form->id ? '' : '?tipo=' . $form->type;
        $baseUrl = $_SERVER["BASE_URL"] . 'cliente';
        $backUrl = $baseUrl . $page . $type;

        if (($form->type == 'n') && !$form->id) {
            $idCliente = ClienteService::salvar(null, $form->cpf, $form->name, $form->email, null, null);

            ClientePIService::salvar(null, $idCliente, $form->address, $form->phone, null);
        }

        if (($form->type == 'c') && !$form->id) {
            if ($cliente = ClienteService::getClienteByEmail($form->emailCliente)) {
                $idCliente = $cliente->getId();
            }
        }

        if ($form->id) {
            $idCliente = ClienteLojaService::getClienteLojaById($form->id)->getCliente()->getId();
        }

        if (ClienteLojaService::salvar($form->id, $idLoja, $idCliente ?? 0, $form->credit, $form->active)) {
            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($baseUrl);
        }

        $this->redirect($backUrl);
    }
}