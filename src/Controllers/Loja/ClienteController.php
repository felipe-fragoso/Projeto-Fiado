<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Controller;

class ClienteController extends Controller
{
    public function index()
    {
        $data['view'] = 'loja/cliente/list';

        $this->load('loja/template', $data);
    }

    public function ver()
    {
        $data['view'] = 'loja/cliente/home';

        $this->load('loja/template', $data);
    }

    public function detalhe()
    {
        $data['view'] = 'loja/cliente/detail';

        $this->load('loja/template', $data);
    }

    public function novo()
    {
        $data['view'] = 'loja/cliente/new';

        $this->load('loja/template', $data);
    }

    public function editar()
    {
        $data['view'] = 'loja/cliente/new';

        $this->load('loja/template', $data);
    }
}