<?php

namespace Fiado\Controllers\Landing;

use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Enums\InputType;
use Fiado\Enums\MessageType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Models\Service\AuthService;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\LojaService;

class AuthController extends Controller
{
    public function index()
    {
        $data['view'] = 'signin';

        $this->load('signin', $data);
    }

    public function entrar()
    {
        $form = new FormData();

        $form->setItem('email')->getValueFrom('ipt-email');
        $form->setItem('password')->getValueFrom('ipt-senha');

        Flash::setForm($form->getArray());

        if (!$form->email || !$form->password) {
            Flash::setMessage('Por favor preencher os campos', MessageType::Warning);

            $this->redirect($_SERVER["BASE_URL"] . 'auth');
        }

        if (AuthService::authenticate($form->email, $form->password)) {
            $this->redirect($_SERVER["BASE_URL"] . 'dashboard');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'auth');
    }

    public function cadastro()
    {
        $form = new FormData();

        $form->setItem('type')->getValueFrom('tipo', 'c', InputType::Get);

        $data['tipo'] = $form->type;
        $data['view'] = 'signup';

        $this->load('signup', $data);
    }

    /**
     * @return mixed
     */
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

        $urlCadastro = $_SERVER["BASE_URL"] . "auth/cadastro?tipo={$form->type}";
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
}