<?php

namespace Fiado\Controllers\Cliente;

use Fiado\Core\Controller;

class PerfilController extends Controller
{
    public function index()
    {
        $data['view'] = 'cliente/perfil/home';

        $this->load('cliente/template', $data);
    }

    public function editar()
    {
        $data['view'] = 'cliente/perfil/edit';

        $this->load('cliente/template', $data);
    }
}