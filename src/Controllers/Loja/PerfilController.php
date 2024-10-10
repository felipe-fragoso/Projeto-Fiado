<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Controller;

class PerfilController extends Controller
{
    public function index()
    {
        $data['view'] = 'loja/perfil/home';

        $this->load('loja/template', $data);
    }

    public function editar()
    {
        $data['view'] = 'loja/perfil/edit';

        $this->load('loja/template', $data);
    }
}