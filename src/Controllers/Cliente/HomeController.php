<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $dados['view'] = 'cliente/home';

        $this->load('cliente/template', $dados);
    }
}