<?php

namespace Fiado\Controllers\Landing;

use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Enums\InputType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Models\Service\AuthService;
use Fiado\Models\Service\ClienteCompletionLinkService;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\LojaService;

class CadastroController extends Controller
{
    public function index()
    {
        $form = new FormData();

        $form->setItem('type')->getValueFrom('tipo', 'c', InputType::Get);

        $data['tipo'] = $form->type;
        $data['view'] = 'signup';

        $this->load('signup', $data);
    }

    public function salvar()
    {
        $this->checkToken($_SERVER["BASE_URL"]);

        $form = new FormData();

        $form->setItem('cpf', FormDataType::Cpf)->getValueFrom('ipt-cpf');
        $form->setItem('cnpj', FormDataType::Cnpj)->getValueFrom('ipt-cnpj');
        $form->setItem('email')->getValueFrom('ipt-email');
        $form->setItem('name')->getValueFrom('ipt-nome');
        $form->setItem('password')->getValueFrom('ipt-senha');
        $form->setItem('conPassword')->getValueFrom('ipt-con-senha');
        $form->setItem('type')->getValueFrom('tipo');

        $urlCadastro = $_SERVER["BASE_URL"] . "cadastro?tipo={$form->type}";
        $urlDashboard = $_SERVER["BASE_URL"] . 'dashboard';

        Flash::setForm($form->getArray());

        if ($form->type === "c") {
            if (!ClienteService::salvar(null, $form->cpf, $form->name, $form->email, $form->password, $form->conPassword)) {
                return $this->redirect($urlCadastro);
            }
        }

        if ($form->type === 'e') {
            if (!LojaService::salvar(null, $form->cnpj, $form->name, $form->email, $form->password, $form->conPassword)) {
                return $this->redirect($urlCadastro);
            }
        }

        if (AuthService::authenticate($form->email, $form->password)) {
            Flash::clearForm();

            return $this->redirect($urlDashboard);
        }

        return $this->redirect($urlCadastro);
    }

    /**
     * @param ?string $token
     */
    public function completar(string $token = null)
    {
        if (!$token) {
            $this->redirect($_SERVER["BASE_URL"]);
        }

        $hash = hash('sha256', urlencode($token) . $_SERVER["HASH_SALT"]);
        $completion = ClienteCompletionLinkService::getClienteCompletionLink($hash) ?: null;

        if (
            $completion
            && ($completion->getUsed() === false)
            && ($completion->getValidUntil() > date('Y-m-d H:i:s', strtotime('now')))
        ) {
            $invalid = false;
        }

        if ($completion && ($completion->getUsed() === false)) {
            $used = false;
        }

        $data['tokenEmail'] = $token;
        $data['tokenInvalido'] = $invalid ?? true;
        $data['tokenUsed'] = $used ?? true;
        $data['view'] = 'completeAccount';

        $this->load('completeAccount', $data);
    }

    public function completa()
    {
        $form = new FormData();

        $form->setItem('tokenEmail')->getValueFrom('hidden-email-token');
        $form->setItem('password')->getValueFrom('ipt-senha');
        $form->setItem('conPassword')->getValueFrom('ipt-con-senha');

        $urlReturn = $_SERVER["BASE_URL"] . 'cadastro/completar/' . urlencode($form->tokenEmail);

        $this->checkToken($urlReturn);

        $hash = hash('sha256', urlencode($form->tokenEmail) . $_SERVER["HASH_SALT"]);
        $completion = ClienteCompletionLinkService::getClienteCompletionLink($hash);

        if (!$completion) {
            return $this->redirect($urlReturn);
        }

        $cliente = ClienteService::getClienteById($completion->getCliente()->getId());

        if (!$cliente) {
            return $this->redirect($urlReturn);
        }

        ClienteCompletionLinkService::getDao()->beginTransation();
        ClienteService::getDao()->beginTransation();

        if (
            !ClienteCompletionLinkService::salvar(
                $completion->getId(),
                $completion->getHash(),
                $completion->getCliente()->getId(),
                $completion->getLoja()->getId(),
                true,
                $completion->getValidUntil()
            )
            || !ClienteService::salvar(
                $cliente->getId(),
                $cliente->getCpf(),
                $cliente->getName(),
                $cliente->getEmail(),
                $form->password,
                $form->conPassword
            )
        ) {
            ClienteCompletionLinkService::getDao()->rollback();
            ClienteService::getDao()->rollback();

            return $this->redirect($urlReturn);
        }

        ClienteCompletionLinkService::getDao()->commit();
        ClienteService::getDao()->commit();

        return $this->redirect($_SERVER["BASE_URL"] . 'auth');
    }

    public function reenviar()
    {
        $form = new FormData();

        $form->setItem('tokenEmail')->getValueFrom('hidden-email-token');

        $this->checkToken($_SERVER["BASE_URL"]);

        $hash = hash('sha256', urlencode($form->tokenEmail) . $_SERVER["HASH_SALT"]);
        $completion = ClienteCompletionLinkService::getClienteCompletionLink($hash);

        if ($completion && ($completion->getUsed() === false)) {
            ClienteService::getDao()->beginTransation();
            ClienteCompletionLinkService::getDao()->beginTransation();

            if (!ClienteService::sendEmailCompletionLink($completion->getCliente()->getId(), $completion->getLoja()->getId())
                || !ClienteCompletionLinkService::salvar(
                    $completion->getId(),
                    $completion->getHash(),
                    $completion->getCliente()->getId(),
                    $completion->getLoja()->getId(),
                    true,
                    $completion->getValidUntil()
                )
            ) {
                ClienteService::getDao()->rollback();
                ClienteCompletionLinkService::getDao()->rollback();
            }

            ClienteService::getDao()->commit();
            ClienteCompletionLinkService::getDao()->commit();
        }

        return $this->redirect($_SERVER["BASE_URL"]);
    }
}