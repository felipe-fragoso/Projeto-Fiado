<?php

namespace Fiado\Controllers;

use Fiado\Core\Controller;

class AuthController extends Controller
{   
    public function login() {
        $data['view'] = 'signin';

        $this->load('signin', $data);
    }

    public function cadastro() {
        $data['view'] = 'signup';

        $this->load('signup', $data);
    }
}