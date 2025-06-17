<?php

namespace Fiado\Controllers\Landing;

use Fiado\Core\Controller;
use Fiado\Enums\MessageType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Models\Service\AuthService;

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
}