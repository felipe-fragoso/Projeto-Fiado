<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Controller;

class ProdutoController extends Controller
{
    public function index()
    {
        $data['view'] = 'loja/produto/home';

        $this->load('loja/template', $data);
    }

    public function novo()
    {
        $data['view'] = 'loja/produto/new';

        $this->load('loja/template', $data);
    }

    public function detalhe()
    {
        $data['view'] = 'loja/produto/detail';

        $this->load('loja/template', $data);
    }
}