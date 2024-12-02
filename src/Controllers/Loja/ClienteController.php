<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Models\Entity\ClienteLoja;
use Fiado\Models\Service\ClienteLojaService;
use Fiado\Models\Service\ClientePIService;
use Fiado\Models\Service\ClienteService;
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
        $clientePI = ClientePIService::getClientePI($clienteLoja->getCliente()->getId());

        $data['data'] = new ViewHelper([
            'id' => $clienteLoja->getId(),
            'nome' => $clienteLoja->getCliente()->getName(),
            'email' => $clienteLoja->getCliente()->getEmail(),
            'telefone' => $clientePI ? $clientePI->getTelephone() : null,
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
        $id = $_POST['ipt-id'] ?? null;
        $name = $_POST['ipt-nome'] ?? null;
        $email = $_POST['ipt-email'] ?? null;
        $emailCliente = $_POST['ipt-email-cliente'] ?? null;
        $cpf = $_POST['ipt-cpf'] ?? null;
        $phone = $_POST['ipt-tel'] ?? null;
        $address = $_POST['ipt-endereco'] ?? null;

        $idLoja = Auth::getId();
        $configLoja = ConfigService::getConfigByLoja($idLoja);

        $credit = $_POST['ipt-credito'] ?? $configLoja?->getMaxCredit() ?? null;
        $active = (($_POST['sel-ativo'] ?? 'S') == 'S') ? true : false;

        $page = $id ? '/editar' : '/novo';
        $type = $emailCliente ? '?tipo=c' : '';
        $baseUrl = $_SERVER["BASE_URL"] . 'cliente';
        $backUrl = $baseUrl . $page . $type;

        if ($email && !$emailCliente && !$id) {
            if (!$idCliente = ClienteService::salvar(null, $cpf, $name, $email, null)) {
                $this->redirect($backUrl);
            }

            ClientePIService::salvar(null, $idCliente, $address, $phone, null);
        } elseif ($emailCliente && !$id) {
            $idCliente = ClienteService::getClienteByEmail($emailCliente)->getId();
        }

        if ($id) {
            $idCliente = ClienteLojaService::getClienteLojaById($id)->getCliente()->getId();
        }

        if (!isset($idCliente)) {
            $this->redirect($backUrl);
        }

        if (ClienteLojaService::salvar($id, $idLoja, $idCliente, $credit, $active)) {
            $this->redirect($baseUrl);
        }

        $this->redirect($backUrl);
    }
}