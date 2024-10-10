<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Controller;

class LojaController extends Controller
{
    public function index()
    {
        $data['view'] = 'cliente/loja/home';

        $this->load('cliente/template', $data);
    }

    public function detalhe()
    {
        $data['view'] = 'cliente/loja/detail';

        $this->load('cliente/template', $data);
    }
}