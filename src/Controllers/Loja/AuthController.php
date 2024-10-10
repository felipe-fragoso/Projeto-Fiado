<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;

class AuthController extends Controller
{
    public function index()
    {
        $this->redirect($_SERVER["BASE_URL"]);
    }

    public function logout()
    {
        Auth::logout();

        $this->redirect($_SERVER["BASE_URL"]);
    }
}