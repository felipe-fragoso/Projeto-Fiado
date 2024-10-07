<?php

namespace Fiado\Controllers;

use Fiado\Core\Auth;
use Fiado\Core\Controller;

class ClienteController extends Controller
{
    public function __construct()
    {
        if (!Auth::isLogged() || Auth::getSystem() !== 'cliente') {
            $this->redirect($_SERVER["BASE_URL"] . 'auth/login');
        }
    }

    public function index()
    {
        $data['view'] = 'cliente/home';

        $this->load('cliente/template', $data);
    }

    public function compras()
    {
        $data['view'] = 'cliente/compra/home';

        $this->load('cliente/template', $data);
    }

    public function pendente()
    {
        $data['view'] = 'cliente/compra/pending';

        $this->load('cliente/template', $data);
    }

    public function detalhe()
    {
        $data['view'] = 'cliente/compra/detail';

        $this->load('cliente/template', $data);
    }

    public function compraDetalhe()
    {
        $data['view'] = 'cliente/compra/detail';

        $this->load('cliente/template', $data);
    }

    public function loja()
    {
        $data['view'] = 'cliente/loja/home';

        $this->load('cliente/template', $data);
    }

    public function lojaDetalhe()
    {
        $data['view'] = 'cliente/loja/detail';

        $this->load('cliente/template', $data);
    }

    public function perfil()
    {
        $data['view'] = 'cliente/perfil/home';

        $this->load('cliente/template', $data);
    }

    public function perfilEditar()
    {
        $data['view'] = 'cliente/perfil/edit';

        $this->load('cliente/template', $data);
    }
}