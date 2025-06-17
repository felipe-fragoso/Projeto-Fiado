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
use Fiado\Models\Entity\ClienteLoja;
use Fiado\Models\Service\ClienteLojaService;
use Fiado\Models\Service\ClientePIService;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\CompraService;
use Fiado\Models\Service\ConfigService;

class ClienteController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getIdLoja();
        $form = new FormData();

        $form->setItem('search')->getValueFrom('q', null, InputType::Get);

        $page_url = $_SERVER["BASE_URL"] . 'cliente' . $form->search ? "?q={$form->search}" : '';

        $pagination = new Pagination(ClienteLojaService::totalClienteLoja($idLoja, $form->search), $page_url);

        $data['list'] = array_map(fn(ClienteLoja $clienteLoja) => [
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'ativo' => $clienteLoja->getActive(),
            'data' => $clienteLoja->getCliente()->getDate(),
        ], ClienteLojaService::listClienteLoja($idLoja, $pagination->getFirstItemIndex(), $pagination->getItensPerPage(), null, $form->search) ?: []);
        $data['view'] = 'loja/cliente/list';
        $data['search'] = $form->search;
        $data['clientePagination'] = $pagination;

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function ver($idClienteLoja = null)
    {
        $idLoja = Auth::getIdLoja();

        if (!$idClienteLoja || !$idLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $page_url = $_SERVER["BASE_URL"] . 'cliente/ver/' . $idClienteLoja;

        $idClienteLoja = SqidsWrapper::decode($idClienteLoja);
        $clienteLoja = ClienteLojaService::getClienteLojaById($idClienteLoja);

        if (!$clienteLoja || $clienteLoja->getLoja()->getId() !== $idLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clientePI = ClientePIService::getClientePI($clienteLoja->getCliente()->getId()) ?: null;

        $pagination = new Pagination(
            CompraService::totalCompraLojaCliente($clienteLoja->getLoja()->getId(), $clienteLoja->getCliente()->getId(), null),
            $page_url,
            9
        );

        $listCompra = CompraService::listCompraLojaCliente(
            $clienteLoja->getLoja()->getId(),
            $clienteLoja->getCliente()->getId(),
            $pagination->getFirstItemIndex(),
            $pagination->getItensPerPage(),
            null,
        ) ?: [];

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
        $data['compraPagination'] = $pagination;
        $data['view'] = 'loja/cliente/home';

        $this->load('loja/template', $data);
    }

    /**
     * @param $id
     */
    public function detalhe($id = null)
    {
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $id = SqidsWrapper::decode($id);

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja || $clienteLoja->getLoja()->getId() !== Auth::getIdLoja()) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $clientePI = ClientePIService::getClientePI($clienteLoja->getCliente()->getId()) ?: null;
        $lojaConfig = ConfigService::getConfigByLoja(Auth::getIdLoja()) ?: null;
        $maxCredit = $clienteLoja->getMaxCredit() ?: $lojaConfig?->getMaxCredit() ?: 0;

        $data = [
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'cpf' => $clienteLoja->getCliente()->getCpf(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'credito' => $maxCredit,
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
        if (!$id) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $id = SqidsWrapper::decode($id);
        $idLoja = Auth::getIdLoja();

        $clienteLoja = ClienteLojaService::getClienteLojaById($id);

        if (!$clienteLoja || $clienteLoja->getLoja()->getId() != $idLoja) {
            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        $form = Flash::getForm();
        $configLoja = ConfigService::getConfigByLoja($idLoja) ?: null;

        $data = [
            'id' => $clienteLoja->getId(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'creditoMaximo' => $form['ipt-credito'] ?? $clienteLoja->getMaxCredit() ?? $configLoja?->getMaxCredit() ?? 0,
            'ativo' => $form['sel-ativo'] ?? $clienteLoja->getActive(),
            'tokenData' => $clienteLoja->getId(),
        ];
        $data['view'] = 'loja/cliente/edit';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $form = new FormData();
        $idLoja = Auth::getIdLoja();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id');
        $form->setItem('name')->getValueFrom('ipt-nome');
        $form->setItem('email')->getValueFrom('ipt-email');
        $form->setItem('emailCliente')->getValueFrom('ipt-email-cliente');
        $form->setItem('cpf', FormDataType::Cpf)->getValueFrom('ipt-cpf');
        $form->setItem('phone', FormDataType::Telephone)->getValueFrom('ipt-tel');
        $form->setItem('address')->getValueFrom('ipt-endereco');
        $form->setItem('type')->getValueFrom('ipt-tipo', 'n');

        $form->setItem('credit', FormDataType::Float)->getValueFrom('ipt-credito');
        $form->setItem('active', FormDataType::YesNoInput)->getValueFrom('sel-ativo', true);

        $this->checkToken($_SERVER["BASE_URL"] . 'cliente', $form->id);

        Flash::setForm($form->getArray());

        $page = $form->id ? '/editar/' . SqidsWrapper::encode($form->id) : '/novo';
        $type = $form->id ? '' : '?tipo=' . $form->type;
        $baseUrl = $_SERVER["BASE_URL"] . 'cliente';
        $backUrl = $baseUrl . $page . $type;

        if (($form->type == 'n') && !$form->id) {
            ClienteService::getDao()->beginTransation();
            ClientePIService::getDao()->beginTransation();

            $idCliente = ClienteService::salvar(null, $form->cpf, $form->name, $form->email, null, null);
            $idClientePI = ClientePIService::salvar(null, $idCliente ?: 0, $form->address, $form->phone, null);

            if (!$idCliente || !$idClientePI) {
                ClienteService::getDao()->rollback();
                ClientePIService::getDao()->rollback();
            } else {
                ClienteService::getDao()->commit();
                ClientePIService::getDao()->commit();
            }

            ClienteService::sendEmailCompletionLink($idCliente, $idLoja);
        }

        if (($form->type == 'c') && !$form->id) {
            if ($cliente = ClienteService::getClienteByEmail($form->emailCliente)) {
                $idCliente = $cliente->getId();
            }
        }

        if ($form->id) {
            $idCliente = ClienteLojaService::getClienteLojaById($form->id)->getCliente()->getId();
        }

        if ($rowCount = ClienteLojaService::salvar($form->id, $idLoja, $idCliente ?? 0, $form->credit, $form->active)) {
            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($baseUrl);
        }

        if ($rowCount === 0) {
            Flash::setMessage('Nenhum registro alterado', MessageType::Warning);
        }

        $this->redirect($backUrl);
    }
}