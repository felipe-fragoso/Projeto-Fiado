<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $dados['view'] = 'loja/home';

        $this->load('loja/template', $dados);
    }
}