<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Enums\MessageType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Models\Entity\ClientePI;
use Fiado\Models\Service\ClientePIService;
use Fiado\Models\Service\ClienteService;

class PerfilController extends Controller
{
    public function index()
    {
        $idCliente = Auth::getIdCliente();
        $clientePI = ClientePIService::getClientePI($idCliente);

        if (!$clientePI) {
            $clientePI = new ClientePI(
                null,
                ClienteService::getClienteById($idCliente),
                'Endereco vazio',
                'Telefone vazio',
                'Descrição vazia'
            );
        }

        $data = [
            'nome' => $clientePI->getCliente()->getName(),
            'cpf' => $clientePI->getCliente()->getCpf(),
            'email' => $clientePI->getCliente()->getEmail(),
            'endereco' => $clientePI->getAddress() ?: 'Endereço vazio',
            'telefone' => $clientePI->getTelephone() ?: 'Telefone vazio',
            'criado' => $clientePI->getCliente()->getDate(),
            'descricao' => $clientePI->getDescription() ?: 'Descrição vazia',
        ];
        $data['view'] = 'cliente/perfil/home';

        $this->load('cliente/template', $data);
    }

    public function editar()
    {
        $idCliente = Auth::getIdCliente();
        $clientePI = ClientePIService::getClientePi($idCliente);

        if (!$clientePI) {
            $clientePI = new ClientePI(null, ClienteService::getClienteById($idCliente), '', '', '');
        }

        $form = Flash::getForm();

        $data = [
            'id' => $clientePI->getId(),
            'nome' => $form['ipt-nome'] ?? $clientePI->getCliente()->getName(),
            'endereco' => $form['ipt-endereco'] ?? $clientePI->getAddress(),
            'telefone' => $form['ipt-telefone'] ?? $clientePI->getTelephone(),
            'descricao' => $form['txt-descricao'] ?? $clientePI->getDescription(),
            'tokenData' => $clientePI->getId(),
        ];
        $data['view'] = 'cliente/perfil/edit';

        $this->load('cliente/template', $data);
    }

    public function salvar()
    {
        $form = new FormData();
        $idCliente = Auth::getIdCliente();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id');
        $form->setItem('name')->getValueFrom('ipt-nome');
        $form->setItem('address')->getValueFrom('ipt-endereco');
        $form->setItem('telephone', FormDataType::Telephone)->getValueFrom('ipt-telefone');
        $form->setItem('description')->getValueFrom('txt-descricao');

        $this->checkToken($_SERVER["BASE_URL"] . 'perfil', $form->id);

        Flash::setForm($form->getArray());

        if ($form->id) {
            $clientePI = ClientePiService::getClientePiById($form->id);
        }

        $successClientePI = ClientePiService::salvar(
            $form->id,
            $idCliente,
            $form->address ?? $clientePI?->getAddress() ?? '',
            $form->telephone ?? $clientePI?->getTelephone() ?? '',
            $form->description ?? $clientePI?->getDescription() ?? '',
        );

        if ($form->name !== null) {
            $cliente = ClienteService::getClienteById($idCliente);
        }

        if (isset($cliente)) {
            $successCliente = ClienteService::salvar(
                $cliente->getId(),
                $cliente->getCpf(),
                $form->name ?? $cliente->getName(),
                $cliente->getEmail(),
                $cliente->getSenha(),
                $cliente->getSenha(),
                $cliente->getDate(),
            );
        }

        if (($successClientePI === 0 && !isset($successCliente))
            || (isset($successCliente) && $successCliente === 0 && $successClientePI === 0)
        ) {
            Flash::setMessage('Nenhum registro alterado', MessageType::Warning);

            $this->redirect($_SERVER["BASE_URL"] . 'perfil/editar');
        }

        if ($successClientePI !== false && $successCliente !== false) {
            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($_SERVER["BASE_URL"] . 'perfil');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'perfil/editar');
    }
}