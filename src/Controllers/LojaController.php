<?php

namespace Fiado\Controllers;

use Fiado\Core\Controller;

class LojaController extends Controller
{
    public function __construct()
    {
        if (!$_SESSION[$_SERVER["USER_SESSION"]] || $_SESSION[$_SERVER["USER_SESSION"]]['type'] !== 'e') {
            $this->redirect($_SERVER["BASE_URL"] . 'auth/login');
        }
    }

    public function logout()
    {
        if (isset($_SESSION[$_SERVER["USER_SESSION"]])) {
            unset($_SESSION[$_SERVER["USER_SESSION"]]);
        }

        $this->redirect($_SERVER["BASE_URL"]);
    }

    public function index()
    {
        $data['view'] = 'loja/home';

        $this->load('loja/template', $data);
    }

    public function compraPendente()
    {
        $data['view'] = 'loja/compra/pending';

        $this->load('loja/template', $data);
    }

    public function compras()
    {
        $data['view'] = 'loja/compra/home';

        $this->load('loja/template', $data);
    }

    public function compraNova()
    {
        $data['view'] = 'loja/compra/new';

        $this->load('loja/template', $data);
    }

    public function compraDetalhe()
    {
        $data['view'] = 'loja/compra/detail';

        $this->load('loja/template', $data);
    }

    public function clientes()
    {
        $data['view'] = 'loja/cliente/list';

        $this->load('loja/template', $data);
    }

    public function cliente()
    {
        $data['view'] = 'loja/cliente/home';

        $this->load('loja/template', $data);
    }

    public function clienteDetalhe()
    {
        $data['view'] = 'loja/cliente/detail';

        $this->load('loja/template', $data);
    }

    public function clienteNovo()
    {
        $data['view'] = 'loja/cliente/new';

        $this->load('loja/template', $data);
    }

    public function produtos()
    {
        $data['view'] = 'loja/produto/home';

        $this->load('loja/template', $data);
    }

    public function produtoNovo()
    {
        $data['view'] = 'loja/produto/new';

        $this->load('loja/template', $data);
    }

    public function produtoDetalhe()
    {
        $data['view'] = 'loja/produto/detail';

        $this->load('loja/template', $data);
    }

    public function perfil()
    {
        $data['view'] = 'loja/perfil/home';

        $this->load('loja/template', $data);
    }

    public function perfilEditar()
    {
        $data['view'] = 'loja/perfil/edit';

        $this->load('loja/template', $data);
    }
}