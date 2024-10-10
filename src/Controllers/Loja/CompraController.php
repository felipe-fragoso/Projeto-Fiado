<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Controller;

class CompraController extends Controller
{
    public function index()
    {
        $data['view'] = 'loja/compra/home';

        $this->load('loja/template', $data);
    }

    public function pendente()
    {
        $data['view'] = 'loja/compra/pending';

        $this->load('loja/template', $data);
    }

    public function detalhe()
    {
        $data['view'] = 'loja/compra/detail';

        $this->load('loja/template', $data);
    }

    public function nova()
    {
        $data['view'] = 'loja/compra/new';

        $this->load('loja/template', $data);
    }
}