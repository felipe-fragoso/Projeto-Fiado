<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Controller;

class CompraController extends Controller
{
    public function index()
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
}